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
import { addProcedimento } from '@/Services/ClinicaServcie';
import { getAllNotInClinica } from '@/Services/ProcedimentoService';
import { wait } from '@/Utils';
import { onMounted, ref } from 'vue';
import { useForm, useField } from 'vee-validate';
import { z } from 'zod';
import { toTypedSchema } from '@vee-validate/zod';

const props = withDefaults(
  defineProps<{ open?: boolean, clinicaId: number }>(),
  { open: false }
);

const emit = defineEmits<{
  (e: 'update:open', value: boolean): void
  (e: 'update:procedimento', value: ProcedimentoInterface[]): void
}>();

const onAnimationEnd = (open: boolean) => {
  emit('update:open', open);
};

const closeDrawer = () => {
  procedimentoSelecionado.value = null;
  form.resetForm();
  emit('update:open', false);
};

const procedimentos: any[] = [];
const procedimentoSelecionado = ref<any>(null);

const getProcedimento = () => {
  getAllNotInClinica(props.clinicaId)
    .then(async (data) => {
      data.forEach((item) => {
        procedimentos.push({
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
  getProcedimento();
});

const formSchema = toTypedSchema(
  z.object({
    preco: z.string({ message: 'Informe um preço' })
      .min(1, "Preço é obrigatório")
      .regex(/^\d+([.,]\d{1,2})?$/, "Preço inválido")
  })
);

const form = useForm({
  validationSchema: formSchema,
  initialValues: {
    preco: ''
  }
});

const { value: preco, errorMessage } = useField('preco');


const convertToCents = (value: string): number => {
  if (!value) return 0;
  const normalized = value.replace(/[^\d,.-]/g, '').replace(',', '.');
  const parsed = parseFloat(normalized);
  return isNaN(parsed) ? 0 : Math.round(parsed * 100);
};

const loading = ref(false);
const progress = ref(0);

const add = form.handleSubmit(async (values) => {
  if (!procedimentoSelecionado.value) return;
  loading.value = true;
  const precoCentavos = convertToCents(values.preco);

  addProcedimento(props.clinicaId, procedimentoSelecionado.value.value, precoCentavos)
    .then(async (clinica) => {
      progress.value = 100;
      emit('update:procedimento', clinica.procedimentos);
      const index = procedimentos.findIndex(p => p.value === procedimentoSelecionado.value.value);
      if (index !== -1) procedimentos.splice(index, 1);
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
          <DrawerTitle>Escolha o procedimento que deseja adicionar</DrawerTitle>

          <div class="w-full mt-3">
            <ComboBox v-model:modelValue="procedimentoSelecionado" :items="procedimentos"
              placeholder="Selecione um procedimento..." />
          </div>

          <FormField name="preco" v-slot="{ componentField }">
            <FormItem class="w-full mt-7">
              <FormLabel>Preço (R$)</FormLabel>
              <FormControl>
                <Input type="text" placeholder="Ex: 120,50" v-bind="componentField" />
              </FormControl>
              <FormMessage>{{ errorMessage }}</FormMessage>
            </FormItem>
          </FormField>
        </DrawerHeader>

        <DrawerFooter class="flex flex-col gap-2">
          <Button @click="add" :disabled="loading || !procedimentoSelecionado || !!errorMessage || !preco">
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
