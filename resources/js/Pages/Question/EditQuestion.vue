<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { onBeforeMount, reactive } from 'vue';
import { router } from '@inertiajs/vue3'

const props = defineProps({
    surveys : Object,
    question: Object,
    errors: Object,
});

const numbers = ([1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20]);

const numberAnswer = reactive({
    number : null
});

const form = reactive({
    oldAnswers: null,
    content: null,
    answers : {id:[],content:[]},
    id_survey : [],
    type : null,
});


onBeforeMount(() => {
    form.content = props.question[0].content;
    form.type = props.question[0].type;
    form.id_survey = props.question.survey[0].id;
    if(form.type != "Text"){
        numberAnswer.number = props.question.answers.length;
        let i = 1;
        props.question.answers.forEach(answers => {
            form.answers.id[i] = answers.id;
            form.answers.content[i] = answers.content;
            i++;
        });
        form.oldAnswers = props.question.answers;
    }

});

function submit (){
    if(form.answers.id[1] != undefined){
        if(numberAnswer.number != form.answers.content.length){
            for(let i = numberAnswer.number+1; i < 20;i++ ){
                form.answers.id[i] = undefined;
                form.answers.content[i] = undefined;
            }
        }
    }
    router.post('/questions/'+props.question[0].id, form);
};

</script>

<template>
    <AppLayout title="CreateQuestion">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Modifier une question
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">  
                        <div class="container px-5 py-24 mx-auto">
                            <div class="flex flex-wrap -m-4">
                                {{ form }}
                                <form @submit.prevent="submit" class="container px-5 py-24 mx-auto">
                                    <div class="flex flex-col text-center w-full mb-12">
                                    <h1 class="sm:text-3xl text-2xl font-medium title-font mb-4 text-gray-900">Création d'une nouvelle question</h1>
                                    </div>
                                    <div class="lg:w-1/2 md:w-2/3 mx-auto">
                                        <div class="flex flex-wrap -m-2">
                                            <div class="p-2 w-full">
                                                <label for="title" class="leading-7 text-sm text-gray-600">Titre de la Question</label>
                                                <input type="text" id="title" name="title" v-model="form.content" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                                <div v-if="errors.title" class="text-red-600">{{ errors.content }}</div>
                                            <label for="TypeQuestion" class="leading-7 text-sm text-gray-600">De quel type est votre question ?</label>
                                                <div class="flex flex-wrap">
                                                <div class="p-2 w-1/3">
                                                    <input v-model="form.type" type="radio" inputId="Text" :name="'TypeQuestion' + number" value="Text" />
                                                    <label for="Text" class="ml-2">Text</label>
                                                </div>
                                                <div class="p-2 w-1/3">
                                                    <input v-model="form.type" type="radio" inputId="Select" :name="'TypeQuestion' + number" value="Select" />
                                                    <label for="Select" class="ml-2">Select box</label>
                                                </div>
                                                <div class="p-2 w-1/3">
                                                    <input v-model="form.type" type="radio" inputId="CheckBox" :name="'TypeQuestion' + number" value="CheckBox" />
                                                    <label for="CheckBox" class="ml-2">Check box</label>
                                                </div>
                                                <div class="p-2 w-full" v-if="form.type == 'Select' || form.type == 'CheckBox'">
                                                    <div class="p-2 w-1/6" >
                                                        <select v-model="numberAnswer.number" type="select" id="numberAnswer" name="numberAnswer" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                                            <option v-for="number in numbers" v-bind:value="number">{{ number }}</option>
                                                        </select>
                                                    </div>
                                                <div v-for="answer in numberAnswer.number" class="p-2 w-full">
                                                <div class="flex flex-wrap">
                                                    <div class="relative">
                                                        <label for="title" class="leading-7 text-sm text-gray-600">Réponse numéro {{ answer }}</label>
                                                        <input type="text" id="title" name="title" v-model="form.answers.content[answer]" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                                    </div>
                                                </div>
                                        </div>
                                    </div>
                                    </div>
                                    <div class="mt-8 w-full">
                                        <button type="submit" class="flex mx-auto text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">Modifier</button>
                                    </div>
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
