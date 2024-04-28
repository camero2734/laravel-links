<script setup lang="ts">
import axios from 'axios';
import { computed } from 'vue';

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

const editLink = () => {
  console.log('edit', link.value.linkId);
};

const deleteLink = () => {
  axios.delete(route('links.destroy', link.value.linkId))
    .then(() => emit('destroy'));
};
</script>

<template>
    <div class="flex items-center justify-between p-4 bg-white dark:bg-gray-800 shadow rounded-lg">
        <div>
            <a :href="link.url" class="text-blue-500">{{ link.title }}</a>
            <p class="text-sm text-gray-500 dark:text-gray-400">{{ link.url }}</p>
        </div>

        <div class="flex gap-4">
            <button @click="editLink" class="text-blue-500">Edit</button>
            <button @click="deleteLink" class="text-red-500">Delete</button>
        </div>
    </div>
</template>
