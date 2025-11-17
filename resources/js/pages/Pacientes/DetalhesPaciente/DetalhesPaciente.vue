<script setup lang="ts">
import { PacienteInterface } from '@/Interfaces/Pacientes/PacienteInterface';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, usePage } from '@inertiajs/vue3';
import { Tabs, TabsContent, TabsList, TabsTrigger } from '@/components/ui/tabs'
import DadosPessoais from './TabsContents/DadosPessoais.vue';
import DadosEndereco from './TabsContents/DadosEndereco.vue';
import Button from '@/components/ui/button/Button.vue';
import { ref } from 'vue';
import { deletePaciente } from '@/Services/PacienteService';
import { Inertia } from '@inertiajs/inertia';
import { wait } from '@/Utils';
import { useToasts } from '@/composables/useToasts';
import BarLoading from '@/components/Loading/BarLoading.vue';
import ConfirmAction from '@/components/DialogAlerts/ConfirmAction.vue';
import DadosEncaminhamentos from './TabsContents/DadosEncaminhamentos.vue';


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
  {
    name: 'Encaminhos',
    value: 'encaminhamentos',
    component: DadosEncaminhamentos,
  },
]

const page = usePage();
const searchParams = new URLSearchParams(page.url.split('?')[1] || '');
const currentTab = ref(searchParams.get('tab') || tabList[0].value);

const onChangeTab = (newTab: string) => {
  currentTab.value = newTab;

  const url = `${window.location.pathname}?tab=${newTab}`;
  window.history.replaceState({}, '', url);
};


const loading = ref(false);
const progress = ref(0);


const deletar = () => {
  loading.value = true
  deletePaciente(props.paciente.id)
    .then(async () => {
      progress.value = 100
      await wait(500)
      Inertia.visit('/pacientes')
    })
    .catch(async (err) => {
      progress.value = 100

      const { error } = useToasts()

      await wait(500)

      error(err instanceof Error ? err.message : "Erro ao deletar paciente")

    }).finally(() => {
      loading.value = false
      progress.value = 0
    });
};

</script>

<template>

  <Head :title="props.paciente.nome" />

  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="flex h-full flex-1 flex-col gap-4 p-4 overflow-x-auto">
      <BarLoading v-if="loading" :progress="progress"></BarLoading>
      <Tabs :default-value="currentTab" @update:value="onChangeTab">
        <TabsList class="bg-[var(--sidebar-primary-foreground)]">
          <TabsTrigger class="data-[state=active]:bg-primary data-[state=active]:text-primary-foreground"
            v-for="(tab, index) in tabList" :key="index" :value="tab.value" @click="onChangeTab(tab.value)">
            {{ tab.name }}
          </TabsTrigger>
        </TabsList>
        <TabsContent v-for="(tab, index) in tabList" :key="index" :value="tab.value" class="p-0">
          <component :is="tab.component" :paciente="props.paciente" :enderecos="props.paciente.enderecos"
            :encaminhamentos="props.paciente.encaminhamentos" />
        </TabsContent>
      </Tabs>

      <div class="flex justify-between mt-auto gap-2">
        <ConfirmAction title="Deseja realmente deletar esse paciente?" description="Essa ação não pode ser desfeita."
          :onConfirm="deletar">
          <Button variant="destructive">Deletar</Button>
        </ConfirmAction>
        <div class="flex gap-2">
          <Button variant="outline"
            @click="() => { Inertia.visit(`/pacientes/editar/${props.paciente.id}`) }">Editar</Button>
          <Button @click="() => { Inertia.visit(`/pacientes/${props.paciente.id}/encaminhar`) }">Encaminhar</Button>
        </div>
      </div>
    </div>
  </AppLayout>
</template>