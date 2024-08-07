<script setup>
const props = defineProps({
    user: {
        type: Object,
        required: false,
    }
});

const follow = () => {
    console.log('Seguir usuário');
}
</script>

<template>
    <div class="flex flex-col gap-3 px-4">
        <div class="flex items-center justify-between">
            <div class="flex items-center justify-center">
                <img
                    class="object-cover w-10 h-10 me-2 rounded-full"
                    :src="'https://ui-avatars.com/api/?background=ffd833&color=2c2f33&name='+props.user.name"
                    alt="Imagem de perfil do usuário"
                >
                <span class="text-sm">{{ props.user.name }}</span>
            </div>
            <div class="flex">
                <button class="hover:text-blue hover:scale-150 duration-500 transform active:scale-[2] transition-transform ease-in-out" @click="follow()">
                    <i class='bx bx-user-plus font-bold text-xl'></i>
                </button>
            </div>
        </div>
    </div>
</template>