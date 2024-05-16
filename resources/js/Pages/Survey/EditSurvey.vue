<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { onBeforeMount, reactive } from 'vue';
import { router } from '@inertiajs/vue3';

const props = defineProps({
    survey: Object,
    errors: Object,
});

const numbers = ([1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20]);

const numberQuestion = reactive({
    number: null,
});

const numberAnswer = reactive([]);

const question = reactive({
    id: [],
    content: [],
    type: [],
}); // Ajouter l'id de la question pour le récup dans le controlleur

const contentAnswer = reactive({
    1:[], 2:[], 3:[], 4:[],5:[],6:[],7:[],8:[],9:[],10:[],11:[],12:[],13:[],14:[],15:[],16:[],17:[],18:[],19:[],20:[],});

const form = reactive({
    title: null,
    image: null,
    question : question,
    contentAnswer : [contentAnswer],
});

onBeforeMount(() => {
  if(props.survey && props.survey[0].id) {
    form.title = props.survey[0].title;
    numbers.forEach(number => {
        if(number == props.survey.questions.length){
            numberQuestion.number = number;
        }
        if(props.survey.questions.hasOwnProperty(number-1)){
            question.id[number] = props.survey.questions[number-1].id;
            question.content[number] = props.survey.questions[number-1].content;
            question.type[number] = props.survey.questions[number-1].type;
            numberAnswer[number] = props.survey.questions[number-1].answer.length;
            let i = 1;
            props.survey.questions[number-1].answer.forEach(answer => {
                contentAnswer[number][i] = answer.content;
                i++;
            });
        }
    });
  }
});

function submit (){
    if(question.content.length-1 != numberQuestion.number){
        for(let i = numberQuestion.number+1;i < 20;i++){
            question.id[i] = undefined;
            question.content[i] = undefined;
        }
    }
    router.post('/surveys/'+props.survey[0].id, form);
};

</script>

<template>
    <AppLayout title="CreatePost">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">  
                        <div class="container px-5 py-24 mx-auto">
                            <div class="flex flex-wrap -m-4">
                                <form @submit.prevent="submit" class="container px-5 py-24 mx-auto">
                                    <div class="flex flex-col text-center w-full mb-12">
                                    <h1 class="sm:text-3xl text-2xl font-medium title-font mb-4 text-gray-900">Modifier le sondage : </h1>
                                    <h2 class="sm:text-2xl text-1xl font-medium title-font mb-4 text-gray-900">{{ survey[0].title }}</h2>
                                    </div>
                                    <div class="lg:w-1/2 md:w-2/3 mx-auto">
                                    <div class="flex flex-wrap -m-2">
                                        <div class="p-2 w-full">
                                        <div class="relative">
                                            <label for="title" class="leading-7 text-sm text-gray-600">Titre</label>
                                            <input type="text" id="title" name="title" v-model="form.title" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                            <div v-if="errors.title" class="text-red-600">{{ errors.title }}</div>
                                        </div>
                                        </div>
                                        <div class="p-2 w-1/2">
                                        <div class="relative">
                                            <label for="image" class="leading-7 text-sm text-gray-600">Image</label>
                                            <input type="file" accept="image/png, image/gif, image/jpeg" @input="form.image = $event.target.files[0]" id="image" name="image" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                        </div>
                                        </div>
                                        <div class="p-2 w-full">
                                            <div class="relative">
                                                <label for="NumberQuestion" class="leading-7 text-sm text-gray-600">Combien de questions shouaitez vous poser ?</label>
                                                <select v-model="numberQuestion.number" id="numberQuestion" name="numberQuestion" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                                    <option v-for="number in numbers" v-bind:value="number">{{ number }}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div v-for="number in numberQuestion.number" class="p-2 w-full">
                                        <label for="TypeQuestion" class="leading-7 text-sm text-gray-600">De quel type est votre question ?</label>
                                            <div class="flex flex-wrap">
                                            <div class="p-2 w-1/3">
                                                <input v-model="question.type[number]" type="radio" inputId="Text" :name="'TypeQuestion' + number" value="Text" />
                                                <label for="Text" class="ml-2">Text</label>
                                            </div>
                                            <div class="p-2 w-1/3">
                                                <input v-model="question.type[number]" type="radio" inputId="Select" :name="'TypeQuestion' + number" value="Select" />
                                                <label for="Select" class="ml-2">Select box</label>
                                            </div>
                                            <div class="p-2 w-1/3">
                                                <input v-model="question.type[number]" type="radio" inputId="SelectMultiple" :name="'TypeQuestion' + number" value="SelectMultiple" />
                                                <label for="SelectMultiple" class="ml-2">Select Multiple box</label>
                                            </div>
                                            <div class="p-2 w-full" v-if="question.type[number] == 'Select' || question.type[number] == 'SelectMultiple'">
                                                <div class="p-2 w-1/6" >
                                                    <select v-model="numberAnswer[number]" id="numberAnswer" name="numberAnswer" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                                        <option v-for="number in numbers" v-bind:value="number">{{ number }}</option>
                                                    </select>
                                                </div>
                                            <div v-for="answer in numberAnswer[number]" class="p-2 w-full">
                                            <div class="flex flex-wrap">
                                                <div class="relative">
                                                    <label for="title" class="leading-7 text-sm text-gray-600">Réponse numéro {{ answer }}</label>
                                                    <input type="text" id="title" name="title" v-model="contentAnswer[number][answer]" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    </div>
                                    <div class="relative">
                                        <label for="title" class="leading-7 text-sm text-gray-600">Contenu de la question {{ number }}</label>
                                        <input type="text" id="title" name="title" v-model="question.content[number]" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                    </div>
                                    </div>
                                    <div class="p-2 w-full">
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
