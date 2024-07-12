<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link } from '@inertiajs/vue3';
import { ref } from 'vue';

defineProps({
    user: {
        type: Object,
        required: false,
    },
});

const user = ref({
    name: 'John Doe',
    email: 'john.doe@gmail.com',
});

</script>

<template>
	<aside class="flex flex-col w-64 h-screen px-4 py-8 overflow-y-auto bg-secondary-500 border-r">
        <a href="#" class="mx-auto">
            <img src="images/logo-pato-prim.svg" class="w-auto h-auto object-cover" alt="Logo Patos Digitais">
        </a>

        <div class="flex flex-col items-center mt-6">
            <img class="object-cover w-24 h-24 mx-2 rounded-full" src="https://images.unsplash.com/photo-1531427186611-ecfd6d936c79?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=634&q=80" alt="avatar">
            <h4 class="mx-2 mt-2 font-medium text-primary-600">{{ user.name }}</h4>
            <p class="mx-2 mt-1 text-sm font-medium text-primary-700">{{ user.email }}</p>
        </div>

        <div class="flex flex-col flex-grow mt-6">
            <nav>
                <a class="flex items-center px-4 py-2 text-primary-700 bg-primary-100 rounded-lg" href="#">
                    <span class="mx-4 font-medium">Página inicial</span>
                </a>
                <a class="flex items-center px-4 py-2 mt-2 text-primary-600 transition-colors duration-300 transform rounded-lg hover:bg-primary-100 hover:text-primary-700" href="#">
                    <span class="mx-4 font-medium">Pesquisar</span>
                </a>
                <a class="flex items-center px-4 py-2 mt-2 text-primary-600 transition-colors duration-300 transform rounded-lg hover:bg-primary-100 hover:text-primary-700" href="#">
                    <span class="mx-4 font-medium">Conversas</span>
                </a>
                <a class="flex items-center px-4 py-2 mt-2 text-primary-600 transition-colors duration-300 transform rounded-lg hover:bg-primary-100 hover:text-primary-700" href="#">
                    <span class="mx-4 font-medium">Novo post</span>
                </a>
            </nav>

            <nav class="mt-auto">
                <a class="flex items-center px-4 py-2 text-primary-600 transition-colors duration-300 transform rounded-lg hover:bg-primary-100 hover:text-primary-700" href="#">
                    <span class="mx-4 font-medium">Configurações</span>
                </a>
                <Link
                    :href="route('logout')"
                    class="flex items-center px-4 py-2 mt-2 text-primary-600 transition-colors duration-300 transform rounded-lg hover:bg-primary-100 hover:text-primary-700"
                >
                    <span class="mx-4 font-medium">Sair</span>
                </Link>
            </nav>
        </div>
    </aside>

</template>