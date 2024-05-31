<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Pagination from '@/Components/Paginations.vue';
import DangerButton from '@/Components/DangerButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import ConfirmationModal from '@/Components/ConfirmationModal.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import Trash from '@/Components/TrashIcon.vue';
import Edit from '@/Components/EditIcon.vue';
import { ref } from 'vue';
import { router } from '@inertiajs/vue3';

defineProps({
    survey: Object,
});

const showConfirmDeleteAnswerModal = ref(false)
const CurrentElement = ref()

const openModal = (item) => {
    CurrentElement.value = item;
    showConfirmDeleteAnswerModal.value = true;
}

const closeModal = () => {
    showConfirmDeleteAnswerModal.value = false;
}

const deleteAnswer = (id) =>{
    router.delete('/answers/'+id,{preserveScroll: true});
    closeModal();
};

const showSurvey = (id) =>{
    router.get('/surveys/'+id,);
};

const editAnswer = (id) =>{
    router.get('/answers/'+id+'/edit',);
};
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
                                    <h1 class="sm:text-3xl text-2xl text-center font-medium title-font text-gray-900"> Réponse du sondage : {{ survey[0].title }}</h1>   
                                    <div class="my-8 text-center">
                                        <PrimaryButton @click="showSurvey(survey[0].id)">Retourner au Sondage</PrimaryButton>
                                    </div> 
                                <div class="lg:w-1/2 md:w-2/3 mx-auto">
                                    <div v-for="item in survey['questions']">
                                        <div v-if="item.type == 'Text'" class="p-2 w-full">
                                            <h2 for="title" class="leading-7 text-xl text-center mb-6">{{ item.content }}</h2>
                                            <div v-if="item.answer.data.length != 0" class="bg-slate-300 pb-12 rounded-lg">
                                                <div class="flex flex-col-reverse -m-4">
                                                    <div class="p-4 mx-8" :answer v-for="answer in item.answer.data">
                                                        <div class="border-2 border-gray-200 bg-slate-50 border-opacity-60 rounded-lg overflow-hidden">
                                                            <div class="p-6 flex">
                                                                <p class="font-extrabold flex-auto md:w-1/3" :href="'/questions/'+answer.id">{{ answer.content }}</p>
                                                                <button @click="editAnswer(answer.id)" class="mx-2" type="button">
                                                                    <Edit></Edit>
                                                                </button> 
                                                                <button @click="openModal(answer)" type="button">
                                                                    <Trash></Trash>
                                                                </button> 
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <Pagination :meta="item.answer.meta"/>
                                            <ConfirmationModal :show="showConfirmDeleteAnswerModal" @close="closeModal">
                                                <template #title>
                                                    <h2 class="text-lg font-semibold text-slate-800">Supprimer cette Réponse ?</h2>
                                                </template>
                                                <template #content>
                                                    <p class="text-lg font-semibold text-slate-600">{{ CurrentElement.content }}</p>
                                                </template>
                                                <template #footer>
                                                    <div class="mt-6 flex space-x-4">
                                                        <DangerButton @click="deleteAnswer(CurrentElement.id)">Supprimer</DangerButton>
                                                        <SecondaryButton @click="closeModal">Annuler</SecondaryButton>
                                                    </div>
                                                </template>
                                            </ConfirmationModal>
                                            </div>
                                            <h2 v-else class="text-center">Aucun Réponse existante</h2>
                                        </div>
                                        <div v-if="item.type == 'Select' || item.type == 'CheckBox'" class="p-2 w-full">
                                            <h2 for="title" class="leading-7 text-xl  text-center">{{ item.content }}</h2>
                                            <div class="flex flex-wrap">
                                                <div v-for="answer in item.answer" class="p-2 w-1/4  mt-6">
                                                    <p class="ml-2 text-center">{{ answer.content }} <br> {{ answer.count }}</p>
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
