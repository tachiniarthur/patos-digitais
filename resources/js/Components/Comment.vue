<script setup>

const props = defineProps({
    postId: {
        type: Number,
        required: true,
    },
    content: {
        type: String,
        required: true,
    },
    userName: {
        type: String,
        required: true,
    },
});

</script>

<template>
    <div class="flex flex-col gap-3 px-4">
        <div class="flex items-center">
            <div class="flex items-center justify-center">
                <img
                    class="object-cover w-10 h-10 me-2 rounded-full"
                    :src="'https://ui-avatars.com/api/?background=ffd833&color=2c2f33&name='+props.userName"
                    alt="Imagem de perfil do usuário"
                >
                <span class="text-sm">{{ props.userName }}</span>
            </div>
        </div>
        <div class="flex flex-col">
            <span class="text-break text-sm">
                {{ props.content }}
            </span>
        </div>
    </div>
</template>