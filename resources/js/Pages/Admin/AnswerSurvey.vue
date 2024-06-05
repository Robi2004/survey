<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Pagination from '@/Components/Paginations.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import Edit from '@/Components/EditIcon.vue';
import { ref } from 'vue';
import { router } from '@inertiajs/vue3';

defineProps({
    survey: Object,
});

const isOpen = ref({})

const toggle = (id) => {
    isOpen.value[id] = !isOpen.value[id];
}

const showSurvey = (id) => {
    router.get('/surveys/' + id);
};

const editAnswer = (id) => {
    router.get('/answers/' + id + '/edit');
};

const getAnswerId = (item, questionId) => {
    const answer = item.answer.find(answer => answer.id_question === questionId);
    return answer ? answer.id : null;
};

const getFormattedAnswers = (item, questionId) => {
    const answers = item.answer.filter(answer => answer.id_question === questionId);
    return answers.map(answer => ({ id: answer.id, content: answer.content })).map(a => a.content).join(' - ');
}
</script>
<template>
    <AppLayout title="Survey">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Réponse du sondage
            </h2>
        </template>
        <div class="py-12">
            <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <section class="text-gray-600 body-font">
                        <div class="container px-5 py-24 mx-auto">
                            <div class="flex flex-wrap -m-4">
                                <div class="flex flex-col w-full mb-12">
                                    <h1 class="sm:text-3xl text-2xl text-center font-medium title-font text-gray-900">
                                        Réponse du sondage : {{ survey[0].title }}
                                    </h1>
                                    <div class="my-8 text-center">
                                        <PrimaryButton @click="showSurvey(survey[0].id)">Retourner au Sondage</PrimaryButton>
                                    </div>
                                    <div class="lg:w-5/6 md:w-full mx-auto">
                                        <div class="p-2 w-full">
                                            <div class="bg-slate-300 pb-12 rounded-lg">
                                                <div class="flex flex-col-reverse -m-4">
                                                    <div class="p-4 mx-8" v-for="item in survey['userAnswer'].data" :key="item.id">
                                                        <div class="border-2 border-gray-200 bg-slate-50 border-opacity-60 rounded-lg overflow-hidden">
                                                            <div class="p-6 flex">
                                                                <p class="font-extrabold flex-auto md:w-1/3" :href="'/questions/'+item.id">Réponse de : {{ item.lastName }}</p>
                                                                <svg :class="{'rotate-180': isOpen[item.id]}" class="ms-2 -me-0.5 h-4 w-4 cursor-pointer transition-transform" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" @click="toggle(item.id)" stroke-width="1.5" stroke="currentColor">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                                                </svg>
                                                            </div>
                                                            <div v-if="isOpen[item.id]">
                                                                <div class="p-6 flex text-lg">
                                                                    <p class="font-bold">Informations :</p>
                                                                    <p class="mx-6">Nom : {{ item.lastName }}</p>
                                                                    <p class="mx-6">Prénom : {{ item.firstName }}</p>
                                                                    <p class="mx-6">Ville : {{ item.city }}</p>
                                                                </div>
                                                                <div class="p-6 text-lg">
                                                                    <p class="font-bold">Questions :</p>
                                                                    <div v-for="question in survey['questions']" :key="question.id">
                                                                        <div class="flex">
                                                                            <p class="mx-6">{{ question.content }} :</p>
                                                                            <p class="mr-4">{{ getFormattedAnswers(item, question.id) }}</p>
                                                                            <button v-if="question.type === 'Text'" @click="editAnswer(getAnswerId(item, question.id))" class="mr-2" type="button">
                                                                                <Edit></Edit>
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <Pagination :meta="survey['userAnswer'].meta" />
                                            </div>
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