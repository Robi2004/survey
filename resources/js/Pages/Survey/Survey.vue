<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { router } from '@inertiajs/vue3';

defineProps({
    survey: Object,
});

const showAnswer = (id) =>{
    router.get('/surveys/'+id+'/answer');
};
</script>

<template>
    <AppLayout title="Survey">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Contenu du sondage
            </h2>
        </template>
        <div class="py-12">
            <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">  
                    <section class="text-gray-600 body-font">
                    <div class="container px-5 py-24 mx-auto">
                        <div class="flex flex-wrap -m-4">
                            <div class="flex flex-col w-full mb-12">
                                    <h1 class="sm:text-3xl text-2xl text-center font-medium title-font text-gray-900">{{ survey[0].title }}</h1>
                                    <div class="my-8 text-center" v-if="survey['HaveAnswer']">
                                        <PrimaryButton @click="showAnswer(survey[0].id)">Voir les résultats</PrimaryButton>
                                    </div> 
                                <div v-if="survey[0].image" class="rounded-lg h-72 w-96 overflow-hidden mx-auto mt-6">
                                    <img class="object-center h-full w-full" :src="'/storage/'+ survey[0].image" alt="Aucune image existante">
                                </div>
                                <div class="text-center mt-6" v-if="survey['questions'].length != 0">
                                    <h2>Lien pour répondre au sondage :</h2>
                                    <a :href="'/surveys/'+survey[0].id+'/getAnswer'" class="underline">localhost:8000/surveys/{{ survey[0].id }}/getAnswer</a>
                                </div>
                                <div class="lg:w-1/2 md:w-2/3 mx-auto">
                                    <h2 class="sm:text-2xl text-2xl text-center font-medium title-font my-4 text-gray-900">Questions</h2>
                                    <div v-for="item in survey['questions']">
                                        <div v-if="item.type == 'Text'" class="p-2 w-full">
                                            <div class="relative">
                                                <label for="title" class="leading-7 text-sm text-gray-600">{{ item.content }}</label>
                                                <input type="text" id="title" name="title" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                            </div>
                                        </div>
                                        <div v-if="item.type == 'Select'" class="p-2 w-full">
                                            <div class="relative">
                                                <label for="title" class="leading-7 text-sm text-gray-600">{{ item.content }}</label>
                                                <select id="answerSelect" name="answerSelect" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                                    <option v-for="answer in item.answer" v-bind:value="answer.id">{{ answer.content }}</option>
                                                </select></div>
                                        </div>
                                        <div v-if="item.type == 'CheckBox'" class="p-2 w-full">
                                            <label for="title" class="leading-7 text-sm text-gray-600">{{ item.content }}</label>
                                            <div class="flex flex-wrap">
                                                <div v-for="answer in item.answer" class="p-2 w-1/3">
                                                    <input type="checkbox" inputId="Checkbox" name="Checkbox" value="Checkbox" />
                                                    <label :for="'Checkbox'+answer.id" class="ml-2">{{ answer.content }}</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div v-if="survey['questions'].length == 0"><p class="text-center">Aucun questions existante pour ce sondage.</p></div>
                                    <div class="text-center">
                                        <span class="inline-block h-1 w-10 rounded bg-indigo-500 mt-8 mb-6"></span>
                                        <h2 class="text-gray-900 font-medium title-font tracking-wider text-sm">Créateur du sondage : {{ survey.user[0].firstName }}  {{ survey.user[0].lastName }}</h2>
                                    </div>
                                    </div>                      
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
