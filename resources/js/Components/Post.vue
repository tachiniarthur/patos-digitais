<script setup>
import { ref } from 'vue';
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import axios from 'axios';

const comentario = ref('');
const comentarios = ref([]);
const isLoading = ref(false);
const isTextInputVisible = ref(false);

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

const fetchComments = async () => {
    isLoading.value = true;
    try {
        const response = await axios.get(route('post.getComments', props.postId));
        comentarios.value = response.data.comments;

        setTimeout(() => {
            isLoading.value = false;
        }, 1000);
    } catch (error) {
        console.error('Erro ao carregar posts:', error);
    }
};

const newComment = async () => {
    if (comentario.value == '') {
        return;
    }
    
    isLoading.value = true;
    try {
        const response = await axios.post(route('post.comment'), {
            post_id: props.postId,
            comment: comentario.value,
        });

        if (response.status == 200) {
            comentario.value = '';
        }

        isLoading.value = false;
    } catch (error) {
        console.error('Erro ao comentar na publicação:', error);
    }
};

const toggleTextInput = () => {
    isTextInputVisible.value = !isTextInputVisible.value;

    if (isTextInputVisible.value == true) {
        fetchComments();
    }
};
</script>

<template>
    <div class="flex flex-col gap-3 w-[50rem] bg-secondary-50 p-4 rounded-lg hover:scale-105 duration-300">
        <div class="flex items-center">
            <img
                class="object-cover w-14 h-14 me-2 rounded-full"
                src="https://images.unsplash.com/photo-1531427186611-ecfd6d936c79?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=634&q=80"
                alt="Imagem de perfil do usuário"
            >
            <span class="text-base">{{ props.userName }}</span>
        </div>
        <span class="text-break">
            {{ props.content }}
        </span>
        <div class="flex items-center justify-between w-20">
            <button class="hover:text-green hover:scale-150 duration-300">
                <i class="bx bxs-like font-medium"></i>
            </button>
            <button class="hover:text-red hover:scale-150 duration-300">
                <i class="bx bxs-dislike font-medium"></i>
            </button>
            <button class="hover:text-blue hover:scale-150 duration-300" @click="toggleTextInput">
                <i class="bx bxs-chat font-medium"></i>
            </button>
        </div>
        <div v-if="isTextInputVisible" class="flex flex-col items-start transition ease-in-out duration-300 ">
            <InputLabel
                value="Comentário"
            ></InputLabel>
            <div class="flex w-full gap-2">
                <TextInput
                    type="text"
                    class="mt-1 block w-full"
                    v-model="comentario"
                />
                <button @click="newComment()" class="mt-2 bg-primary-500 text-white px-4 py-2 rounded-lg hover:bg-primary-600 duration-300">
                    Enviar
                </button>
            </div>

            <div v-if="isLoading" class="mt-2">
                <span>Carregando comentários...</span>
            </div>
            <div v-else>
                <div v-for="comment in comentarios">
                    <span>{{ comment.comment }}</span>
                </div>
            </div>
        </div>
    </div>
</template>
