<script setup>
import AppLayout from '@/Layouts/Main/AppLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import Post from '@/Components/Post.vue';

defineProps({
});

</script>

<template>
    <AppLayout>
        <Head title="Página principal"></Head>

        <div class="flex flex-col gap-8">
            <button class="border flex items-center justify-center py-6 rounded-lg hover:text-secondary-900 hover:scale-110 duration-300">
                <i class="bx bx-plus text-2xl me-2"></i>
                Novo post
            </button>

            <Post></Post>
            <Post></Post>
            <Post></Post>
            <Post></Post>
            <Post></Post>
            <Post></Post>
            <Post></Post>
        </div>
    </AppLayout>
</template>
