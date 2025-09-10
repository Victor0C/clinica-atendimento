<script setup lang="ts">
import BarLoading from '@/components/Loading/BarLoading.vue'
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
import { useToasts } from '@/composables/useToasts'
import { ClinicaInterface } from '@/Interfaces/Clinicas/ClinicaInterface'
import AppLayout from '@/layouts/AppLayout.vue'
import { createClinica, editarClinica } from '@/Services/ClinicaServcie'
import { BreadcrumbItem } from '@/types'
import { wait } from '@/Utils'
import { Inertia } from '@inertiajs/inertia'
import { Head } from '@inertiajs/vue3'
import { toTypedSchema } from '@vee-validate/zod'
import { useForm } from 'vee-validate'
import { ref } from 'vue'
import * as z from 'zod'

const props = withDefaults(
  defineProps<{ clinica: ClinicaInterface }>(),
  {
    clinica: () => ({
      id: 0,
      nome_fantasia: '',
      razao_social: '',
      cnpj: '',
      telefone_fixo: '',
      celular: '',
      email: '',
      enderecos: [
        {
          id: 0,
          logradouro: '',
          numero: null,
          complemento: null,
          bairro: '',
          cidade: '',
          estado: '',
          cep: ''
        }
      ]
    }),
  }
)


const breadcrumbs: BreadcrumbItem[] = [
  {
    title: props.clinica.id ? 'Editar clinica' : 'Novo clinica',
    href: props.clinica.id ? '/clinicas/editar' : '/clinicas/novo',
  },
]


const formSchema = toTypedSchema(
  z.object({
    id: z.number(),
    nome_fantasia: z.string()
      .min(1, "Nome fantasia é obrigatório")
      .max(255, "Nome fantasia deve ter no máximo 255 caracteres"),

    razao_social: z.string()
      .min(1, "Razão social é obrigatória")
      .max(255, "Razão social deve ter no máximo 255 caracteres"),

    cnpj: z.string()
      .length(18, "CNPJ deve ter 18 caracteres (formato 00.000.000/0000-00)"),

    telefone_fixo: z.string()
      .max(15, "Telefone fixo deve ter no máximo 15 caracteres")
      .optional()
      .nullable(),

    celular: z.string()
      .min(1, "Celular é obrigatório")
      .max(15, "Celular deve ter no máximo 15 caracteres"),

    email: z.string()
      .email("E-mail inválido")
      .max(255, "E-mail deve ter no máximo 255 caracteres"),

    enderecos: z.array(
      z.object({
        id: z.number(),
        logradouro: z.string()
          .min(1, "Logradouro é obrigatório")
          .max(255, "Logradouro deve ter no máximo 255 caracteres"),

        numero: z.string()
          .max(10, "Número deve ter no máximo 10 caracteres")
          .optional()
          .nullable(),

        complemento: z.string()
          .max(255, "Complemento deve ter no máximo 255 caracteres")
          .optional()
          .nullable(),

        bairro: z.string()
          .min(1, "Bairro é obrigatório")
          .max(255, "Bairro deve ter no máximo 255 caracteres"),

        cidade: z.string()
          .min(1, "Cidade é obrigatória")
          .max(255, "Cidade deve ter no máximo 255 caracteres"),

        estado: z.string()
          .length(2, "Estado deve ter 2 caracteres (ex: SP, RJ)"),

        cep: z.string()
          .length(9, "CEP deve ter 9 caracteres (formato 00000-000)"),
      })
    )
  })
)

const form = useForm({
  validationSchema: formSchema,
  initialValues: props.clinica
})

const loading = ref(false);
const progress = ref(0);


const onSubmit = form.handleSubmit((values) => {
  loading.value = true
  if (props.clinica.id) {
    editarClinica(values)
      .then(async (clinica) => {
        progress.value = 100
        await wait(500)
        Inertia.visit(`/clinicas/detalhes/${clinica.id}`)
      })
      .catch(async (err) => {
        progress.value = 100

        const { error } = useToasts()

        await wait(500)

        error(err instanceof Error ? err.message : "Erro ao editar clinica")

      }).finally(() => {
        loading.value = false
        progress.value = 0
      });

  } else {
    createClinica(values)
      .then(async (clinica) => {
        progress.value = 100
        await wait(500)
        Inertia.visit(`/clinicas/detalhes/${clinica.id}`)
      })
      .catch(async (err) => {
        progress.value = 100

        const { error } = useToasts()

        await wait(500)

        error(err instanceof Error ? err.message : "Erro ao cadastrar clinica")

      }).finally(() => {
        loading.value = false
        progress.value = 0
      });
  }
});



</script>

