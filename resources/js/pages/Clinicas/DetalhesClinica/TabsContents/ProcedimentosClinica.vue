<script setup lang="ts">
import Card from '@/components/ui/card/Card.vue';
import CardContent from '@/components/ui/card/CardContent.vue';
import Table from '@/components/ui/table/Table.vue';
import TableBody from '@/components/ui/table/TableBody.vue';
import TableCell from '@/components/ui/table/TableCell.vue';
import TableHead from '@/components/ui/table/TableHead.vue';
import TableHeader from '@/components/ui/table/TableHeader.vue';
import TableRow from '@/components/ui/table/TableRow.vue';
import { useIsMobile } from '@/composables/useIsMobile';
import { ProcedimentoInterface } from '@/Interfaces/Procedimentos/ProcedimentoInterface';
import { ColumnDef, FlexRender, getCoreRowModel, Row, useVueTable } from '@tanstack/vue-table';
import { computed, h } from 'vue';


const props = defineProps<{ procedimentos: ProcedimentoInterface[] }>()
const { isMobile } = useIsMobile();

const formataPreco = (preco: number) => {
  const valorReais = preco / 100

  return new Intl.NumberFormat('pt-BR', {
    style: 'currency',
    currency: 'BRL'
  }).format(valorReais)
}

const allColumns: ColumnDef<ProcedimentoInterface>[] = [
  {
    accessorKey: 'nome',
    header: 'Procedimento',
    cell: ({ row }) => h("div", {}, row.getValue("nome")),
  },
  {
    accessorKey: 'especialidade',
    header: 'Especialidade',
    cell: ({ row }) => h("div", {}, row.getValue('especialidade')),
  },
  {
    accessorKey: 'preco',
    header: 'Preço',
    cell: ({ row }) => h("div", {}, formataPreco(row.getValue('preco')))
    ,
  },
];


const columns = computed(() => {
  if (isMobile.value) {
    const nomeCol = allColumns.find(col => col.header === 'Especialidade');
    const precoCol = allColumns.find(col => col.header === 'Preço');
    if (!nomeCol || !precoCol) return [];

    return [
      {
        ...nomeCol,
        cell: ({ row }: { row: Row<ProcedimentoInterface> }) => h('div', {}, row.original.especialidade)
      },
      {
        ...precoCol,
        cell: ({ row }: { row: Row<ProcedimentoInterface> }) => h('div', {}, formataPreco(row.original.preco))
      },
    ];
  }

  return allColumns;
});

const table = computed(() =>
  useVueTable({
    data: props.procedimentos,
    columns: columns.value,
    getCoreRowModel: getCoreRowModel(),
  })
)


</script>

<template>
  <Card>
    <CardContent>
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
              Não possui procedimentos
            </TableCell>
          </TableRow>
        </TableBody>
      </Table>
    </CardContent>
  </Card>
</template>
