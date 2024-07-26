<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import Modal from '@/Components/Modal.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

const props = defineProps({
    user: {
        type: Object,
        required: false,
    },
});

const showModal = ref(false);

const form = useForm({
    content: '',
});

const newPost = () => {
    form.post(route('post.store'), {
        onFinish: () => {
            form.content = '';
            closeModal();
        },
    });
};

const openModal = () => {
    showModal.value = true;
};
const closeModal = () => {
    showModal.value = false;
};
</script>

<template>
    <aside class="flex flex-col w-72 h-full px-6 py-8 fixed left-0 bg-secondary-500 border-r">
        <a href="#" class="mx-auto">
            <img src="/images/logo-pato-prim.svg" class="w-auto h-auto object-cover" alt="Logo Patos Digitais">
        </a>

        <a href="#" class="flex flex-col items-center mt-6 rounded-lg hover:bg-secondary-400 hover:-translate-y-1 hover:scale-110 duration-300 py-2">
            <img class="object-cover w-24 h-24 mx-2 rounded-full" src="https://images.unsplash.com/photo-1531427186611-ecfd6d936c79?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=634&q=80" alt="avatar">
            <h4 class="mx-2 mt-2 font-medium text-primary-600">{{ user.name }}</h4>
            <p class="mx-2 mt-1 text-sm font-medium text-primary-700">{{ user.email }}</p>
        </a>

        <div class="flex flex-col flex-grow mt-6">
            <nav>
                <Link
                    :href="route('home')"
                    class="flex items-center px-4 py-2"
                    :class="{
                        'text-primary-600 rounded-lg hover:bg-primary-200 hover:-translate-y-1 hover:scale-110 duration-300': !route().current('home'),
                        'bg-primary-100 rounded-lg text-primary-700': route().current('home')
                    }"
                >
                    <i class="bx bxs-home font-medium"></i>
                    <span class="mx-2 font-medium">Página inicial</span>
                </Link>
                <Link
                    href="#"
                    class="flex items-center px-4 py-2 mt-3 text-primary-600 rounded-lg hover:bg-primary-200 hover:-translate-y-1 hover:scale-110 duration-300"
                >
                    <i class="bx bx-search font-medium"></i>
                    <span class="mx-2 font-medium">Pesquisar</span>
                </Link>
                <Link
                    href="#"
                    class="flex items-center px-4 py-2 mt-3 text-primary-600 rounded-lg hover:bg-primary-200 hover:-translate-y-1 hover:scale-110 duration-300"
                >
                    <i class="bx bx-chat font-medium"></i>
                    <span class="mx-2 font-medium">Conversas</span>
                </Link>
                <button
                    class="w-full flex items-center px-4 py-2 mt-3 text-primary-600 rounded-lg hover:bg-primary-200 hover:-translate-y-1 hover:scale-110 duration-300"
                    @click="openModal"
                >
                    <i class="bx bx-add-to-queue font-medium"></i>
                    <span class="mx-2 font-medium">Novo post</span>
                </button>
            </nav>

            <nav class="mt-auto">
                <Link
                    href="#"
                    class="flex items-center px-4 py-2 text-primary-600 rounded-lg hover:bg-primary-200 hover:-translate-y-1 hover:scale-110 duration-300"
                >
                    <i class="bx bx-cog font-medium"></i>
                    <span class="mx-2 font-medium">Configurações</span>
                </Link>
                <Link
                    :href="route('logout')"
                    class="flex items-center px-4 py-2 mt-3 text-primary-600 rounded-lg hover:bg-primary-200 hover:-translate-y-1 hover:scale-110 duration-300"
                >
                    <i class="bx bx-log-out font-medium"></i>
                    <span class="mx-2 font-medium">Sair</span>
                </Link>
            </nav>
        </div>
    </aside>

    <Modal
        :show="showModal"
        maxWidth="2xl"
        @close="closeModal"
    >
        <template v-slot:default>
            <form @submit.prevent="newPost()">
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
