<script setup lang="ts">
import {
  AlertDialog,
  AlertDialogAction,
  AlertDialogCancel,
  AlertDialogContent,
  AlertDialogDescription,
  AlertDialogFooter,
  AlertDialogHeader,
  AlertDialogTitle,
  AlertDialogTrigger,
} from "@/components/ui/alert-dialog"
import Button from "@/components/ui/button/Button.vue";
import { defineProps } from "vue";

const props = withDefaults(
  defineProps<{
    title: string;
    description: string;
    textOnConfirm?: string;
    textOnCancel?: string;
    onConfirm: () => void | Promise<void>;
    onCancel?: () => void | Promise<void>;
  }>(),
  {
    textOnConfirm: 'Confirmar',
    textOnCancel: 'Cancelar',
  },
);

const handleConfirm = () => {
  props.onConfirm();
};

const handleCancel = () => {
  if (props.onCancel) props.onCancel();
};
</script>

<template>
  <AlertDialog>
    <AlertDialogTrigger as-child>
      <slot>
        <Button variant="outline">Abrir</Button>
      </slot>
    </AlertDialogTrigger>

    <AlertDialogContent>
      <AlertDialogHeader>
        <AlertDialogTitle>{{ props.title }}</AlertDialogTitle>
        <AlertDialogDescription>{{ props.description }}</AlertDialogDescription>
      </AlertDialogHeader>

      <AlertDialogFooter>
        <div class="flex justify-between w-full mt-2">
          <AlertDialogCancel @click="handleCancel">{{ props.textOnCancel }}</AlertDialogCancel>
          <AlertDialogAction @click="handleConfirm">{{ props.textOnConfirm }}</AlertDialogAction>
        </div>
      </AlertDialogFooter>
    </AlertDialogContent>
  </AlertDialog>
</template>
