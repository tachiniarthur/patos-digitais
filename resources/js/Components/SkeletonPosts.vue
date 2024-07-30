<template>
    <div role="status" class="flex flex-col gap-3 w-[50rem] bg-secondary-50 p-4 rounded-lg animate-pulse">
        <div class="flex items-center">
            <div class="flex items-center justify-center">
                <img
                    class="object-cover w-14 h-14 me-2 rounded-full"
                    src="https://iseb3.com.br/assets/camaleon_cms/image-not-found-4a963b95bf081c3ea02923dceaeb3f8085e1a654fc54840aac61a57a60903fef.png"
                    alt="Foto perfil de usuário ainda não carregada"
                >
                <div class="h-2.5 bg-secondary-100 rounded-full w-60"></div>
            </div>
        </div>
        <div class="flex flex-col">
            <div class="h-2.5 bg-secondary-100 rounded-full w-100 mb-1"></div>
            <div class="h-2.5 bg-secondary-100 rounded-full w-60"></div>
        </div>
        <div class="flex items-center justify-between w-28 gap-4">
            <div class="h-4 bg-secondary-100 rounded-full w-48"></div>
            <div class="h-4 bg-secondary-100 rounded-full w-48"></div>
            <div class="h-4 bg-secondary-100 rounded-full w-48"></div>
        </div>
        <span class="sr-only">Loading...</span>
    </div>
</template>