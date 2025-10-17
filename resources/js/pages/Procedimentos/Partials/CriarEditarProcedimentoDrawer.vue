<script setup lang="ts">
import ComboBox from '@/components/Inputs/ComboBox.vue';
import BarLoading from '@/components/Loading/BarLoading.vue';
import Button from '@/components/ui/button/Button.vue';
import {
  Drawer,
  DrawerClose,
  DrawerContent,
  DrawerFooter,
  DrawerHeader,
  DrawerTitle
} from '@/components/ui/drawer';
import {
  FormControl,
  FormField,
  FormItem,
  FormLabel,
  FormMessage
} from '@/components/ui/form';
import { Input } from '@/components/ui/input';
import { useToasts } from '@/composables/useToasts';
import { ProcedimentoInterface } from '@/Interfaces/Procedimentos/ProcedimentoInterface';
import { getAllEspecialidades } from '@/Services/EspecialidadeService';
import { createProcedimento, editProcedimento } from '@/Services/ProcedimentoService';
import { wait } from '@/Utils';
import { toTypedSchema } from '@vee-validate/zod';
import { useField, useForm } from 'vee-validate';
import { onMounted, ref, watch } from 'vue';
import { z } from 'zod';

const props = withDefaults(
  defineProps<{
    open?: boolean,
    procedimento?: Omit<ProcedimentoInterface, 'preco'> | null
  }>(),
  {
    open: false,
    procedimento: null
  }
);

const emit = defineEmits<{
  (e: 'update:open', value: boolean): void
  (e: 'update:procedimento', value: Omit<ProcedimentoInterface, 'preco'>): void
}>();

const onAnimationEnd = (open: boolean) => {
  emit('update:open', open);
};

const closeDrawer = () => {
  especialidadeSelecionado.value = null;
  form.resetForm();
  emit('update:open', false);
};

const especialidades: any[] = [];
const especialidadeSelecionado = ref<any>(null);

const getEspecialidade = () => {
  getAllEspecialidades()
    .then(async (data) => {
      data.forEach((item) => {
        especialidades.push({
          value: item.id,
          label: item.nome,
        });
      });
    })
    .catch(async (err) => {
      const { error } = useToasts();
      await wait(500);
      error(err instanceof Error ? err.message : "Erro ao buscar procedimentos");
    });
};

onMounted(() => {
  getEspecialidade();
});

watch(() => props.open, (newOpen) => {
  if (newOpen) {
    form.setValues({
      nome: props.procedimento?.nome || ''
    }, false);

    const checkEspecialidades = setInterval(() => {
      if (especialidades.length > 0) {
        const especialidadeEncontrada = especialidades.find(
          esp => esp.label === props.procedimento?.especialidade
        );
        if (especialidadeEncontrada) {
          especialidadeSelecionado.value = { ...especialidadeEncontrada };
          clearInterval(checkEspecialidades);
        }
      }
    }, 100);


    setTimeout(() => clearInterval(checkEspecialidades), 5000);
  } else {
    form.resetForm();
    especialidadeSelecionado.value = null;
  }
});

const formSchema = toTypedSchema(
  z.object({
    nome: z.string({ message: 'Informe o nome do procedimento' })
      .max(255, "Nome do procedimento deve ter no máximo 255 caracteres")
  })
);

const form = useForm({
  validationSchema: formSchema,
  initialValues: {
    nome: props.procedimento?.nome || ''
  }
});

const { value: nome, errorMessage } = useField('nome');

const loading = ref(false);
const progress = ref(0);

const criarEditar = form.handleSubmit(async (values) => {
  if (!especialidadeSelecionado.value) return;
  loading.value = true;
  const nome = values.nome;

  try {
    let procedimento: Omit<ProcedimentoInterface, 'preco'>;

    if (props.procedimento?.id) {
      procedimento = await editProcedimento(props.procedimento.id, { nome, especialidade_id: especialidadeSelecionado.value.value });
    } else {
      procedimento = await createProcedimento(nome, especialidadeSelecionado.value.value);
    }

    progress.value = 100;
    emit('update:procedimento', procedimento);
    await wait(500);
    closeDrawer();
  } catch (err) {
    progress.value = 100;
    const { error } = useToasts();
    await wait(500);
    error(err instanceof Error ? err.message : "Erro ao salvar procedimento");
  } finally {
    loading.value = false;
    progress.value = 0;
  }
});




</script>

<template>
  <Drawer :open="props.open" @close="closeDrawer" @animationEnd="onAnimationEnd" :dismissible="false">
    <DrawerContent>
      <div class="mx-auto">
        <DrawerHeader class="flex flex-col items-center text-center">
          <BarLoading v-if="loading" :progress="progress"></BarLoading>
          <DrawerTitle>Escolha a especialidade do procedimento</DrawerTitle>

          <div class="w-full mt-3">
            <ComboBox v-model:modelValue="especialidadeSelecionado" :items="especialidades"
              placeholder="Selecione uma especialidade..." />
          </div>

          <FormField name="nome" v-slot="{ componentField }">
            <FormItem class="w-full mt-7">
              <FormLabel>Nome do procedimento</FormLabel>
              <FormControl>
                <Input type="text" placeholder="Ex: Eletrocardiograma (ECG)" v-bind="componentField" />
              </FormControl>
              <FormMessage>{{ errorMessage }}</FormMessage>
            </FormItem>
          </FormField>
        </DrawerHeader>

        <DrawerFooter class="flex flex-col gap-2">
          <Button @click="criarEditar" :disabled="loading || !especialidadeSelecionado || !!errorMessage || !nome">
            Salvar
          </Button>

          <DrawerClose class="w-full" @click="closeDrawer">
            <Button variant="outline" class="w-full">
              Cancelar
            </Button>
          </DrawerClose>
        </DrawerFooter>
      </div>
    </DrawerContent>
  </Drawer>
</template>
