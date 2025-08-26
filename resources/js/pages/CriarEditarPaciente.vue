<script setup lang="ts">
import { Button } from '@/components/ui/button'
import {
  FormControl,
  FormField,
  FormItem,
  FormLabel,
  FormMessage
} from '@/components/ui/form'
import { Input } from '@/components/ui/input'
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select'
import { Textarea } from '@/components/ui/textarea'
import { useToasts } from '@/composables/useToasts'
import AppLayout from '@/layouts/AppLayout.vue'
import { createPaciente } from '@/Services/PacienteService'
import { BreadcrumbItem } from '@/types'
import { Inertia } from '@inertiajs/inertia'
import { Head } from '@inertiajs/vue3'
import { toTypedSchema } from '@vee-validate/zod'
import { useForm } from 'vee-validate'
import * as z from 'zod'



const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Novo paciente',
    href: '/pacientes/novo',
  },
]

const formSchema = toTypedSchema(z.object({
  nome: z.string().min(1, "O nome é obrigatório").max(255),
  data_nascimento: z.string().min(1, "Data de nascimento é obrigatória"),
  cpf: z.string().length(14, "CPF deve ter 14 caracteres"),
  rg: z.string().min(1, "RG é obrigatório").max(20),
  sexo: z.enum(["M", "F", "O"], { errorMap: () => ({ message: "Sexo inválido" }) }),
  telefone_fixo: z.string().max(15).optional().nullable(),
  celular: z.string().min(1, "Celular é obrigatório").max(15),
  email: z.string().email("E-mail inválido").max(255),
  convenio: z.string().max(50).optional().nullable(),
  numero_carteirinha: z.string().max(30).optional().nullable(),
  observacoes: z.string().optional().nullable(),
  status: z.enum(["ativo", "inativo"], { errorMap: () => ({ message: "Status inválido" }) }),

  enderecos: z.array(z.object({
    logradouro: z.string().min(1, "Logradouro é obrigatório").max(255),
    numero: z.string().max(10).optional().nullable(),
    complemento: z.string().max(255).optional().nullable(),
    bairro: z.string().min(1, "Bairro é obrigatório").max(255),
    cidade: z.string().min(1, "Cidade é obrigatória").max(255),
    estado: z.string().length(2, "Estado deve ter 2 caracteres"),
    cep: z.string().length(9, "CEP deve ter 9 caracteres"),
  }))
}))

const form = useForm({
  validationSchema: formSchema,
  initialValues: {
    nome: '',
    data_nascimento: '',
    cpf: '',
    rg: '',
    sexo: 'M',
    telefone_fixo: '',
    celular: '',
    email: '',
    convenio: '',
    numero_carteirinha: '',
    observacoes: '',
    status: 'ativo',
    enderecos: [
      {
        logradouro: '',
        numero: '',
        complemento: '',
        bairro: '',
        cidade: '',
        estado: '',
        cep: '',
      },
    ],
  },
})

const { showToastPromise, showToastManualSuccess } = useToasts();
const onSubmit = form.handleSubmit((values) => {
  showToastPromise(
    createPaciente(values),
    () => {
      Inertia.visit('/pacientes', { preserveState: true });
      return "Paciente cadastrado com sucesso!";
    },
    (err) => (err instanceof Error ? err.message : "Erro ao cadastrar paciente")
  );
})


const testePromise = new Promise((resolve) => {
  setTimeout(() => {
    resolve("ok"); // resolve após 2s
    // ou reject(new Error("Erro de teste")); para testar erro
  }, 2000);
});

const teste = () => {
  showToastManualSuccess(
    testePromise,
    "Paciente cadastrado com sucesso!",
    () => {
      Inertia.visit('/pacientes');
    },
    (err) => (err instanceof Error ? err.message : "Erro ao cadastrar paciente")
  );
};

</script>

