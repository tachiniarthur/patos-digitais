<script setup>
import AppLayout from '@/Layouts/Main/AppLayout.vue';
import { router, usePage, Head, Link } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';
import Textarea from '@/Components/Textarea.vue';

const props = defineProps({
    user: {
        type: Object,
        required: true,
    }
});

const updateProfile = () => {
    console.log(textValue.value);
};

const textValue = ref('');
</script>

<template>
    <AppLayout
        :user="props.user"
    >
        <Head title="Meu perfil" />

        <div class="flex flex-col items-center bg-secondary-50 rounded-lg w-full py-6 mx-8">
            <div class="flex flex-col items-center">
                <img
                    :src="'https://ui-avatars.com/api/?background=ffd833&color=2c2f33&name='+props.user.name"
                    alt="Avatar"
                    class="w-32 h-32 rounded-lg"
                />
                <h1 class="text-2xl font-bold mt-4">{{ props.user.name }}</h1>
                <p class="text-gray-500">{{ props.user.email }}</p>
                <Textarea
                    v-model="textValue"
                    placeholder="Biográfia"
                ></Textarea>

                <button
                    @click="updateProfile"
                    class="mt-4 bg-primary-500 text-white font-bold py-2 px-4 rounded-lg"
                >
                    Salvar
                </button>
            </div>
        </div>
    </AppLayout>
</template>