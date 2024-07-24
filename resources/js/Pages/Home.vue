<script setup>
import AppLayout from '@/Layouts/Main/AppLayout.vue';
import Post from '@/Components/Post.vue';
import { router, usePage, Head, Link, useForm } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';
import Modal from '@/Components/Modal.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

const posts = ref([]);
const nextRouteCursor = ref(null);
const hasMore = ref(false);

onMounted(async () => {
    await fetchPosts();
});

const fetchPosts = async () => {
    try {
        const response = await axios.get(route('post.getPosts'));
        posts.value = response.data.posts;
        nextRouteCursor.value = response.data.nextPageUrl;
        hasMore.value = response.data.hasMorePages;
    } catch (error) {
        console.error('Failed to fetch posts:', error);
    }
};

const loadMore = async () => {
    try {
        const response = await axios.get(nextRouteCursor.value);
        posts.value = [...posts.value, ...response.data.posts];
        nextRouteCursor.value = response.data.nextPageUrl;
        hasMore.value = response.data.hasMorePages;
    } catch (error) {
        console.error('Failed to load more posts:', error);
    }
};

const form = useForm({
    content: '',
});

const submit = () => {
    form.post(route('post.store'), {
        onFinish: () => {
            form.reset('content');
            closeModal();
        },
    });
};

const showModal = ref(false);
const openModal = () => {
    showModal.value = true;
};
const closeModal = () => {
    showModal.value = false;
};
</script>

<template>
    <AppLayout>
        <Head title="Página principal" />

        <div class="flex flex-col gap-8">
            <button class="border flex items-center justify-center py-6 rounded-lg hover:text-secondary-900 hover:scale-110 duration-300" @click="openModal">
                <i class="bx bx-plus text-2xl me-2"></i>
                Novo post
            </button>

            <div v-for="post in posts" :key="post.id">
                <Post :content="post.content" :user-name="post.user_name" />
            </div>

            <button v-if="hasMore" @click="loadMore">Load More</button>
        </div>
    </AppLayout>

    <Modal :show="showModal" maxWidth="2xl" @close="closeModal">
        <template v-slot:default>
            <form @submit.prevent="submit">
                <div class="p-6">
                    <div class="flex justify-between items-center">
                        <h2 class="text-2xl font-medium text-primary-600">Novo post</h2>
                        <button class="hover:scale-150 duration-300 flex items-center p-1" @click="closeModal">
                            <i class='bx bx-x'></i>
                        </button>
                    </div>
                    <div class="mt-4">
                        <InputLabel for="content" value="Conteúdo" />

                        <TextInput
                            id="content"
                            type="text"
                            class="mt-1 block w-full"
                            v-model="form.content"
                            required
                        />

                        <InputError class="mt-2" :message="form.errors.content" />
                    </div>
                    <div class="flex items-center justify-center mt-4">
                        <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                            Criar post
                        </PrimaryButton>
                    </div>
                </div>
            </form>
        </template>
    </Modal>
</template>