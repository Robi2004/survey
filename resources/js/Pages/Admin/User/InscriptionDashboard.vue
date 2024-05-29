<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Pagination from '@/Components/Paginations.vue';
import DangerButton from '@/Components/DangerButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import ConfirmationModal from '@/Components/ConfirmationModal.vue';
import Show from '@/Components/ShowIcon.vue';
import Reject from '@/Components/RejectIcon.vue';
import Validate from '@/Components/ValidateIcon.vue';
import { reactive, ref } from 'vue';
import { router } from '@inertiajs/vue3';

defineProps({
    users: Object,
});

const showConfirmValidationUserModal = ref(false)
const CurrentElement = ref()

const Modal = reactive({
    title :"",
    button :"",
    validate: false
})

const openModalValidate = (item) => {
    CurrentElement.value = item;
    showConfirmValidationUserModal.value = true;
    Modal.title = "Voulez-vous valider l\'inscription ?";
    Modal.button = "Valider";
    Modal.validate = true;
}

const openModalReject = (item) => {
    CurrentElement.value = item;
    showConfirmValidationUserModal.value = true;
    Modal.title = "Voulez-vous supprimer l\'inscription ?";
    Modal.button = "Supprimer";
    Modal.validate = false;
}

const closeModal = () => {
    showConfirmValidationUserModal.value = false;
}

const ValidationUser = (id) =>{
    if(Modal.validate){
        router.put('/users/inscription/'+id,{preserveScroll: true});
    }else{
        router.delete('/users/'+id,{preserveScroll: true});
    }
    closeModal();
};

const showUser = (id) =>{
    router.get('/users/'+id,);
};
</script>

<template>
    <AppLayout title="UserDashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Gestion des inscriptions
            </h2>
        </template>
        <div class="py-12">
            <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">  
                    <section class="text-gray-600 body-font">
                        <div class="container px-5 py-24 mx-auto">
                            <div v-if="users.data.length">
                                <div class="flex flex-col-reverse -m-4">
                                    <div class="p-4 mx-44" :item v-for="item in users.data">
                                        <div class="mh-25 border-2 border-gray-200 border-opacity-60 rounded-lg overflow-hidden">
                                            <div class="p-6 flex">
                                                <p class="font-extrabold flex-auto md:w-1/3" :href="'/surveys/'+item.id">{{ item.firstName}} {{ item.lastName }}</p>
                                                <button @click="showUser(item.id)" type="button">
                                                    <Show></Show>
                                                </button>
                                                <button @click="openModalValidate(item)" type="button" class="ml-2">
                                                    <Validate></Validate>
                                                </button>
                                                <button @click="openModalReject(item)" type="button" class="ml-2">
                                                    <Reject></Reject>
                                                </button> 
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <ConfirmationModal :show="showConfirmValidationUserModal" @close="closeModal">
                                    <template #title>
                                        <h2 class="text-lg font-semibold text-slate-800">{{ Modal.title }}</h2>
                                    </template>
                                    <template #content>
                                        <p class="text-lg font-semibold text-slate-600">{{ CurrentElement.title }}</p>
                                    </template>
                                    <template #footer>
                                        <div class="mt-6 flex space-x-4">
                                            <DangerButton @click="ValidationUser(CurrentElement.id)">{{ Modal.button }}</DangerButton>
                                            <SecondaryButton @click="closeModal">Annuler</SecondaryButton>
                                        </div>
                                    </template>
                                </ConfirmationModal>
                                <Pagination :meta="users.meta"/>
                            </div>
                            <div v-else><h1 class="sm:text-3xl text-2xl text-center font-medium title-font text-gray-900">Aucune inscriptions</h1></div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
