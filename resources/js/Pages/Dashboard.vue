<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';

import InputError from '@/Components/ui/InputError.vue';
import InputLabel from '@/Components/ui/InputLabel.vue';
import PrimaryButton from '@/Components/ui/PrimaryButton.vue';
import TextInput from '@/Components/ui/TextInput.vue';
import LinkItem from '@/Components/LinkItem.vue';
import { ref } from 'vue';
import axios, { AxiosError } from 'axios';

interface Link {
    link_id: string;
    url: string;
    title: string;
    created_at: string;
    updated_at: string;
}

defineProps<{
    canResetPassword?: boolean;
    status?: string;
}>();

const form = useForm({
    title: '',
    url: ''
});

const links = ref<Link[] | null>(null);

function fetchLinks() {
    axios.get(route('links.index'))
        .then(response => links.value = response.data);
}

const submitCreateLink = async () => {
    axios.post(route('links.store'), form.data())
        .then(() => {
            console.log("got response");
            form.reset();
            form.clearErrors();
            fetchLinks();
        }).catch(e => {
            if (!(e instanceof AxiosError) || !e.response?.data) return;
            form.setError('title', e.response.data.errors.title?.join(", "));
            form.setError('url', e.response.data.errors.url?.join(", "));
        });
};

// Initial fetch
fetchLinks();
</script>


<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Dashboard</h2>
        </template>

        <section class="text-lg mx-10 mt-5">
            <h3 class="font-semibold text-lg text-gray-800 dark:text-gray-200 leading-tight mb-4">Create a New Link</h3>

            <form @submit.prevent="submitCreateLink">
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

        <section class="text-lg mx-10">
            <h3 class="font-semibold text-lg text-gray-800 dark:text-gray-200 leading-tight mb-4">Existing Links</h3>

            <ul v-if="links" class="flex flex-col gap-4">
                <li v-for="link in links" :key="link.link_id">
                    <LinkItem :url="link.url" :title="link.title" :linkId="link.link_id" @destroy="fetchLinks" @edit="fetchLinks" />
                </li>
            </ul>
        </section>
    </AuthenticatedLayout>
</template>
