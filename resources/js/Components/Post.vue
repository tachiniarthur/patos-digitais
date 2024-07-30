<script setup>
import { ref, onMounted } from 'vue';
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import SkeletonComments from '@/Components/SkeletonComments.vue';
import Comment from '@/Components/Comment.vue';
import axios from 'axios';

const comentario = ref('');
const comentarios = ref([]);
const likes = ref(0);
const dislikes = ref(0);
const comments = ref(0);
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
    countLikes: {
        type: Number,
        required: true,
    },
    countDislikes: {
        type: Number,
        required: true,
    },
    countComments: {
        type: Number,
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
        } else {
            console.error('Erro ao comentar na publicação:', response);
        }

        isLoading.value = false;
        fetchComments();

    } catch (error) {
        console.error('Erro ao comentar na publicação:', error);
    }
};

const newReaction = async (reaction) => {
    isLoading.value = true;
    try {
        const response = await axios.post(route('post.reaction'), {
            post_id: props.postId,
            reaction: reaction,
        });

        console.log(response)
        if (response.status == 200) {
            if (reaction == 'like') {
                likes.value++;
            } else {
                dislike.value++;
            }
        } else {
            console.error('Erro ao reagir na publicação:', response);
        }

        isLoading.value = false;
    } catch (error) {
        console.error('Erro ao reagir na publicação:', error);
    }
};

const toggleTextInput = () => {
    isTextInputVisible.value = !isTextInputVisible.value;

    if (isTextInputVisible.value == true) {
        fetchComments();
    }
};

onMounted(() => {
    likes.value = props.countLikes;
    dislikes.value = props.countDislikes;
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
            <span class="text-base">{{ props.userName }}</span>
        </div>
        <span class="text-break">
            {{ props.content }}
        </span>
        <div class="flex items-center justify-between w-20 gap-4">
            <button class="flex justify-center items-center hover:text-green hover:scale-150 duration-300" @click="newReaction('like')">
                <i class="bx bxs-like font-medium"></i>
                <span class="text-xs font-medium ps-1">{{ likes }}</span>
            </button>
            <button class="flex justify-center items-center hover:text-red hover:scale-150 duration-300" @click="newReaction('dislike')">
                <i class="bx bxs-dislike font-medium"></i>
                <span class="text-xs font-medium ps-1">{{ dislikes }}</span>
            </button>
            <button class="flex justify-center items-center hover:text-blue hover:scale-150 duration-300" @click="toggleTextInput">
                <i class="bx bxs-chat font-medium"></i>
                <span class="text-xs font-medium ps-1">{{ props.countComments }}</span>
            </button>
        </div>
        <div v-if="isTextInputVisible" class="flex flex-col items-start transition ease-in-out duration-300">
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

            <div v-if="isLoading" class="flex flex-col gap-4 w-full mt-5 mb-2">
                <SkeletonComments
                    v-for="n in 3"
                ></SkeletonComments>
            </div>
            <div v-else class="flex flex-col gap-4 w-full mt-5 mb-2">
                <Comment v-if="comentarios.length > 0" v-for="comment in comentarios" :post-id="props.postId" :content="comment.comment" :user-name="props.userName"></Comment>
                
                <div v-else>
                    <p class="text-lg font-medium">Parece que não encontramos nada por aqui ainda... Seja o primeiro a comentar!</p>
                </div>
            </div>
        </div>
    </div>
</template>
