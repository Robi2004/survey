<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

defineProps({
    user: Object,
    surveyCount: Object,
});

</script>

<template>
    <AppLayout title="User">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Information de l'utilisateurs
            </h2>
        </template>
        <div class="py-12">
            <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">  
                    <section class="text-gray-600 body-font">
                    <div class="container px-5 py-24 mx-auto">
                        <div class="flex flex-wrap -m-4">
                            <div class="flex flex-col w-full mb-12">
                                <h1 class="sm:text-3xl text-2xl text-center font-medium title-font text-gray-900">{{ user.data[0].firstName }} {{ user.data[0].lastName }}</h1>   
                            </div>
                            <div class="flex flex-col w-full mb-12">
                                <h1 class="sm:text-3xl text-2xl text-center font-medium title-font text-gray-900">{{ user.data[0].email }}</h1>   
                            </div>
                            <div class="flex flex-col w-full mb-12">
                                <h1 class="sm:text-2xl text-2xl text-center font-medium title-font text-gray-900">Nombre de sondage créer : {{ surveyCount }}</h1>   
                            </div>
                        </div>
                    </div>
                    </section>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