<template>

  <Head title="Novo Paciente" />

  <AppLayout :breadcrumbs="breadcrumbs">
    <Button @click="teste">teste</Button>
    <div class="flex flex-col gap-6 p-6 w-full">
      <form @submit.prevent="onSubmit">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <FormField v-slot="{ componentField }" name="nome">
            <FormItem>
              <FormLabel>Nome</FormLabel>
              <FormControl>
                <Input type="text" placeholder="Nome completo" v-bind="componentField" />
              </FormControl>
              <FormMessage />
            </FormItem>
          </FormField>

          <FormField v-slot="{ componentField }" name="data_nascimento">
            <FormItem>
              <FormLabel>Data de nascimento</FormLabel>
              <FormControl>
                <Input type="date" v-bind="componentField" />
              </FormControl>
              <FormMessage />
            </FormItem>
          </FormField>

          <FormField v-slot="{ componentField }" name="cpf">
            <FormItem>
              <FormLabel>CPF</FormLabel>
              <FormControl>
                <Input type="text" placeholder="000.000.000-00" v-bind="componentField" />
              </FormControl>
              <FormMessage />
            </FormItem>
          </FormField>

          <FormField v-slot="{ componentField }" name="rg">
            <FormItem>
              <FormLabel>RG</FormLabel>
              <FormControl>
                <Input type="text" placeholder="RG" v-bind="componentField" />
              </FormControl>
              <FormMessage />
            </FormItem>
          </FormField>

          <FormField v-slot="{ componentField }" name="sexo">
            <FormItem>
              <FormLabel>Sexo</FormLabel>
              <Select v-bind="componentField">
                <FormControl>
                  <SelectTrigger class="w-full">
                    <SelectValue placeholder="Selecione..." />
                  </SelectTrigger>
                </FormControl>
                <SelectContent>
                  <SelectItem value="M">Masculino</SelectItem>
                  <SelectItem value="F">Feminino</SelectItem>
                  <SelectItem value="O">Outro</SelectItem>
                </SelectContent>
              </Select>
              <FormMessage />
            </FormItem>
          </FormField>

          <FormField v-slot="{ componentField }" name="celular">
            <FormItem>
              <FormLabel>Celular</FormLabel>
              <FormControl>
                <Input type="text" placeholder="(00) 00000-0000" v-bind="componentField" />
              </FormControl>
              <FormMessage />
            </FormItem>
          </FormField>

          <FormField v-slot="{ componentField }" name="email">
            <FormItem>
              <FormLabel>Email</FormLabel>
              <FormControl>
                <Input type="email" placeholder="email@exemplo.com" v-bind="componentField" />
              </FormControl>
              <FormMessage />
            </FormItem>
          </FormField>

          <FormField v-slot="{ componentField }" name="convenio">
            <FormItem>
              <FormLabel>Convênio</FormLabel>
              <FormControl>
                <Input type="text" placeholder="Convênio" v-bind="componentField" />
              </FormControl>
              <FormMessage />
            </FormItem>
          </FormField>

          <FormField v-slot="{ componentField }" name="numero_carteirinha">
            <FormItem>
              <FormLabel>Número da carteirinha</FormLabel>
              <FormControl>
                <Input type="text" placeholder="Número da carteirinha" v-bind="componentField" />
              </FormControl>
              <FormMessage />
            </FormItem>
          </FormField>

          <FormField v-slot="{ componentField }" name="status">
            <FormItem>
              <FormLabel>Status</FormLabel>
              <Select v-bind="componentField">
                <FormControl>
                  <SelectTrigger class="w-full">
                    <SelectValue placeholder="Selecione..." />
                  </SelectTrigger>
                </FormControl>
                <SelectContent>
                  <SelectItem value="ativo">Ativo</SelectItem>
                  <SelectItem value="inativo">Inativo</SelectItem>
                </SelectContent>
              </Select>
              <FormMessage />
            </FormItem>
          </FormField>

          <FormField v-slot="{ componentField }" name="observacoes">
            <FormItem class="col-span-full">
              <FormLabel>Observações</FormLabel>
              <FormControl>
                <Textarea placeholder="Observações" v-bind="componentField" />
              </FormControl>
              <FormMessage />
            </FormItem>
          </FormField>

          <FormField v-slot="{ componentField }" name="enderecos[0].cidade">
            <FormItem>
              <FormLabel>Cidade</FormLabel>
              <FormControl>
                <Input type="text" placeholder="Cidade" v-bind="componentField" />
              </FormControl>
              <FormMessage />
            </FormItem>
          </FormField>

          <FormField v-slot="{ componentField }" name="enderecos[0].cep">
            <FormItem>
              <FormLabel>CEP</FormLabel>
              <FormControl>
                <Input type="text" placeholder="00000-000" v-bind="componentField" />
              </FormControl>
              <FormMessage />
            </FormItem>
          </FormField>


          <FormField v-slot="{ componentField }" name="enderecos[0].logradouro">
            <FormItem class="col-span-full">
              <FormLabel>Logradouro</FormLabel>
              <FormControl>
                <Input type="text" placeholder="logradouro" v-bind="componentField" />
              </FormControl>
              <FormMessage />
            </FormItem>
          </FormField>

          <FormField v-slot="{ componentField }" name="enderecos[0].bairro">
            <FormItem>
              <FormLabel>Bairro</FormLabel>
              <FormControl>
                <Input type="text" placeholder="Bairro" v-bind="componentField" />
              </FormControl>
              <FormMessage />
            </FormItem>
          </FormField>

          <FormField v-slot="{ componentField }" name="enderecos[0].estado">
            <FormItem>
              <FormLabel>Estado</FormLabel>
              <FormControl>
                <Input type="text" placeholder="UF" v-bind="componentField" />
              </FormControl>
              <FormMessage />
            </FormItem>
          </FormField>

        </div>


        <div class="w-full flex justify-end mt-4">
          <Button type="submit" class="mt-4">Cadastrar paciente</Button>
        </div>
      </form>
    </div>
  </AppLayout>
</template>
