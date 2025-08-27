<script setup lang="ts">
import { onMounted, ref, watch } from 'vue';
import Progress from '../ui/progress/Progress.vue';

interface PropsInterface {
  progress?: number
}

const props = withDefaults(defineProps<PropsInterface>(), {
  progress: 0
})

const internalProgress = ref(props.progress)
const isBlinking = ref(true)


watch(internalProgress, (newVal) => {
  if (newVal >= 100) {
    isBlinking.value = false
  }
})

watch(
  () => props.progress,
  (newVal) => {
    if (newVal !== undefined) {
      internalProgress.value = newVal
    }
  }
)

onMounted(() => {
  setInterval(() => {
    if (internalProgress.value < 90) {
      internalProgress.value += 0.1
    }
  }, 100)
})

</script>

<template>
  <div class="w-full">
    <Progress :model-value="internalProgress" :class="{ 'animate-blink': isBlinking }" />
  </div>
</template>

<style scoped>
@keyframes blink {

  0%,
  50%,
  100% {
    opacity: 1;
  }

  25%,
  75% {
    opacity: 0.3;
  }
}

.animate-blink {
  animation: blink 5s infinite;
}
</style>