<script setup>
import { onBeforeMount, reactive } from 'vue';
import { router } from '@inertiajs/vue3';

const props = defineProps({
    survey: Object,
    errors: Object,
});

const form = reactive({
    firstName: null,
    lastName: null,
    city: null,
    questions: [],
    id_survey : null,
});

onBeforeMount(() => {
    form.questions = props.survey['questions'];
});

const submit = (id) =>{
    router.post('/answers/'+id,form);
};
</script>

<template>
    <div class="py-12">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">  
                <section class="text-gray-600 body-font">
                    {{ form.questions }}
                <div class="container px-5 py-24 mx-auto">
                    <div class="flex flex-wrap -m-4">
                        <div class="flex flex-col w-full mb-12">
                            <h1 class="sm:text-3xl text-2xl text-center font-medium title-font text-gray-900">{{ survey[0].title }}</h1>   
                            <div v-if="survey[0].image" class="rounded-lg h-72 w-96 overflow-hidden mx-auto mt-6">
                                <img class="object-center h-full w-full" :src="'/storage/'+ survey[0].image" alt="Aucune image existante">
                            </div>
                            <form @submit.prevent="submit(survey[0].id)" class="container mx-auto">
                                <div class="lg:w-1/2 md:w-2/3 mx-auto mt-8">
                                    <h1 class="text-xl text-center font-medium title-font text-gray-900">Vos informations</h1>   
                                    <div class="flex">
                                        <div class="p-2 w-1/3">
                                            <div class="relative">
                                                <label for="lastName" class="leading-7 text-sm text-gray-600">Nom</label>
                                                <input type="text" id="lastName" name="lastName" v-model="form.lastName" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                            <div v-if="errors.lastName" class="text-red-600">{{ errors.lastName }}</div>
                                        </div>
                                        </div>
                                        <div class="p-2 w-1/3">
                                            <div class="relative">
                                                <label for="firstName" class="leading-7 text-sm text-gray-600">Prénom</label>
                                                <input type="text" id="firstName" name="firstName" v-model="form.firstName" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                            <div v-if="errors.firstName" class="text-red-600">{{ errors.firstName }}</div>
                                        </div>
                                        </div>
                                        <div class="p-2 w-1/3">
                                            <div class="relative">
                                                <label for="city" class="leading-7 text-sm text-gray-600">Ville</label>
                                                <input type="text" id="city" name="city" v-model="form.city" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                            <div v-if="errors.city" class="text-red-600">{{ errors.city }}</div>
                                        </div>
                                        </div>
                                    </div>
                                    <h1 class="mt-8 text-xl text-center font-medium title-font text-gray-900">Questions</h1>  
                                    <div v-for="(item,key) in survey['questions']">
                                        <div v-if="item.type == 'Text'" class="p-2 w-full">
                                            <div class="relative">
                                                <label for="title" class="leading-7 text-sm text-gray-600">{{ item.content }}</label>
                                                <input type="text" id="title" name="title" v-model="form.questions[key]['userAnswers']" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                            </div>
                                        </div>
                                        <div v-if="item.type == 'Select'" class="p-2 w-full">
                                            <div class="relative">
                                                <label for="title" class="leading-7 text-sm text-gray-600">{{ item.content }}</label>
                                                <select id="answerSelect" name="answerSelect" v-model="form.questions[key]['userAnswers']" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                                    <option v-for="answer in item.answer" v-bind:value="answer.id">{{ answer.content }}</option>
                                                </select></div>
                                        </div>
                                        <div v-if="item.type == 'CheckBox'" class="p-2 w-full">
                                            <label for="title" class="leading-7 text-sm text-gray-600">{{ item.content }}</label>
                                            <div class="flex flex-wrap">
                                                <div v-for="answer in item.answer" class="p-2 w-1/3">
                                                    <input type="checkbox" inputId="Checkbox" v-model="form.questions[key][answer.id]" :value="answer.id" />
                                                    <label :for="answer.id" class="ml-2">{{ answer.content }}</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-8 w-full">
                                    <button type="submit" class="flex mx-auto text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">Envoyer</button>
                                    </div>
                                </div>     
                            </form>                 
                            </div>
                        </div>
                        
                    </div>
                </section>
            </div>
        </div>
    </div>
</template>
