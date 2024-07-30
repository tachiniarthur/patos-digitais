<script setup>
import Sidebar from '@/Layouts/Main/Sidebar.vue';

const props = defineProps({
    user: {
        type: Object,
        required: true,
    }
});

const emit = defineEmits(['postCreated']);

const handlePostCreated = () => {
    emit('postCreated');
};
</script>

<template>
    <div class="flex min-h-screen">
        <Sidebar
            :user="props.user"
            @postCreated="handlePostCreated"
        ></Sidebar>
    
        <div class="ml-72 flex-1 flex justify-center min-h-screen bg-secondary-100 py-12">
            <slot></slot>
        </div>
    </div>
</template>