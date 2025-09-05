<script setup lang="ts">
import { PacienteInterface } from '@/Interfaces/Pacientes/PacienteInterface';
import TextInfo from '@/components/Info/TextInfo.vue';
import { Card, CardContent } from '@/components/ui/card';

const props = defineProps<{ paciente: PacienteInterface }>()


const infos = props.paciente.enderecos.flatMap((endereco) => [
  { title: 'Cidade', value: endereco.cidade },
  { title: 'CEP', value: endereco.cep },
  { title: 'Estado', value: endereco.estado },
  { title: 'Logradouro', value: endereco.logradouro,  classes: { containerClass: 'col-span-full' }},
  { title: 'Bairro', value: endereco.bairro },
  { title: 'Número', value: endereco.numero },
  { title: 'Complemento', value: endereco.complemento },
]);


</script>

<template>
  <Card v-if="infos.length > 0">
    <CardContent class="grid grid-cols-1 md:grid-cols-3 gap-4">
      <TextInfo v-for="(info, index) in infos" :key="index" :title="info.title" :value="info.value ?? null"
        :container-class="info.classes?.containerClass" />
    </CardContent>
  </Card>
</template>
