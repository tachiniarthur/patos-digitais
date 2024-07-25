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
        console.error('Failed to fetch posts:', error);
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
        console.error('Failed to load more posts:', error);
    }
};
</script>

<template>
    <AppLayout
        :user="props.user"
    >
        <Head title="Página principal" />

        <div class="flex flex-col gap-8">
            <SkeletonPosts v-if="isLoading" v-for="n in 5"></SkeletonPosts>

            <div v-if="!isLoading" v-for="post in posts" :key="post.id">
                <Post :content="post.content" :user-name="post.user_name" />
            </div>

            <button v-if="hasMore" @click="loadMore">Load More</button>
        </div>
    </AppLayout>
</template>