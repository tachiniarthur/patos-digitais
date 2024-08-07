<script setup>
import AppLayout from '@/Layouts/Main/AppLayout.vue';
import { router, usePage, Head, Link } from '@inertiajs/vue3';
import { ref, onMounted, watch } from 'vue';
import Textarea from '@/Components/Textarea.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import Select from '@/Components/Select.vue';

const props = defineProps({
    user: {
        type: Object,
        required: true,
    }
});

const user = ref(props.user);
const isLoading = ref(false);
const nome = ref('');
const email = ref('');
const biografia = ref('');
const selectedOption = ref('');
const selectOptions = ref([
    { value: 'man', text: 'Homem' },
    { value: 'woman', text: 'Mulher' },
    { value: 'others', text: 'Outro' },
]);
const dataNascimento = ref('');
const telefone = ref('');
const cep = ref('');
const cidade = ref('');
const logradouro = ref('');
const bairro = ref('');
const numero = ref('');
const estado = ref('');

const formatCep = (value) => {
    value = value.replace(/\D/g, '');
    if (value.length > 5) {
        value = value.replace(/^(\d{5})(\d{1,3})/, '$1-$2');
    }
    return value;
};

const handleNull = (value) => {
    return value == null ? '' : value;
};

onMounted(() => {
    nome.value = handleNull(props.user.name);
    email.value = handleNull(props.user.email);
    biografia.value = handleNull(props.user.biography);
    selectedOption.value = handleNull(props.user.gender);
    dataNascimento.value = handleNull(props.user.birth_date);
    telefone.value = handleNull(props.user.phone);
    cep.value = handleNull(props.user.zip_code);
    logradouro.value = handleNull(props.user.street);
    bairro.value = handleNull(props.user.neighborhood);
    cidade.value = handleNull(props.user.city);
    estado.value = handleNull(props.user.state);
    numero.value = handleNull(props.user.number);
});

watch(cep, (value) => {
    if (!value) {
        return;
    }

    const formattedValue = formatCep(value);
    if (formattedValue != value) {
        cep.value = formattedValue;
    }
    if (formattedValue.length == 9) {
        const cleanCep = formattedValue.replace('-', '');
        fetch(`https://viacep.com.br/ws/${cleanCep}/json/`)
            .then(response => response.json())
            .then(data => {
                cidade.value = data.localidade;
                logradouro.value = data.logradouro;
                bairro.value = data.bairro;
                estado.value = data.uf;
            });
    }
});

const updateProfile = async () => {
    isLoading.value = true;

    try {
        const response = await axios.post(route('profile.update'), {
            user_id: props.user.id,
            name: nome.value,
            email: email.value,
            biography: biografia.value,
            gender: selectedOption.value,
            birth_date: dataNascimento.value,
            phone: telefone.value,
            zip_code: cep.value,
            street: logradouro.value,
            neighborhood: bairro.value,
            city: cidade.value,
            state: estado.value,
            number: numero.value,
        });

        if (response.status === 200) {
            user.value = response.data.user;

            router.visit(route('profile', nome.value));
        }
        
        setTimeout(() => {
            isLoading.value = false;
        }, 1000);
    } catch (error) {
        console.error('Erro ao atualizar perfil:', error);
    }
};
</script>

<template>
    <AppLayout
        :user="user"
    >
        <Head title="Meu perfil" />

        <div class="flex flex-col items-center bg-secondary-50 rounded-lg w-full py-6 mx-8">
            <div class="flex flex-col items-center">
                <img
                    :src="'https://ui-avatars.com/api/?background=ffd833&color=2c2f33&name='+props.user.name"
                    alt="Avatar"
                    class="w-32 h-32 rounded-lg"
                />

                <TextInput
                    class="border-none bg-transparent text-2xl font-bold mt-4 align-middle text-center py-0"
                    v-model="nome"
                ></TextInput>
                
                <TextInput
                    class="text-xs border-none bg-transparent mt-2 align-middle text-center py-0"
                    v-model="email"
                ></TextInput>

                <div class="flex flex-col mt-4 w-[24rem]">
                    <InputLabel
                        value="Biografia"
                    />
                    <Textarea
                        id="biografia"
                        name="biografia"
                        v-model="biografia"
                    ></Textarea>
                </div>

                <section class="flex flex-col items-center justify-center">
                    <div class="flex justify-start">
                        <h1 class="text-primary-600 text-2xl mt-8">Informações pessoais</h1>
                    </div>

                    <div class="flex gap-4 mt-4">
                        <div class="flex flex-col">
                            <InputLabel
                                value="Data de nascimento"
                            />
                            <TextInput
                                id="data_nascimento"
                                name="data_nascimento"
                                type="date"
                                v-model="dataNascimento"
                            ></TextInput>
                        </div>
    
                        <div class="flex flex-col">
                            <InputLabel
                                value="Telefone"
                            />
                            <TextInput
                                id="telefone"
                                name="telefone"
                                type="tel"
                                v-model="telefone"
                            ></TextInput>
                        </div>

                        <div class="flex flex-col">
                            <InputLabel
                                value="Como você se identifica?"
                            />
                            <Select
                                id="genero"
                                name="genero"
                                v-model="selectedOption"
                                :options="selectOptions"
                            />
                        </div>
                    </div>

                    <div class="grid grid-rows-2 grid-flow-col gap-4 mt-4">
                        <div class="flex flex-col">
                            <InputLabel
                                value="CEP"
                            />
                            <TextInput
                                id="cep"
                                name="cep"
                                type="text"
                                v-model="cep"
                            ></TextInput>
                        </div>
    
                        <div class="flex flex-col">
                            <InputLabel
                                value="Cidade"
                            />
                            <TextInput
                                id="cidade"
                                name="cidade"
                                type="text"
                                v-model="cidade"
                            ></TextInput>
                        </div>
    
                        <div class="flex flex-col">
                            <InputLabel
                                value="Logradouro"
                            />
                            <TextInput
                                id="logradouro"
                                name="logradouro"
                                type="text"
                                v-model="logradouro"
                            ></TextInput>
                        </div>
    
                        <div class="flex flex-col">
                            <InputLabel
                                value="Estado"
                            />
                            <TextInput
                                id="estado"
                                name="estado"
                                type="text"
                                v-model="estado"
                            ></TextInput>
                        </div>
    
                        <div class="flex flex-col">
                            <InputLabel
                                value="Bairro"
                            />
                            <TextInput
                                id="bairro"
                                name="bairro"
                                type="text"
                                v-model="bairro"
                            ></TextInput>
                        </div>
    
                        
                        <div class="flex flex-col">
                            <InputLabel
                                value="Número"
                            />
                            <TextInput
                                id="numero"
                                name="numero"
                                type="text"
                                v-model="numero"
                            ></TextInput>
                        </div>
                    </div>
                </section>

                <button
                    @click="updateProfile"
                    class="mt-4 bg-primary-500 text-white font-bold py-2 px-4 rounded-lg"
                >
                    Salvar
                </button>
            </div>
        </div>
    </AppLayout>
</template>