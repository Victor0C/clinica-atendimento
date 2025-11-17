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
import { EspecialidadeInterface } from '@/Interfaces/Especialidades/EspecialidadeInterface';
import { ProcedimentoInterface } from '@/Interfaces/Procedimentos/ProcedimentoInterface';
import { createEspecialidade, getAllEspecialidades, updateEspecialidade } from '@/Services/EspecialidadeService';
import { createProcedimento, editProcedimento } from '@/Services/ProcedimentoService';
import { wait } from '@/Utils';
import { toTypedSchema } from '@vee-validate/zod';
import { useField, useForm } from 'vee-validate';
import { onMounted, ref, watch } from 'vue';
import { z } from 'zod';

const props = withDefaults(
  defineProps<{
    open?: boolean,
    especialidade?: EspecialidadeInterface | null
  }>(),
  {
    open: false,
    especialidade: null
  }
);

const emit = defineEmits<{
  (e: 'update:open', value: boolean): void
  (e: 'update:especialidade', value: EspecialidadeInterface): void
}>();

const onAnimationEnd = (open: boolean) => {
  emit('update:open', open);
};

const closeDrawer = () => {
  form.resetForm();
  emit('update:open', false);
};


watch(() => props.open, (newOpen) => {
  if (newOpen) {
    form.setValues({
      nome: props.especialidade?.nome || ''
    }, false);

  } else {
    form.resetForm();
  }
});

const formSchema = toTypedSchema(
  z.object({
    nome: z.string({ message: 'Informe o nome da especialidade' })
      .max(255, "Nome da especialidade deve ter no máximo 255 caracteres")
  })
);

const form = useForm({
  validationSchema: formSchema,
  initialValues: {
    nome: props.especialidade?.nome || ''
  }
});

const { value: nome, errorMessage } = useField('nome');

const loading = ref(false);
const progress = ref(0);

const criarEditar = form.handleSubmit(async (values) => {
  loading.value = true;
  const nome = values.nome;

  try {
    let especialidade: EspecialidadeInterface;

    if (props.especialidade?.id) {
      especialidade = await updateEspecialidade(props.especialidade.id, { nome });
    } else {
      especialidade = await createEspecialidade({ nome });
    }

    progress.value = 100;
    emit('update:especialidade', especialidade);
    await wait(500);
    closeDrawer();
  } catch (err) {
    progress.value = 100;
    const { error } = useToasts();
    await wait(500);
    error(err instanceof Error ? err.message : "Erro ao salvar especialide");
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
          <DrawerTitle>Informe o nome da especialidade</DrawerTitle>

          <FormField name="nome" v-slot="{ componentField }">
            <FormItem class="w-full mt-3">
              <FormControl>
                <Input type="text" placeholder="Ex: Eletrocardiograma (ECG)" v-bind="componentField" />
              </FormControl>
              <FormMessage>{{ errorMessage }}</FormMessage>
            </FormItem>
          </FormField>
        </DrawerHeader>

        <DrawerFooter class="flex flex-col gap-2">
          <Button @click="criarEditar" :disabled="loading || !!errorMessage || !nome">
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
