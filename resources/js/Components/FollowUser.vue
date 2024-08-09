<script setup>
import { Link } from '@inertiajs/vue3';
import { onMounted, ref } from 'vue';

const props = defineProps({
    user: {
        type: Object,
        required: false,
    }
});

const isLoading = ref(false);
const followEnable = ref(false);

const follow = async () => {
    isLoading.value = true;
    try {
        const response = await axios.post(route('search.follow'), {
            follower_id: props.user.id,
        });

        if (response.status == 200) {
            if (response.data.type == 'follow') {
                followEnable.value = false;
            } else {
                followEnable.value = true;
            }
        }
    } catch (error) {
        console.error('Erro ao reagir na publicação:', error);
    }
}

onMounted(() => {
    if (!props.user.is_followed) {
        followEnable.value = true;
    }
});
</script>

<template>
    <Link 
        :href="route('profile', props.user.username)"
        class="flex flex-col gap-3 px-6 hover:scale-105 duration-500"
    >
        <div class="flex items-center justify-between">
            <div class="flex items-center justify-center">
                <img
                    class="object-cover w-10 h-10 me-2 rounded-full"
                    :src="'https://ui-avatars.com/api/?background=ffd833&color=2c2f33&name='+props.user.name"
                    alt="Imagem de perfil do usuário"
                >
                <span class="text-sm">{{ props.user.username }}</span>
            </div>
            <div class="flex" v-if="followEnable">
                <button class="hover:text-blue hover:scale-125 duration-500 transform active:scale-[2] transition-transform ease-in-out flex items-center gap-1" @click.prevent="follow()">
                    <i class='bx bx-user-plus font-bold text-xl'></i>
                    <span class="text-sm">Seguir</span>
                </button>
            </div>
        </div>
    </Link>
</template>