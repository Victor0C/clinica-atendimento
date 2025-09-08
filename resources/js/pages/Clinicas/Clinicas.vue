<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link } from '@inertiajs/vue3';

import type {
  ColumnDef,
} from "@tanstack/vue-table";
import {
  FlexRender,
  getCoreRowModel,
  useVueTable
} from "@tanstack/vue-table";
import { computed, h, ref, watch } from "vue";

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
import { useIsMobile } from '@/composables/useIsMobile';
import { useToasts } from '@/composables/useToasts';
import { ClinicaInterface } from '@/Interfaces/Clinicas/ClinicaInterface';
import { SearchClinicaInterface } from '@/Interfaces/Clinicas/SearchClinicaInterface';
import { getAllClinicas } from '@/Services/ClinicaServcie';
import { wait } from '@/Utils';
import type { Row } from "@tanstack/vue-table";
import { Eye, Plus, Search } from 'lucide-vue-next';


const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Clinicas',
    href: '/clinicas',
  },
];
const { isMobile } = useIsMobile();

const props = defineProps<{ page: ClinicaInterface[] }>();

const localPage = ref<ClinicaInterface[]>([]);

watch(
  () => props.page,
  (newPage) => {
    localPage.value = newPage;
  },
  { immediate: true }
);

const allColumns: ColumnDef<ClinicaInterface>[] = [
  {
    accessorKey: 'id',
    header: "Identificador",
    cell: ({ row }) => h("div", { class: "capitalize" }, row.getValue("id")),
  },
  {
    accessorKey: 'nomeFantasia',
    header: 'Nome Fantasia',
    cell: ({ row }) => h("div", {}, row.getValue("nomeFantasia")),
  },
  {
    accessorKey: 'cnpj',
    header: 'CNPJ',
    cell: ({ row }) => h("div", {}, row.getValue('cnpj')),
  },
  {
    id: "actions",
    header: 'Ações',
    cell: ({ row }) => {
      return h(
        'a',
        {
          href: `/clinicas/detalhes/${row.getValue('id')}`,
          class: 'text-[var(--primary)]',
          title: 'Ver detalhes'
        },
        [
          h(Eye),
        ]
      )
    },
  },
];


const columns = computed(() => {
  if (isMobile.value) {
    const nomeCol = allColumns.find(col => col.header === 'Nome Fantasia');
    if (!nomeCol) return [];

    return [
      {
        ...nomeCol,
        cell: ({ row }: { row: Row<ClinicaInterface> }) =>
          h(
            'a',
            {
              href: `/clinicas/detalhes/${row.original.id}`,
              class: 'text-[var(--primary)]',
              title: 'Ver detalhes'
            },
            [h('div', {}, row.original.nomeFantasia)]
          )
      }
    ];
  }

  return allColumns;
});

const table = computed(() =>
  useVueTable({
    data: localPage.value,
    columns: columns.value,
    getCoreRowModel: getCoreRowModel(),
  })
)

const loading = ref(false);
const progress = ref(0);
const searchParams = ref<SearchClinicaInterface>({
  page: 1,
  perPage: 15,
  cnpj: '',
  razaoSocial: '',
  nomeFantasia: '',
});

const searchValue = ref('');

const isCNPJ = (value: string) => /^\d{2}\.?\d{3}\.?\d{3}\/?\d{4}-?\d{2}$/.test(value);

const isEmail = (value: string) => /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value);

watch(
  searchValue,
  (newValue) => {
    searchParams.value.cnpj = '';
    searchParams.value.razaoSocial = '';
    searchParams.value.nomeFantasia = '';

    if (!newValue) return;

    if (isCNPJ(newValue)) {
      searchParams.value.cnpj = newValue;
    } else if (isEmail(newValue)) {
      searchParams.value.nomeFantasia = newValue;
    } else {
      searchParams.value.razaoSocial = newValue;
    }

    searchParams.value.page = 1;
  }
);

const search = () => {
  loading.value = true
  getAllClinicas(searchParams.value)
    .then(async (newPage) => {
      progress.value = 100
      await wait(500)
      localPage.value = newPage
    })
    .catch(async (err) => {
      progress.value = 100

      const { error } = useToasts()

      await wait(500)

      error(err instanceof Error ? err.message : "Erro ao buscar clinicas")

    }).finally(() => {
      loading.value = false
      progress.value = 0
    });
};

</script>

<template>

  <Head title="Clinicas" />

  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="flex h-full flex-1 flex-col gap-4 p-4 overflow-x-auto">
      <BarLoading v-if="loading" :progress="progress"></BarLoading>
      <div class="flex flex-col sm:flex-row w-full gap-2">
        <div class="flex gap-2 w-full">

          <SearchInput v-model="searchValue" id="1" placeholder="Pesquise pelo nome, email ou cpf do paciente"
            :disabled="loading" @enter="search" />
          <Button @click="search" :disabled="loading">
            <Search />
          </Button>
        </div>
        <Link href="/clinicas/novo">

        <Button class="sm:ml-auto">
          <Plus /> Nova clinica
        </Button>
        </Link>
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