<template>

  <Head :title="props.clinica.id ? 'Editar clinica' : 'Nova clinica'" />

  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="flex flex-col gap-6 p-6 w-full">
      <BarLoading v-if="loading" :progress="progress"></BarLoading>

      <form @submit.prevent="onSubmit">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <FormField v-slot="{ componentField }" name="nome_fantasia">
            <FormItem>
              <FormLabel>Nome fantasia</FormLabel>
              <FormControl>
                <Input type="text" placeholder="Nome fantasia" v-bind="componentField" />
              </FormControl>
              <FormMessage />
            </FormItem>
          </FormField>

          <FormField v-slot="{ componentField }" name="razao_social">
            <FormItem>
              <FormLabel>Razão social</FormLabel>
              <FormControl>
                <Input type="text" placeholder="Razão social" v-bind="componentField" />
              </FormControl>
              <FormMessage />
            </FormItem>
          </FormField>

          <FormField v-slot="{ componentField }" name="cnpj">
            <FormItem>
              <FormLabel>CNPJ</FormLabel>
              <FormControl>
                <Input type="text" placeholder="00.000.000/0000-00" v-bind="componentField" />
              </FormControl>
              <FormMessage />
            </FormItem>
          </FormField>

          <FormField v-slot="{ componentField }" name="telefone_fixo">
            <FormItem>
              <FormLabel>Telefone fixo</FormLabel>
              <FormControl>
                <Input type="text" placeholder="(00) 0000-0000" v-bind="componentField" />
              </FormControl>
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

          <!-- Endereços -->
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

          <div class="grid grid-cols-12 gap-4 col-span-full">
            <FormField v-slot="{ componentField }" name="enderecos[0].logradouro">
              <FormItem class="col-span-12 md:col-span-8">
                <FormLabel>Logradouro</FormLabel>
                <FormControl>
                  <Input type="text" placeholder="Logradouro" v-bind="componentField" />
                </FormControl>
                <FormMessage />
              </FormItem>
            </FormField>

            <FormField v-slot="{ componentField }" name="enderecos[0].numero">
              <FormItem class="col-span-12 md:col-span-4">
                <FormLabel>Número</FormLabel>
                <FormControl>
                  <Input type="text" placeholder="S/N" v-bind="componentField" />
                </FormControl>
                <FormMessage />
              </FormItem>
            </FormField>
          </div>

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
              <Select v-bind="componentField">
                <FormControl>
                  <SelectTrigger class="w-full">
                    <SelectValue placeholder="Selecione o estado..." />
                  </SelectTrigger>
                </FormControl>
                <SelectContent>
                  <SelectItem value="AC">Acre</SelectItem>
                  <SelectItem value="AL">Alagoas</SelectItem>
                  <SelectItem value="AP">Amapá</SelectItem>
                  <SelectItem value="AM">Amazonas</SelectItem>
                  <SelectItem value="BA">Bahia</SelectItem>
                  <SelectItem value="CE">Ceará</SelectItem>
                  <SelectItem value="DF">Distrito Federal</SelectItem>
                  <SelectItem value="ES">Espírito Santo</SelectItem>
                  <SelectItem value="GO">Goiás</SelectItem>
                  <SelectItem value="MA">Maranhão</SelectItem>
                  <SelectItem value="MT">Mato Grosso</SelectItem>
                  <SelectItem value="MS">Mato Grosso do Sul</SelectItem>
                  <SelectItem value="MG">Minas Gerais</SelectItem>
                  <SelectItem value="PA">Pará</SelectItem>
                  <SelectItem value="PB">Paraíba</SelectItem>
                  <SelectItem value="PR">Paraná</SelectItem>
                  <SelectItem value="PE">Pernambuco</SelectItem>
                  <SelectItem value="PI">Piauí</SelectItem>
                  <SelectItem value="RJ">Rio de Janeiro</SelectItem>
                  <SelectItem value="RN">Rio Grande do Norte</SelectItem>
                  <SelectItem value="RS">Rio Grande do Sul</SelectItem>
                  <SelectItem value="RO">Rondônia</SelectItem>
                  <SelectItem value="RR">Roraima</SelectItem>
                  <SelectItem value="SC">Santa Catarina</SelectItem>
                  <SelectItem value="SP">São Paulo</SelectItem>
                  <SelectItem value="SE">Sergipe</SelectItem>
                  <SelectItem value="TO">Tocantins</SelectItem>
                </SelectContent>
              </Select>
              <FormMessage />
            </FormItem>
          </FormField>

          <FormField v-slot="{ componentField }" name="enderecos[0].complemento">
            <FormItem class="col-span-full">
              <FormLabel>Complemento</FormLabel>
              <FormControl>
                <Input type="text" placeholder="Complemento" v-bind="componentField" />
              </FormControl>
              <FormMessage />
            </FormItem>
          </FormField>
        </div>



        <div class="w-full flex justify-end mt-4">
          <Button type="submit" class="mt-4">Salvar informações da clinica</Button>
        </div>
      </form>
    </div>
  </AppLayout>
</template>
