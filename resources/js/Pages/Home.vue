<script setup>
import AppLayout from '@/Layouts/Main/AppLayout.vue';
import Post from '@/Components/Post.vue';
import { router, usePage, Head, Link } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';
import SkeletonPosts from '@/Components/SkeletonPosts.vue';

const props = defineProps({
    user: {
        type: Object,
        required: true,
    }
});

const posts = ref([]);
const nextRouteCursor = ref(null);
const hasMore = ref(false);
const isLoading = ref(false);

onMounted(async () => {
    await fetchPosts();
});

const fetchPosts = async () => {
    isLoading.value = true;
    try {
        const response = await axios.get(route('post.getPosts'));
        posts.value = response.data.posts;
        nextRouteCursor.value = response.data.nextPageUrl;
        hasMore.value = response.data.hasMorePages;
        setTimeout(() => {
            isLoading.value = false;
        }, 1000);
    } catch (error) {
        console.error('Erro ao carregar posts:', error);
    }
};

const loadMore = async () => {
    isLoading.value = true;
    try {
        const response = await axios.get(nextRouteCursor.value);
        posts.value = [...posts.value, ...response.data.posts];
        nextRouteCursor.value = response.data.nextPageUrl;
        hasMore.value = response.data.hasMorePages;
        setTimeout(() => {
            isLoading.value = false;
        }, 1000);
    } catch (error) {
        console.error('Erro ao carregar mais posts:', error);
    }
};
</script>

<template>
    <AppLayout
        :user="props.user"
        @postCreated="fetchPosts"
    >
        <Head title="Página principal" />

        <div class="flex flex-col gap-8" v-if="posts.length > 0">
            <SkeletonPosts v-if="isLoading" v-for="n in 5"></SkeletonPosts>

            <Post
                v-else
                v-for="post in posts"
                :key="post.id"
                :post-id="post.id"
                :post-content="post"
                :user-name="post.user.name"
            />

            <button v-if="hasMore" @click="loadMore">Load More</button>
        </div>

        <div v-else>
            <div class="bg-white p-4 rounded-lg">
                <p class="text-lg font-medium">Parece que não encontramos nada por aqui ainda...</p>
            </div>
        </div>
    </AppLayout>
</template>