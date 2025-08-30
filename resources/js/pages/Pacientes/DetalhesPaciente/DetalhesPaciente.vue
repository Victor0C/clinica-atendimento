<script setup lang="ts">
import { PacienteInterface } from '@/Interfaces/Pacientes/PacienteInterface';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import { Tabs, TabsContent, TabsList, TabsTrigger } from '@/components/ui/tabs'
import DadosPessoais from './TabsContents/DadosPessoais.vue';
import DadosEndereco from './TabsContents/DadosEndereco.vue';


const props = defineProps<{ paciente: PacienteInterface }>();


const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Detalhes do paciente',
    href: '/paciente',
  },
];

const tabList = [
  {
    name: 'Dados Pessoais',
    value: 'dados_pessoais',
    component: DadosPessoais
  },
  {
    name: 'Endereço',
    value: 'endereco',
    component: DadosEndereco,
  },
]

</script>

<template>

  <Head :title="props.paciente.nome" />

  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="flex h-full flex-1 flex-col gap-4 p-4 overflow-x-auto">
      <Tabs :default-value="tabList[0].value">
        <TabsList class="bg-[var(--sidebar-primary-foreground)]">
          <TabsTrigger class="data-[state=active]:bg-primary data-[state=active]:text-primary-foreground"
            v-for="(tab, index) in tabList" :key="index" :value="tab.value">
            {{ tab.name }}
          </TabsTrigger>
        </TabsList>
        <TabsContent v-for="(tab, index) in tabList" :key="index" :value="tab.value" class="p-0">
          <component :is="tab.component" :paciente="props.paciente" />
        </TabsContent>

      </Tabs>
    </div>
  </AppLayout>
</template>