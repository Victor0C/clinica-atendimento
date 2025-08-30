<script setup lang="ts">
import Separator from '@/components/ui/separator/Separator.vue';

const props = defineProps<{
  title: string,
  value: string | number | null,
  containerClass?: string,
  titleClass?: string,
  valueClass?: string,
  separatorClass?: string
}>()
</script>

<template>
  <div :class="props.containerClass ?? 'w-full'">
    <p :class="props.titleClass ?? 'text-muted-foreground'">{{ props.title }}</p>
    <p :class="`${props.valueClass ?? ''} break-words whitespace-normal`">{{ props.value ?? '-' }}</p>
    <Separator :class="props.separatorClass" />
  </div>
</template>
