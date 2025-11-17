<script setup lang="ts">
import TextInfo from '@/components/Info/TextInfo.vue';
import ComboBox from '@/components/Inputs/ComboBox.vue';
import BarLoading from '@/components/Loading/BarLoading.vue';
import Button from '@/components/ui/button/Button.vue';
import {
  Card,
  CardContent,
  CardDescription,
  CardHeader,
  CardTitle,
} from '@/components/ui/card';
import { useToasts } from '@/composables/useToasts';
import { ClinicaInterface } from '@/Interfaces/Clinicas/ClinicaInterface';
import { PacienteInterface } from '@/Interfaces/Pacientes/PacienteInterface';
import AppLayout from '@/layouts/AppLayout.vue';
import { encaminhar } from '@/Services/PacienteService';
import { BreadcrumbItem } from '@/types';
import { wait } from '@/Utils';
import { Inertia } from '@inertiajs/inertia';
import { Head } from '@inertiajs/vue3';
import { onMounted, ref } from 'vue';
import { computed } from 'vue';

const props = defineProps<{ paciente: PacienteInterface, clinicas: ClinicaInterface[] }>();
const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Encaminhar paciente',
    href: '/encaminhar',
  },
];

const clinicaSelecionada = ref<any>(null);

const infoPacientes = [
  { label: 'CPF', value: props.paciente.cpf },
  { label: 'RG', value: props.paciente.rg },
  { label: 'Sexo', value: props.paciente.sexo === 'M' ? 'Masculino' : 'Feminino' },
  {
    label: 'Status',
    value: props.paciente.status,
    classes: { valueClass: props.paciente.status === 'ativo' ? 'font-semibold text-green-600' : 'font-semibold text-red-600' }
  },
  { label: 'Celular', value: props.paciente.celular },
  { label: 'Email', value: props.paciente.email },
  { label: 'Convenio', value: props.paciente.convenio },
  { label: 'Nº Carteirinha', value: props.paciente.numero_carteirinha },
]

const infoClinicaSelecionada = computed(() => {
  const selectedIndex = clinicaSelecionada.value?.value;
  const clinica = selectedIndex != null ? props.clinicas[selectedIndex] : undefined;

  const endereco = clinica?.enderecos?.[0];

  return [
    { label: 'CNPJ', value: clinica?.cnpj ?? null },
    { label: 'Nome fantasia', value: clinica?.nome_fantasia ?? null },
    { label: 'Razão social', value: clinica?.razao_social ?? null },

    { label: 'Cidade', value: endereco?.cidade ?? null },
    { label: 'Logradouro', value: endereco?.logradouro ?? null },
    { label: 'Número', value: endereco?.numero ?? null },
    { label: 'Bairro', value: endereco?.bairro ?? null },
    { label: 'Complemento', value: endereco?.complemento ?? null },
    { label: 'CEP', value: endereco?.cep ?? null },
    { label: 'Estado', value: endereco?.estado ?? null },
  ];
});


const comboBoxClinicas = [];
const procedimentoSelecionado = ref<any>(null);

onMounted(() => {
  props.clinicas.forEach((clinica, index) => {
    comboBoxClinicas.push({
      value: index,
      label: clinica.nome_fantasia,
    });
  });
});

const comboBoxProcedimentos = computed(() => {
  const procedimentos: { value: any; label: string }[] = [];

  if (clinicaSelecionada.value !== null) {
    const clinica = props.clinicas[clinicaSelecionada.value.value];
    if (clinica?.procedimentos) {
      clinica.procedimentos.forEach((procedimento: any) => {
        procedimentos.push({
          value: procedimento.id,
          label: procedimento.nome,
        });
      });
    }
  }

  return procedimentos;
});



const loading = ref(false);
const progress = ref(0);

const submitEncaminhamento = () => {
  loading.value = true
  encaminhar(props.paciente.id, props.clinicas[clinicaSelecionada.value.value].id, procedimentoSelecionado.value.value)
    .then(async () => {
      progress.value = 100
      await wait(500)
      Inertia.visit(`/pacientes/detalhes/${props.paciente.id}`)
    })
    .catch(async (err) => {
      progress.value = 100

      const { error } = useToasts()

      await wait(500)

      error(err instanceof Error ? err.message : "Erro ao encaminhar paciente")

    }).finally(() => {
      loading.value = false
      progress.value = 0
    });
}


// Fazer o post para encaminhar o paciente

// Fazer listagem dos encaminhamentos do paciente

// gerar pdf do encaminhamento


</script>
<template>

  <Head :title="'Encaminhar ' + props.paciente.nome" />

  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="flex h-full flex-1 flex-col gap-4 p-4 overflow-x-auto">
      <BarLoading v-if="loading" :progress="progress"></BarLoading>

      <Card>
        <CardHeader>
          <CardTitle>{{ props.paciente.nome }}</CardTitle>
          <CardDescription>Paciente</CardDescription>
        </CardHeader>
        <CardContent class="grid grid-cols-1 md:grid-cols-4 gap-4">
          <TextInfo v-for="(info, index) in infoPacientes" :key="index" :title="info.label" :value="info.value ?? null"
            :value-class="info.classes?.valueClass" />
        </CardContent>
      </Card>

      <Card>
        <CardHeader>
          <CardTitle>
            <div class="w-full">
              <ComboBox v-model:modelValue="clinicaSelecionada" :items="comboBoxClinicas"
                placeholder="Selecione a clinica" />
            </div>
          </CardTitle>
          <CardDescription>Clinica</CardDescription>
        </CardHeader>
        <CardContent>

          <div class="grid grid-cols-1 md:grid-cols-4 gap-4">

            <TextInfo v-for="(info, index) in infoClinicaSelecionada" :key="index" :title="info.label"
              :value="info.value ?? null" />
          </div>

          <div class="w-full mt-8">
            <p class="text-muted-foreground">Procedimento</p>
            <ComboBox v-model:modelValue="procedimentoSelecionado" :items="comboBoxProcedimentos"
              placeholder="Selecione o procedimento" />
          </div>

        </CardContent>
      </Card>

      <div class="flex justify-between mt-auto gap-2">
        <Button variant="destructive"
          @click="() => { Inertia.visit(`/pacientes/detalhes/${props.paciente.id}`) }">Cancelar</Button>
        <Button @click="submitEncaminhamento"
          :disabled="loading || !clinicaSelecionada || !procedimentoSelecionado">Encaminhar</Button>
      </div>


    </div>
  </AppLayout>
</template>
<style></style>