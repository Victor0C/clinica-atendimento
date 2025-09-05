<script setup lang="ts">
import { Search } from "lucide-vue-next"
import { Input } from "@/components/ui/input"
import { ref } from "vue";

const props = withDefaults(defineProps<{
  id: string,
  placeholder?: string,
  disabled?: boolean
}>(), {
  placeholder: "Pesquise...",
  disabled: false
})

const emit = defineEmits<{
  (e: "update:modelValue", value: string): void,
  (e: "enter"): void,
}>()

const isFocused = ref(false);
</script>

<template>
  <div class="relative w-full items-center">
    <Input :id="props.id" type="text" :placeholder="props.placeholder" class="pl-10 focus-visible:ring-ring/50"
      @input="emit('update:modelValue', $event.target.value)" @focus="isFocused = true" @blur="isFocused = false"
      :disabled="props.disabled" @keydown.enter="emit('enter')" />
    <span class="absolute start-0 inset-y-0 flex items-center justify-center px-2">
      <Search class="size-6" :class="isFocused ? 'text-[var(--foreground)]' : 'text-muted-foreground'" />
    </span>
  </div>
</template>
