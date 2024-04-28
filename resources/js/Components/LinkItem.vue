<script setup lang="ts">
import InputError from '@/Components/ui/InputError.vue';
import axios, { AxiosError } from 'axios';
import { computed, ref } from 'vue';
import DangerButton from './ui/DangerButton.vue';
import SecondaryButton from './ui/SecondaryButton.vue';

const emit = defineEmits(['edit', 'destroy']);

const props = defineProps<{
  url: string;
  title: string;
  linkId: string;
}>();

// The form data to edit the link
const editForm = ref({
  title: props.title,
  url: props.url,
});

// Whether the link is being edited
const isEditing = ref(false);

// Error message when editing the link
const editError = ref();

// Change how the form looks when editing
const editingClass = computed(() => {
  return isEditing.value ? 'mb-2' : 'border-none';
});

const editLink = () => {
  // If not editing, start editing
  if (!isEditing.value) {
    isEditing.value = true;
    return;
  }

  // Otherwise, submit the form
  axios.put(route('links.update', props.linkId), editForm.value).then(() => {
    isEditing.value = false;
    editError.value = undefined;
    emit('edit');
  }).catch(e => {
    if (!(e instanceof AxiosError) || !e.response?.data) return;
    editError.value = e.response.data.message;
  })
};

// Delete the link
const deleteLink = () => {
  axios.delete(route('links.destroy', props.linkId))
    .then(() => emit('destroy'));
};
</script>

<template>
  <form @submit.prevent="editLink" class="flex items-center justify-between p-4 bg-white dark:bg-gray-800 shadow rounded-lg relative pl-20">
    <a :href="route('links.show', props.linkId)" class="flex-shrink absolute left-0 top-0 h-full w-16 bg-blue-500 flex place-items-center text-center items-center justify-center">🔗</a>
    <div class="flex flex-col">
      <input :disabled="!isEditing" v-model="editForm.title" type="text" class="bg-transparent text-lg font-semibold text-gray-800 dark:text-gray-200 p-0" :class="editingClass" />
      <input :disabled="!isEditing" v-model="editForm.url" type="text" class="bg-transparent text-sm text-gray-500 dark:text-gray-400 p-0" :class="editingClass" />
      <InputError :message="editError" />
    </div>
    
    <div class="flex gap-4">
      <SecondaryButton type="submit">{{ isEditing ? 'Save' : 'Edit' }}</SecondaryButton>
      <DangerButton type="button" @click="deleteLink">Delete</DangerButton>
    </div>
  </form>
</template>
