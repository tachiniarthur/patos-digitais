<script setup>
import Sidebar from '@/Layouts/Main/Sidebar.vue';
</script>

<template>
    <div class="flex min-h-screen">
        <Sidebar></Sidebar>
    
        <div class="ml-64 flex-1 flex justify-center min-h-screen bg-secondary-100 py-12">
            <slot></slot>
        </div>
    </div>
</template>