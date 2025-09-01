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
  getPaginationRowModel,
  useVueTable
} from "@tanstack/vue-table";
import { computed, h, ref, watch } from "vue";

import { Button } from "@/components/ui/button";
import {
  Table,
  TableBody,
  TableCell,
  TableHead,
  TableHeader,
  TableRow,
} from "@/components/ui/table";
import SearchInput from '@/components/Inputs/SearchInput.vue';
import { Eye, Plus, Search } from 'lucide-vue-next';
import { PacienteInterface } from '@/Interfaces/Pacientes/PacienteInterface';
import { useIsMobile } from '@/composables/useIsMobile';
import type { Row } from "@tanstack/vue-table";


const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Pacientes',
    href: '/paciente',
  },
];
const { isMobile } = useIsMobile();

const props = defineProps<{ page: PacienteInterface[] }>();

const localPage = ref<PacienteInterface[]>([]);

watch(
  () => props.page,
  (newPage) => {
    localPage.value = newPage;
  },
  { immediate: true }
);

const allColumns: ColumnDef<PacienteInterface>[] = [
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
    accessorKey: 'cpf',
    header: 'CPF',
    cell: ({ row }) => h("div", {}, row.getValue('cpf'))
  },
  {
    id: "actions",
    header: 'Ações',
    cell: ({ row }) => {
      return h(
        'a',
        {
          href: `/pacientes/detalhes/${row.getValue('id')}`,
          class: 'text-[var(--primary)]',
          title: 'Ver detal'
        },
        [
          h(Eye),
        ]
      )
    },

  },
]


const columns = computed(() => {
  if (isMobile.value) {
    const nomeCol = allColumns.find(col => col.header === 'Nome');
    if (!nomeCol) return [];

    return [
      {
        ...nomeCol,
        cell: ({ row }: { row: Row<PacienteInterface> }) =>
          h(
            'a',
            {
              href: `/pacientes/detalhes/${row.original.id}`,
              class: 'text-[var(--primary)]',
              title: 'Ver detalhes'
            },
            [h('div', {}, row.original.nome)]
          )
      }
    ];
  }

  return allColumns;
});




const table = useVueTable({
  data: localPage.value,
  columns: columns.value,
  getCoreRowModel: getCoreRowModel(),
  getPaginationRowModel: getPaginationRowModel(),
})





</script>

<template>

  <Head title="Pacientes" />

  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="flex h-full flex-1 flex-col gap-4 p-4 overflow-x-auto">
      <div class="flex flex-col sm:flex-row w-full gap-2">
        <div class="flex gap-2 w-full">

          <SearchInput id="1" placeholder="Pesquise pelo nome do paciente" />
          <Button>
            <Search />
          </Button>
        </div>
        <Link href="/pacientes/novo">

        <Button class="sm:ml-auto">
          <Plus /> Novo paciente
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
              <template v-for="row in table.getRowModel().rows" :key="row.id">
                <TableRow :data-state="row.getIsSelected() && 'selected'">
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
                No results.
              </TableCell>
            </TableRow>
          </TableBody>
        </Table>
      </div>

      <div class="flex items-center justify-end space-x-2 py-4">

        <div class="space-x-2">
          <Button variant="outline" size="sm" :disabled="!table.getCanPreviousPage()" @click="table.previousPage()">
            Anterior
          </Button>
          <Button variant="outline" size="sm" :disabled="!table.getCanNextPage()" @click="table.nextPage()">
            Próxima
          </Button>
        </div>
      </div>
    </div>


  </AppLayout>
</template>