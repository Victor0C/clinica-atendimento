<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';

import type {
  ColumnDef,
} from "@tanstack/vue-table";
import {
  FlexRender,
  getCoreRowModel,
  useVueTable
} from "@tanstack/vue-table";
import { computed, h, ref, watch } from "vue";

import ConfirmAction from '@/components/DialogAlerts/ConfirmAction.vue';
import SearchInput from '@/components/Inputs/SearchInput.vue';
import BarLoading from '@/components/Loading/BarLoading.vue';
import { Button } from "@/components/ui/button";
import {
  Table,
  TableBody,
  TableCell,
  TableHead,
  TableHeader,
  TableRow,
} from "@/components/ui/table";
import { useToasts } from '@/composables/useToasts';
import { EspecialidadeInterface } from '@/Interfaces/Especialidades/EspecialidadeInterface';
import { ProcedimentoInterface } from '@/Interfaces/Procedimentos/ProcedimentoInterface';
import { deleteEspecialidade, getAllEspecialidades } from '@/Services/EspecialidadeService';
import { wait } from '@/Utils';
import { Pencil, Plus, Search, Trash2 } from 'lucide-vue-next';
import CriarEditarEspecialidadeDrawer from './Partials/CriarEditarEspecialidadeDrawer.vue';


const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Especialidades',
    href: '/especialidades',
  },
];

const props = defineProps<{ page: EspecialidadeInterface[] }>();

const localPage = ref<EspecialidadeInterface[]>([]);
const targetEspecialidade = ref<Omit<EspecialidadeInterface, 'preco'> | null>(null);

watch(
  () => props.page,
  (newPage) => {
    localPage.value = newPage;
  },
  { immediate: true }
);

const { showToastPromise } = useToasts()

const handleDelete = async (id: number) => {
  loading.value = true;
  await showToastPromise(
    deleteEspecialidade(id),
    () => {
      localPage.value = localPage.value.filter(esp => esp.id !== id);
      return 'Especialidade deletada com sucesso';
    },
    () => 'Erro ao deletar especialidade'
  );
  loading.value = false;
};


const editarEspecialidade = (especialidade: EspecialidadeInterface) => {
  targetEspecialidade.value = especialidade;
  criaEditarEspecialidade.value = true;
}

const allColumns: ColumnDef<EspecialidadeInterface>[] = [
  {
    accessorKey: 'id',
    header: "Identificador",
    cell: ({ row }) => h("div", { class: "capitalize" }, row.getValue("id")),
  },
  {
    accessorKey: 'nome',
    header: 'Nome',
    cell: ({ row }) => h("div", {}, row.getValue("nome")),
  },
  {
    accessorKey: 'acoes',
    header: 'Ações',
    cell: ({ row }) =>
      h(
        'div',
        { class: 'flex gap-2' },
        [
          h(Pencil, {
            class: "text-blue-500 cursor-pointer",
            size: 20,
            onClick: () => editarEspecialidade(row.original)
          }),
          h(
            ConfirmAction,
            {
              title: 'Remover essa especialidade?',
              description: 'Essa ação não pode ser desfeita.',
              onConfirm: () => handleDelete(row.original.id),
            },
            {
              default: () => h(Trash2, { class: "text-red-500 cursor-pointer", size: 20 })
            }
          )

        ]
      ),
  },
]

const columns = computed(() => {
  return allColumns;
});

const table = useVueTable({
  get data() {
    return localPage.value
  },
  columns: columns.value,
  getCoreRowModel: getCoreRowModel(),
})

const loading = ref(false);
const progress = ref(0);
const searchValue = ref('');

const search = () => {
  loading.value = true
  getAllEspecialidades(searchValue.value)
    .then(async (newPage) => {
      progress.value = 100
      await wait(500)
      localPage.value = newPage
    })
    .catch(async (err) => {
      progress.value = 100

      const { error } = useToasts()

      await wait(500)

      error(err instanceof Error ? err.message : "Erro ao buscar especialidades")

    }).finally(() => {
      loading.value = false
      progress.value = 0
    });
};

const criaEditarEspecialidade = ref<boolean>(false);

const openCriarEditar = (state: boolean) => {
  targetEspecialidade.value = null;
  criaEditarEspecialidade.value = state
}

const handleUpdateOpen = (value: boolean) => {
  criaEditarEspecialidade.value = value;
};

const updateEspecialidades = (especialidade: EspecialidadeInterface) => {
  const index = localPage.value.findIndex(p => p.id === especialidade.id);
  if (index !== -1) {
    localPage.value = [
      ...localPage.value.slice(0, index),
      especialidade,
      ...localPage.value.slice(index + 1)
    ];
  } else {
    localPage.value = [especialidade, ...localPage.value];
  }
}


</script>

<template>

  <Head title="Especialidades" />

  <AppLayout :breadcrumbs="breadcrumbs">
    <CriarEditarEspecialidadeDrawer :open="criaEditarEspecialidade" @update:open="handleUpdateOpen"
      @update:especialidade="updateEspecialidades" :especialidade="targetEspecialidade" />

    <div class="flex h-full flex-1 flex-col gap-4 p-4 overflow-x-auto">
      <BarLoading v-if="loading" :progress="progress"></BarLoading>
      <div class="flex flex-col sm:flex-row w-full gap-2">
        <div class="flex gap-2 w-full">

          <SearchInput v-model="searchValue" id="1" placeholder="Pesquise pelo nome da especialidade"
            :disabled="loading" @enter="search" />
          <Button @click="search" :disabled="loading">
            <Search />
          </Button>
        </div>

        <Button class="sm:ml-auto" @click="openCriarEditar(true)">
          <Plus /> Nova especialidade
        </Button>

      </div>

      <div class="rounded-md border">
        <Table>
          <TableHeader>
            <TableRow v-for="headerGroup in table.getHeaderGroups()" :key="headerGroup.id">
              <TableHead v-for="header in headerGroup.headers" :key="header.id">
                <FlexRender v-if="!header.isPlaceholder" :render="header.column.columnDef.header"
                  :props="header.getContext()" />
              </TableHead>
            </TableRow>
          </TableHeader>
          <TableBody>
            <template v-if="table.getRowModel().rows?.length">
              <template v-for="(row, index) in table.getRowModel().rows" :key="row.id">
                <TableRow :data-state="row.getIsSelected() && 'selected'"
                  :class="index % 2 === 0 ? 'bg-white' : 'bg-gray-50'">
                  <TableCell v-for="cell in row.getVisibleCells()" :key="cell.id">
                    <FlexRender :render="cell.column.columnDef.cell" :props="cell.getContext()" />
                  </TableCell>
                </TableRow>
                <TableRow v-if="row.getIsExpanded()">
                  <TableCell :colspan="row.getAllCells().length">
                    {{ JSON.stringify(row.original) }}
                  </TableCell>
                </TableRow>
              </template>
            </template>

            <TableRow v-else>
              <TableCell :colspan="columns.length" class="h-24 text-center">
                Sem resultados...
              </TableCell>
            </TableRow>
          </TableBody>
        </Table>
      </div>
    </div>


  </AppLayout>
</template>