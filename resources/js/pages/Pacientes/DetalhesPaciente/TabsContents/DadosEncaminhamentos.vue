<script setup lang="ts">
import ConfirmAction from '@/components/DialogAlerts/ConfirmAction.vue';
import Card from '@/components/ui/card/Card.vue';
import CardContent from '@/components/ui/card/CardContent.vue';
import Table from '@/components/ui/table/Table.vue';
import TableBody from '@/components/ui/table/TableBody.vue';
import TableCell from '@/components/ui/table/TableCell.vue';
import TableHead from '@/components/ui/table/TableHead.vue';
import TableHeader from '@/components/ui/table/TableHeader.vue';
import TableRow from '@/components/ui/table/TableRow.vue';
import { useIsMobile } from '@/composables/useIsMobile';
import { useToasts } from '@/composables/useToasts';
import { EncaminhamentoInterface } from '@/Interfaces/Pacientes/EncaminhamentoInterface';
import { cancelarEncaminhamento } from '@/Services/PacienteService';
import { ColumnDef, FlexRender, getCoreRowModel, Row, useVueTable } from '@tanstack/vue-table';
import { CircleOff, FileDown } from 'lucide-vue-next';
import { computed, h, ref, watch } from 'vue';


const props = defineProps<{ encaminhamentos: EncaminhamentoInterface[] }>()
const { isMobile } = useIsMobile();


const loading = ref(false);
const encaminhamentos = ref([...props.encaminhamentos]);
const { showToastPromise } = useToasts()

watch(() => props.encaminhamentos, (newEncaminhamento: EncaminhamentoInterface[]) => {
  encaminhamentos.value = [...newEncaminhamento];
});

const handleDelete = async (id: number) => {
  loading.value = true;
  await showToastPromise(
    cancelarEncaminhamento(id),
    () => {
      encaminhamentos.value = encaminhamentos.value.filter(enc => enc.id !== id);
      return 'Encaminhamento cancelado com sucesso';
    },
    () => 'Erro ao cancelar encaminhamento'
  );
  loading.value = false;
};

function formatarDataEncaminhamento(data: string): string {
  if (!data) return "";

  const d = new Date(data);

  const dia = String(d.getDate()).padStart(2, "0");
  const mes = String(d.getMonth() + 1).padStart(2, "0");
  const ano = d.getFullYear();

  const horas = String(d.getHours()).padStart(2, "0");
  const minutos = String(d.getMinutes()).padStart(2, "0");
  const segundos = String(d.getSeconds()).padStart(2, "0");

  return `${dia}-${mes}-${ano} ${horas}:${minutos}:${segundos}`;
}


const allColumns: ColumnDef<EncaminhamentoInterface>[] = [
  {
    accessorKey: 'procedimento',
    header: 'Procedimento',
    cell: ({ row }) => h("div", {}, row.original.procedimento.nome),
  },
  {
    accessorKey: 'clinica',
    header: 'Clinica',
    cell: ({ row }) => h("div", {}, row.original.clinica.nome),
  },
  {
    accessorKey: 'Data',
    header: 'Data',
    cell: ({ row }) => h("div", {}, formatarDataEncaminhamento(row.original.data_encaminhamento)),
  },
  {
    accessorKey: 'Ações',
    header: 'Ações',
    cell: ({ row }) =>
      h(
        'div',
        { class: 'flex items-center gap-2' },
        [
          h(
            ConfirmAction,
            {
              title: 'Cancelar esse encaminhamento?',
              description: 'Essa ação não pode ser desfeita.',
              onConfirm: () => handleDelete(row.original.id),
            },
            {
              default: () => h(CircleOff, { class: "text-red-500 cursor-pointer", size: 20 })
            }
          ),
          h(FileDown, {
            title: 'Emitir guia',
            class: "text-green-500 cursor-pointer",
            size: 20,
            onClick: () => window.open(`/pacientes/encaminhamentos/${row.original.id}/pdf`, '_blank'),
          })

        ]
      ),
  },
];


const columns = computed(() => {
  if (isMobile.value) {
    const nomeCol = allColumns.find(col => col.header === 'Procedimento');
    const clinicaCol = allColumns.find(col => col.header === 'Clinica');
    const removerCol = allColumns.find(col => col.header === 'Ações');
    const dataEncaminhamentoCol = allColumns.find(col => col.header === 'Data');
    if (!nomeCol || !clinicaCol || !removerCol) return [];

    return [
      {
        ...nomeCol,
        cell: ({ row }: { row: Row<EncaminhamentoInterface> }) => h('div', {}, row.original.procedimento.nome)
      },
      {
        ...clinicaCol,
        cell: ({ row }: { row: Row<EncaminhamentoInterface> }) => h('div', {}, row.original.clinica.nome)
      },
      {
        ...dataEncaminhamentoCol,
        cell: ({ row }: { row: Row<EncaminhamentoInterface> }) => h('div', {}, formatarDataEncaminhamento(row.original.data_encaminhamento))
      },
      {
        ...removerCol,
        cell: ({ row }: { row: Row<EncaminhamentoInterface> }) => h(
          ConfirmAction,
          {
            title: 'Cancelar esse encaminhamento?',
            description: 'Essa ação não pode ser desfeita.',
            onConfirm: () => handleDelete(row.original.id),
          },
          {
            default: () => h(CircleOff, {
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
    data: encaminhamentos.value,
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
              Não possui encaminhamentos
            </TableCell>
          </TableRow>
        </TableBody>
      </Table>
    </CardContent>
  </Card>
</template>
