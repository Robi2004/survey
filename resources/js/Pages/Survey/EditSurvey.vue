<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { onBeforeMount, reactive } from 'vue';
import { router } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';

const props = defineProps({
    survey: Object,
    errors: Object,
});

const form = reactive({
    title: null,
    image: null,
});

onBeforeMount(() => {
    form.title = props.survey[0].title;
});

const createQuestion = (id) =>{
    router.get('/questions/'+id);
};

function submit (){
    router.post('/surveys/'+props.survey[0].id, form);
};

</script>

<template>
    <AppLayout title="EditSurvey">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Modifier un sondage
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">  
                        <div class="container px-5 py-24 mx-auto">
                            <div class="flex flex-wrap -m-4">
                                <div class="flex flex-col text-center w-full">
                                    <h1 class="sm:text-3xl text-2xl font-medium title-font mb-4 text-gray-900">Modifier un sondage</h1>
                                    <div class="my-8 text-center">
                                        <PrimaryButton @click="createQuestion(survey[0].id)">Gérer les questions</PrimaryButton>
                                    </div> 
                                </div>
                                <form @submit.prevent="submit" class="container px-5 py-24 mx-auto">
                                    <div class="lg:w-1/2 md:w-2/3 mx-auto">
                                    <div class="flex flex-wrap -m-2">
                                        <div class="p-2 w-full">
                                        <div class="relative">
                                            <label for="title" class="leading-7 text-sm text-gray-600">Titre</label>
                                            <input type="text" id="title" name="title" v-model="form.title" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                            <div v-if="errors.title" class="text-red-600">{{ errors.title }}</div>
                                        </div>
                                        </div>
                                        <div class="p-2 w-full">
                                        <div class="relative">
                                            <label for="image" class="leading-7 text-sm text-gray-600">Image</label>
                                            <input type="file" accept="image/png, image/gif, image/jpeg" @input="form.image = $event.target.files[0]" id="image" name="image" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                        </div>
                                    </div>
                                    <div class="mt-8 w-full">
                                    <button type="submit" class="flex mx-auto text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">Modifier</button>
                                    </div>
                                </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
