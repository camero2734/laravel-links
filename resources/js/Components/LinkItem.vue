<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';
import InputError from '@/Components/ui/InputError.vue';
import axios, { AxiosError } from 'axios';
import { computed, ref } from 'vue';
import SecondaryButton from './ui/SecondaryButton.vue';
import DangerButton from './ui/DangerButton.vue';

const emit = defineEmits(['edit', 'destroy']);

const props = defineProps<{
  url: string;
  title: string;
  linkId: string;
}>();

const link = computed(() => {
  return {
    url: props.url,
    title: props.title,
    linkId: props.linkId,
  };
});

const form = useForm({
  title: link.value.title,
  url: link.value.url,
});

const isEditing = ref(false);
const editError = ref();

const editingClass = computed(() => {
  return isEditing.value ? 'mb-2' : 'border-none';
});

const editLink = () => {
  if (!isEditing.value) {
    isEditing.value = true;
    return;
  }

  axios.put(route('links.update', link.value.linkId), form.data()).then(() => {
    isEditing.value = false;
    editError.value = undefined;
    emit('edit');
  }).catch(e => {
    console.log("edit error", e);
    if (!(e instanceof AxiosError) || !e.response?.data) return;
    editError.value = e.response.data.message;
  })
};

const deleteLink = () => {
  axios.delete(route('links.destroy', link.value.linkId))
    .then(() => emit('destroy'));
};
</script>

<template>
  <form @submit.prevent="editLink" class="flex items-center justify-between p-4 bg-white dark:bg-gray-800 shadow rounded-lg relative pl-20">
    <a :href="route('links.show', link.linkId)" class="flex-shrink absolute left-0 top-0 h-full w-16 bg-blue-500 flex place-items-center text-center items-center justify-center">🔗</a>
    <div class="flex flex-col">
      <input :disabled="!isEditing" v-model="form.title" type="text" class="bg-transparent text-lg font-semibold text-gray-800 dark:text-gray-200 p-0" :class="editingClass" />
      <input :disabled="!isEditing" v-model="form.url" type="text" class="bg-transparent text-sm text-gray-500 dark:text-gray-400 p-0" :class="editingClass" />
      <InputError :message="editError" />
    </div>
    
    <div class="flex gap-4">
      <SecondaryButton type="submit">{{ isEditing ? 'Save' : 'Edit' }}</SecondaryButton>
      <DangerButton type="button" @click="deleteLink">Delete</DangerButton>
    </div>
  </form>
</template>
