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
                    src="https://images.unsplash.com/photo-1531427186611-ecfd6d936c79?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=634&q=80"
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