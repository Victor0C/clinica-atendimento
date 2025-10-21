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
import { computed, h, ref, watch } from 'vue';
import { Trash2 } from 'lucide-vue-next';
import ConfirmAction from '@/components/DialogAlerts/ConfirmAction.vue';
import { removeProcedimento } from '@/Services/ClinicaServcie';
import { useToasts } from '@/composables/useToasts';


const props = defineProps<{ procedimentos: ProcedimentoInterface[], clinica_id: number }>()
const { isMobile } = useIsMobile();

const formataPreco = (preco: number) => {
  const valorReais = preco / 100

  return new Intl.NumberFormat('pt-BR', {
    style: 'currency',
    currency: 'BRL'
  }).format(valorReais)
}

const loading = ref(false);
const procedimentos = ref([...props.procedimentos]);
const { showToastPromise } = useToasts()

watch(() => props.procedimentos, (newProcedimentos: ProcedimentoInterface[]) => {
  procedimentos.value = [...newProcedimentos];
});

const handleDelete = async (id: number) => {
  loading.value = true;
  await showToastPromise(
    removeProcedimento(props.clinica_id, id),
    () => {
      procedimentos.value = procedimentos.value.filter(proc => proc.id !== id);
      return 'Procedimento removido com sucesso';
    },
    () => 'Erro ao remover procedimento'
  );
  loading.value = false;
};

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
  {
    accessorKey: 'Remover',
    header: 'Remover',
    cell: ({ row }) =>
      h(
        'div',
        {},
        [
          h(
            ConfirmAction,
            {
              title: 'Remover esse procedimento?',
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
];


const columns = computed(() => {
  if (isMobile.value) {
    const nomeCol = allColumns.find(col => col.header === 'Procedimento');
    const precoCol = allColumns.find(col => col.header === 'Preço');
    const removerCol = allColumns.find(col => col.header === 'Remover');
    if (!nomeCol || !precoCol || !removerCol) return [];

    return [
      {
        ...nomeCol,
        cell: ({ row }: { row: Row<ProcedimentoInterface> }) => h('div', {}, row.original.nome)
      },
      {
        ...precoCol,
        cell: ({ row }: { row: Row<ProcedimentoInterface> }) => h('div', {}, formataPreco(row.original.preco))
      },
      {
        ...removerCol,
        cell: ({ row }: { row: Row<ProcedimentoInterface> }) => h(
          ConfirmAction,
          {
            title: 'Remover esse procedimento?',
            description: 'Essa ação não pode ser desfeita.',
            onConfirm: () => handleDelete(row.original.id),
          },
          {
            default: () => h(Trash2, {
              class: `text-red-500 ${loading.value ? 'opacity-50' : 'cursor-pointer'}`,
              size: 20,
              'aria-disabled': loading.value
            })
          }
        )
      },
    ];
  }

  return allColumns;
});

const table = computed(() =>
  useVueTable({
    data: procedimentos.value,
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
