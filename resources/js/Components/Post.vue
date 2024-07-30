<script setup>
import { ref, onMounted } from 'vue';
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import SkeletonComments from '@/Components/SkeletonComments.vue';
import Comment from '@/Components/Comment.vue';
import axios from 'axios';

const comentario = ref('');
const comentarios = ref([]);

const content = ref('');
const likes = ref(0);
const userLiked = ref(false);
const dislikes = ref(0);
const userDisliked = ref(false);
const comments = ref(0);

const isLoading = ref(false);
const isLoadingComments = ref(false);
const isTextInputVisible = ref(false);

const props = defineProps({
    postId: {
        type: Number,
        required: true,
    },
    postContent: {
        type: Object,
        required: true,
    },
    userName: {
        type: String,
        required: true,
    },
});

const fetchComments = async () => {
    isLoadingComments.value = true;
    try {
        const response = await axios.get(route('post.getComments', props.postId));
        comentarios.value = response.data.comments;

        setTimeout(() => {
            isLoadingComments.value = false;
        }, 1000);
    } catch (error) {
        console.error('Erro ao carregar posts:', error);
    }
};

const newComment = async () => {
    if (comentario.value == '') {
        return;
    }
    
    isLoadingComments.value = true;
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

        isLoadingComments.value = false;
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

        if (response.status == 200) {
            let content = document.getElementById('post-' + props.postId);

            if (reaction == 'like') {
                let button = content.querySelector('.bx.bxs-like');
                if (userLiked.value) {
                    likes.value--;
                    userLiked.value = false;
                    button.classList.remove('text-green');
                } else {
                    likes.value++;
                    userLiked.value = true;
                    button.classList.add('text-green');
                }
            } else if (reaction == 'dislike') {
                let button = content.querySelector('.bx.bxs-dislike');
                if (userDisliked.value) {
                    dislikes.value--;
                    userDisliked.value = false;
                    button.classList.remove('text-red');
                } else {
                    dislikes.value++;
                    userDisliked.value = true;
                    button.classList.add('text-red');
                }
            }
        } else {
            console.error('Erro ao reagir na publicação:', response);
        }

        isLoading.value = false;
    } catch (error) {
        console.error('Erro ao reagir na publicação:', error);
        isLoading.value = false;
    }
};

const toggleTextInput = () => {
    isTextInputVisible.value = !isTextInputVisible.value;

    if (isTextInputVisible.value == true) {
        fetchComments();
    }
};

onMounted(() => {
    content.value = props.postContent.content;
    likes.value = props.postContent.likes_count;
    userLiked.value = props.postContent.user_liked;
    dislikes.value = props.postContent.dislikes_count;
    userDisliked.value = props.postContent.user_disliked;
    comments.value = props.postContent.comments_count;

    let contentPost = document.getElementById('post-' + props.postId);
    if (userLiked.value) {
        let button = contentPost.querySelector('.bx.bxs-like');
        button.classList.add('text-green');
    }

    if (userDisliked.value) {
        let button = contentPost.querySelector('.bx.bxs-dislike');
        button.classList.add('text-red');
    }
});
</script>

<template>
    <div class="flex flex-col gap-3 w-[50rem] bg-secondary-50 p-4 rounded-lg">
        <div class="flex items-center">
            <img
                class="object-cover w-14 h-14 me-2 rounded-full"
                :src="'https://ui-avatars.com/api/?background=ffd833&color=2c2f33&name='+props.userName"
                alt="Imagem de perfil do usuário"
            >
            <span class="text-base">{{ props.userName }}</span>
        </div>
        <span class="text-break">
            {{ content }}
        </span>
        <div :id="'post-' + props.postId" class="flex items-center justify-between w-20 gap-4">
            <button class="flex justify-center items-center hover:text-green hover:scale-150 duration-500 transform active:scale-[2] transition-transform ease-in-out" @click="newReaction('like')">
                <i class="bx bxs-like font-medium"></i>
                <span class="text-xs font-medium ps-1">{{ likes }}</span>
            </button>
            <button class="flex justify-center items-center hover:text-red hover:scale-150 duration-500 transform active:scale-[2] transition-transform ease-in-out" @click="newReaction('dislike')">
                <i class="bx bxs-dislike font-medium"></i>
                <span class="text-xs font-medium ps-1">{{ dislikes }}</span>
            </button>
            <button class="flex justify-center items-center hover:text-blue hover:scale-150 duration-500 transform active:scale-[2] transition-transform ease-in-out" @click="toggleTextInput">
                <i class="bx bxs-chat font-medium"></i>
                <span class="text-xs font-medium ps-1">{{ comments }}</span>
            </button>
        </div>
        <Transition name="fade">
            <div v-if="isTextInputVisible" class="min-h-[22rem] flex flex-col items-start overflow-auto pe-2" :class="{'max-h-[22rem]': isTextInputVisible }">
                <InputLabel value="Comentário"></InputLabel>
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
                <div v-if="isLoadingComments" class="flex flex-col gap-4 w-full mt-5 mb-2">
                    <SkeletonComments v-for="n in 3"></SkeletonComments>
                </div>
                <div v-else class="flex flex-col gap-4 w-full mt-5 mb-2">
                    <Comment v-if="comentarios.length > 0" v-for="comment in comentarios" :post-id="props.postId" :content="comment.comment" :user-name="props.userName"></Comment>
                    <div v-else>
                        <p class="text-lg font-medium">Parece que não encontramos nada por aqui ainda... Seja o primeiro a comentar!</p>
                    </div>
                </div>
            </div>
        </Transition>
    </div>
</template>

<style scoped>
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.5s ease;
}

.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}
</style>