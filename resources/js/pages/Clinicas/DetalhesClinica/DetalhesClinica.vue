<script setup lang="ts">
import { ClinicaInterface } from '@/Interfaces/Clinicas/ClinicaInterface';
import { deleteClinica } from '@/Services/ClinicaServcie';
import { wait } from '@/Utils';
import ConfirmAction from '@/components/DialogAlerts/ConfirmAction.vue';
import BarLoading from '@/components/Loading/BarLoading.vue';
import Button from '@/components/ui/button/Button.vue';
import { Tabs, TabsContent, TabsList, TabsTrigger } from '@/components/ui/tabs';
import { useToasts } from '@/composables/useToasts';
import AppLayout from '@/layouts/AppLayout.vue';
import DadosEndereco from '@/pages/Pacientes/DetalhesPaciente/TabsContents/DadosEndereco.vue';
import { type BreadcrumbItem } from '@/types';
import { Inertia } from '@inertiajs/inertia';
import { Head, usePage } from '@inertiajs/vue3';
import { ref } from 'vue';
import DadosClinica from './TabsContents/DadosClinica.vue';
import ProcedimentosClinica from './TabsContents/ProcedimentosClinica.vue';



const props = defineProps<{ clinica: ClinicaInterface }>();


const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Detalhes da clinica',
    href: '/clinicas',
  },
];


const tabList = [
  {
    name: 'Dados da Clinica',
    value: 'dados_clinica',
    component: DadosClinica
  },
  {
    name: 'Endereço',
    value: 'endereco',
    component: DadosEndereco,
  },
  {
    name: 'Procedimentos',
    value: 'procedimentos',
    component: ProcedimentosClinica,
  },
]

const page = usePage();
const searchParams = new URLSearchParams(page.url.split('?')[1] || '');
const currentTab = ref(searchParams.get('tab') || tabList[0].value);
const loading = ref(false);
const progress = ref(0);


const deletar = () => {
  loading.value = true
  deleteClinica(props.clinica.id)
    .then(async () => {
      progress.value = 100
      await wait(500)
      Inertia.visit('/clinicas')
    })
    .catch(async (err) => {
      progress.value = 100

      const { error } = useToasts()

      await wait(500)

      error(err instanceof Error ? err.message : "Erro ao deletar clinica")

    }).finally(() => {
      loading.value = false
      progress.value = 0
    });
};

const onChangeTab = (newTab: string) => {
  currentTab.value = newTab;

  const url = `${window.location.pathname}?tab=${newTab}`;
  window.history.replaceState({}, '', url);
};

</script>

<template>

  <Head :title="props.clinica.nome_fantasia" />

  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="flex h-full flex-1 flex-col gap-4 p-4 overflow-x-auto">
      <BarLoading v-if="loading" :progress="progress"></BarLoading>
      <Tabs :default-value="currentTab" @update:value="onChangeTab">
        <TabsList class="bg-[var(--sidebar-primary-foreground)]">
          <TabsTrigger v-for="(tab, index) in tabList" :key="index" :value="tab.value" @click="onChangeTab(tab.value)"
            class="data-[state=active]:bg-primary data-[state=active]:text-primary-foreground">
            {{ tab.name }}
          </TabsTrigger>
        </TabsList>

        <TabsContent v-for="(tab, index) in tabList" :key="index" :value="tab.value" class="p-0">
          <component :is="tab.component" :clinica="props.clinica" :enderecos="props.clinica.enderecos"
            :procedimentos="props.clinica.procedimentos" />
        </TabsContent>
      </Tabs>

      <div class="flex justify-between mt-auto">
        <ConfirmAction title="Deseja realmente deletar essa clinica?" description="Essa ação não pode ser desfeita."
          :onConfirm="deletar">
          <Button variant="destructive">Deletar</Button>
        </ConfirmAction>
        <Button variant="outline"
          @click="() => { Inertia.visit(`/clinicas/editar/${props.clinica.id}`) }">Editar</Button>
      </div>
    </div>
  </AppLayout>
</template>