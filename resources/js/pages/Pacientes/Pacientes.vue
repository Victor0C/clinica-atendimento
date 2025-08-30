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
import { h } from "vue";

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
import { Plus, Search } from 'lucide-vue-next';


const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Pacientes',
    href: '/paciente',
  },
];

export interface Payment {
  id: string
  amount: number
  status: "pending" | "processing" | "success" | "failed"
  email: string
}

const data: Payment[] = [
  {
    id: "m5gr84i9",
    amount: 316,
    status: "success",
    email: "ken99@yahoo.com",
  },
  {
    id: "3u1reuv4",
    amount: 242,
    status: "success",
    email: "Abe45@gmail.com",
  },
  {
    id: "derv1ws0",
    amount: 837,
    status: "processing",
    email: "Monserrat44@gmail.com",
  },
  {
    id: "5kma53ae",
    amount: 874,
    status: "success",
    email: "Silas22@gmail.com",
  },
  {
    id: "bhqecj4p",
    amount: 721,
    status: "failed",
    email: "carmella@hotmail.com",
  },
]

const columns: ColumnDef<Payment>[] = [
  {
    accessorKey: "status",
    header: "Status",
    cell: ({ row }) => h("div", { class: "capitalize" }, row.getValue("status")),
  },
  {
    accessorKey: "email",
    header: 'Email',
    cell: ({ row }) => h("div", { class: "lowercase" }, row.getValue("email")),
  },
  {
    accessorKey: "amount",
    header: () => h("div", { class: "text-right" }, "Amount"),
    cell: ({ row }) => {
      const amount = Number.parseFloat(row.getValue("amount"))

      const formatted = new Intl.NumberFormat("pt-BR", {
        style: "currency",
        currency: "BRL",
      }).format(amount)

      return h("div", { class: "text-right font-medium" }, formatted)
    },
  },
  {
    id: "actions",
    header: 'Ações',
    cell: () => {
      return 'teste';

    },
  },
]

const table = useVueTable({
  data,
  columns,
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