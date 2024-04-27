<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';

import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { ref } from 'vue';

interface Link {
    linkId: string;
    url: string;
    title: string;
    createdAt: string;
    updatedAt: string;
}

defineProps<{
    canResetPassword?: boolean;
    status?: string;
}>();

const form = useForm({
    title: '',
    url: ''
});

const submit = () => {
    form.post(route('link.create'));
};

const links = ref<Link[] | null>(null);
fetch(route('link.index'))
    .then(response => response.json())
    .then(data => links.value = data);

</script>


<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Your Links</h2>
        </template>

        <section class="text-lg">
            <h3 class="font-semibold text-lg text-gray-800 dark:text-gray-200 leading-tight mb-4">Your Links</h3>

            <ul v-if="links">
                <li v-for="link in links" :key="link.linkId">
                    <a :href="link.url" class="text-blue-500">{{ link.title }}</a>
                </li>
            </ul>
        </section>

        <section class="text-lg mx-10">
            <h3 class="font-semibold text-lg text-gray-800 dark:text-gray-200 leading-tight mb-4">Create a New Link</h3>

            <form @submit.prevent="submit">
            <div>
                <InputLabel for="title" value="Title" />

                <TextInput
                    id="title"
                    class="mt-1 block w-full"
                    v-model="form.title"
                    required
                    autofocus
                />

                <InputError class="mt-2" :message="form.errors.title" />
            </div>

            <div class="mt-4">
                <InputLabel for="url" value="URL" />

                <TextInput
                    id="url"
                    class="mt-1 block w-full"
                    v-model="form.url"
                    required
                    autocomplete="current-password"
                />

                <InputError class="mt-2" :message="form.errors.url" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <PrimaryButton class="ms-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Create Link
                </PrimaryButton>
            </div>
        </form>
        </section>
        
    </AuthenticatedLayout>
</template>
