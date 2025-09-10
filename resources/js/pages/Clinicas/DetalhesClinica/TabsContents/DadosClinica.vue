<script setup lang="ts">
import { ClinicaInterface } from '@/Interfaces/Clinicas/ClinicaInterface';
import TextInfo from '@/components/Info/TextInfo.vue';
import { Card, CardContent } from '@/components/ui/card';

const props = defineProps<{ clinica: ClinicaInterface }>()

const infos = [
  { title: 'Nome fantasia', value: props.clinica.nome_fantasia },
  { title: 'Razão social', value: props.clinica.razao_social },
  { title: 'CNPJ', value: props.clinica.cnpj },
  { title: 'Email', value: props.clinica.email },
  { title: 'Telefone fixo', value: props.clinica.telefone_fixo },
  { title: 'Celular', value: props.clinica.celular },
]
</script>

<template>
  <Card>
    <CardContent class="grid grid-cols-1 md:grid-cols-4 gap-4">
      <TextInfo v-for="(info, index) in infos" :key="index" :title="info.title" :value="info.value ?? null" />
    </CardContent>
  </Card>
</template>
