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
import { createProcedimento } from '@/Services/ProcedimentoService';
import { wait } from '@/Utils';
import { toTypedSchema } from '@vee-validate/zod';
import { useField, useForm } from 'vee-validate';
import { onMounted, ref } from 'vue';
import { z } from 'zod';

const props = withDefaults(
  defineProps<{ open?: boolean }>(),
  { open: false }
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

const formSchema = toTypedSchema(
  z.object({
    nome: z.string({ message: 'Informe o nome do procedimento' })
      .min(2, "Nome do procedimento é obrigatório")
      .max(255, "Nome do procedimento deve ter no máximo 255 caracteres")
  })
);

const form = useForm({
  validationSchema: formSchema,
  initialValues: {
    nome: ''
  }
});

const { value: nome, errorMessage } = useField('nome');

const loading = ref(false);
const progress = ref(0);

const add = form.handleSubmit(async (values) => {
  if (!especialidadeSelecionado.value) return;
  loading.value = true;
  const nome = values.nome;

  createProcedimento(nome, especialidadeSelecionado.value.value)
    .then(async (procedimento: Omit<ProcedimentoInterface, 'preco'>) => {
      progress.value = 100;
      emit('update:procedimento', procedimento);
      await wait(500);
      closeDrawer();
    })
    .catch(async (err) => {
      progress.value = 100;
      const { error } = useToasts();
      await wait(500);
      error(err instanceof Error ? err.message : "Erro ao adicionar procedimento");
    })
    .finally(() => {
      loading.value = false;
      progress.value = 0;
    });
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
                <Input type="text" placeholder="Ex: Cardiologia" v-bind="componentField" />
              </FormControl>
              <FormMessage>{{ errorMessage }}</FormMessage>
            </FormItem>
          </FormField>
        </DrawerHeader>

        <DrawerFooter class="flex flex-col gap-2">
          <Button @click="add" :disabled="loading || !especialidadeSelecionado || !!errorMessage || !nome">
            Adicionar
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
