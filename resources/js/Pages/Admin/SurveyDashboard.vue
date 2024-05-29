<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Pagination from '@/Components/Paginations.vue';
import DangerButton from '@/Components/DangerButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import ConfirmationModal from '@/Components/ConfirmationModal.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import Trash from '@/Components/TrashIcon.vue';
import Edit from '@/Components/EditIcon.vue';
import Show from '@/Components/ShowIcon.vue';
import { ref } from 'vue';
import { router } from '@inertiajs/vue3';

defineProps({
    surveys: Object,
});

const showConfirmDeleteSurveyModal = ref(false)
const CurrentElement = ref()

const openModal = (item) => {
    CurrentElement.value = item;
    showConfirmDeleteSurveyModal.value = true;
}

const closeModal = () => {
    showConfirmDeleteSurveyModal.value = false;
}

const deleteSurvey = (id) =>{
    router.delete('/surveys/'+id,{preserveScroll: true});
    closeModal();
};

const showSurvey = (id) =>{
    router.get('/surveys/'+id,);
};

const editSurvey = (id) =>{
    router.get('/surveys/'+id+'/edit',);
};

</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Gestion des sondages
            </h2>
        </template>
        <div class="py-12">
            <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">  
                    <section class="text-gray-600 body-font">
                        <div class="container px-5 py-24 mx-auto">
                            <div class="mx-44 mb-8 ">
                                <PrimaryButton @click="createSurvey">Exporter la liste des sondages</PrimaryButton>
                            </div>
                            <div v-if="surveys.data.length">
                                <div class="flex flex-col-reverse -m-4">
                                    <div class="p-4 mx-44" :item v-for="item in surveys.data">
                                        <div class="mh-25 border-2 border-gray-200 border-opacity-60 rounded-lg overflow-hidden">
                                            <div class="p-6 flex">
                                                <p class="font-extrabold flex-auto md:w-1/3" :href="'/surveys/'+item.id">{{ item.title }}</p>
                                                <button @click="showSurvey(item.id)" type="button">
                                                    <Show></Show>
                                                </button> 
                                                <button @click="editSurvey(item.id)" class="mx-2" type="button">
                                                    <Edit></Edit>
                                                </button> 
                                                <button @click="openModal(item)" type="button">
                                                    <Trash></Trash>
                                                </button> 
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <ConfirmationModal :show="showConfirmDeleteSurveyModal" @close="closeModal">
                                    <template #title>
                                        <h2 class="text-lg font-semibold text-slate-800">Supprimer ce sondage ?</h2>
                                    </template>
                                    <template #content>
                                        <p class="text-lg font-semibold text-slate-600">{{ CurrentElement.title }}</p>
                                    </template>
                                    <template #footer>
                                        <div class="mt-6 flex space-x-4">
                                            <DangerButton @click="deleteSurvey(CurrentElement.id)">Supprimer</DangerButton>
                                            <SecondaryButton @click="closeModal">Annuler</SecondaryButton>
                                        </div>
                                    </template>
                                </ConfirmationModal>
                                <Pagination :meta="surveys.meta"/>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
