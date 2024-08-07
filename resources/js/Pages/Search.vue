<script setup>
import AppLayout from '@/Layouts/Main/AppLayout.vue';
import { Head } from '@inertiajs/vue3';
import TextInput from '@/Components/TextInput.vue';
import FollowUser from '@/Components/FollowUser.vue';
import { ref, watch } from 'vue';
import { debounce } from 'lodash';
import axios from 'axios';

const users = ref([]);
const search = ref('');

const props = defineProps({
    user: {
        type: Object,
        required: true,
    }
});

const searchUsers = async () => {
    if (search.value.length > 0) {
        let response = await axios.post(route('search.post'), {
            search: search.value
        });

        users.value = response.data;
    } else {
        users.value = [];
    }
};

const debouncedSearchUsers = debounce(searchUsers, 500);

watch(search, (newValue) => {
    debouncedSearchUsers();
});

</script>

<template>
    <AppLayout :user="props.user">
        <Head title="Pesquisar" />

        <div class="w-[50rem]">
            <TextInput
                v-model="search"
                label="Pesquisar"
                placeholder="Digite o que deseja pesquisar"
                class="w-full"
            />

            <div class="mt-10 bg-white p-4 rounded-lg">
                <h2 class="text-2xl font-bold">Resultados da pesquisa</h2>

                <div class="flex flex-col gap-4 mt-4">
                    <FollowUser
                        v-if="users.length != 0"
                        v-for="user in users"
                        :key="user.id"
                        :user="user"
                    />
                    <div v-else>
                        <p>Nenhum usuário encontrado</p>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
