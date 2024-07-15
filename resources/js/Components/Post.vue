<script setup>

defineProps({
    post: {
        type: Object,
        required: false,
    },
});

</script>

<template>
    <div class="flex flex-col gap-3 w-[50rem] bg-secondary-50 p-4 rounded-lg">
        <div class="flex items-center">
            <img
                class="object-cover w-14 h-14 me-2 rounded-full"
                src="https://images.unsplash.com/photo-1531427186611-ecfd6d936c79?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=634&q=80"
                alt="Imagem de perfil do usuário"
            >
            <span class="text-base">John Doe</span>
        </div>
        <span class="text-break">
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Atque nesciunt accusamus ea sunt, ad reprehenderit! Nobis iusto nesciunt culpa et, exercitationem labore impedit iure nemo deserunt harum necessitatibus velit possimus.
        </span>
        <div class="flex items-center justify-between w-20">
            <button class="hover:text-green hover:scale-150 duration-300">
                <i class="bx bxs-like font-medium"></i>
            </button>
            <button class="hover:text-red hover:scale-150 duration-300">
                <i class="bx bxs-dislike font-medium"></i>
            </button>
            <button class="hover:text-blue hover:scale-150 duration-300">
                <i class="bx bxs-chat font-medium"></i>
            </button>
        </div>
    </div>
</template>
