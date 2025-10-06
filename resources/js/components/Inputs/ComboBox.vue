<script setup lang="ts">
import { Combobox, ComboboxAnchor, ComboboxEmpty, ComboboxGroup, ComboboxInput, ComboboxItem, ComboboxItemIndicator, ComboboxList } from "@/components/ui/combobox";
import { Check, ChevronsUpDown } from "lucide-vue-next";
import { defineEmits, defineProps, ref } from "vue";
import ComboboxTrigger from "../ui/combobox/ComboboxTrigger.vue";

const props = defineProps<{
  items: { value: string; label: string }[];
  placeholder?: string;
  modelValue?: any;
}>();

const emit = defineEmits<{
  (e: 'update:modelValue', value: any): void;
}>();

const onSelect = (item: { value: string; label: string }) => {
  emit('update:modelValue', item);
};

const inputRef = ref<HTMLInputElement | null>(null);


</script>

<template>
  <Combobox by="label" :value="props.modelValue" class="w-full">
    <ComboboxAnchor class="relative w-full">
      <div ref="inputRef" class="relative w-full">
        <ComboboxInput :display-value="(val) => val?.label ?? ''"
          :placeholder="props.placeholder ?? 'Select an item...'" class="w-full" />

        <ComboboxTrigger class="absolute end-0 inset-y-0 flex items-center justify-center px-3">
          <ChevronsUpDown class="size-4 text-muted-foreground" />
        </ComboboxTrigger>

        <ComboboxList>
          <ComboboxEmpty>Não encontrado</ComboboxEmpty>

          <ComboboxGroup>
            <ComboboxItem v-for="item in props.items" :key="item.value" :value="item" @click="onSelect(item)">
              {{ item.label }}
              <ComboboxItemIndicator>
                <Check class="ml-auto h-4 w-4" />
              </ComboboxItemIndicator>
            </ComboboxItem>
          </ComboboxGroup>
        </ComboboxList>
      </div>
    </ComboboxAnchor>
  </Combobox>
</template>
