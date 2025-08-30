<script setup lang="ts">
import { PacienteInterface } from '@/Interfaces/Pacientes/PacienteInterface'
import TextInfo from '@/components/Info/TextInfo.vue';
import { Card, CardContent } from '@/components/ui/card'

const props = defineProps<{ paciente: PacienteInterface }>()

function formatDate(date: string | null | undefined): string {
  if (!date) return '-';
  const d = new Date(date);
  const day = String(d.getDate()).padStart(2, '0');
  const month = String(d.getMonth() + 1).padStart(2, '0');
  const year = d.getFullYear();
  return `${day}/${month}/${year}`;
}

const infos = [
  { title: 'Nome', value: props.paciente.nome },
  { title: 'CPF', value: props.paciente.cpf },
  { title: 'RG', value: props.paciente.rg },
  {
    title: 'Status',
    value: props.paciente.status,
    classes: { valueClass: props.paciente.status === 'ativo' ? 'font-semibold text-green-600' : 'font-semibold text-red-600' }
  },
  { title: 'Data de nascimento', value: formatDate(props.paciente.data_nascimento) },
  { title: 'Email', value: props.paciente.email },
  { title: 'Telefone fixo', value: props.paciente.telefone_fixo },
  { title: 'Celular', value: props.paciente.celular },
  { title: 'Sexo', value: props.paciente.sexo === 'M' ? 'Masculino' : 'Feminino' },
  { title: 'Convênio', value: props.paciente.convenio },
  { title: 'Nº Carteirinha', value: props.paciente.numero_carteirinha },
  {
    title: 'Observações',
    value: props.paciente.observacoes,
    classes: { containerClass: 'col-span-full' }
  },
]
</script>

<template>
  <Card>
    <CardContent class="grid grid-cols-1 md:grid-cols-4 gap-4">
      <TextInfo v-for="(info, index) in infos" :key="index" :title="info.title" :value="info.value ?? null"
        :container-class="info.classes?.containerClass" :value-class="info.classes?.valueClass" />
    </CardContent>
  </Card>
</template>
