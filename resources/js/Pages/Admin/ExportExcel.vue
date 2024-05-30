<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { reactive } from 'vue'
import { router } from '@inertiajs/vue3'

const form = reactive({
    firstName: false,
    lastName: false,
    email: false,
});

function submit (){
    router.post('/excel/export', form);
};

</script>

<template>
    <AppLayout title="ExportExcelUser">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Export Excel
            </h2>
        </template>
        <div class="py-12">
            <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">  
                    <section class="text-gray-600 body-font">
                    <div class="container px-5 py-24 mx-auto">
                        <div class="flex flex-wrap -m-4">
                            <div class="flex flex-col w-full mb-12">
                                <h1 class="sm:text-3xl text-2xl text-center font-medium title-font text-gray-900">Exporter la liste des utilisateurs au format Excel</h1>   
                                <div class="lg:w-1/2 mx-auto">
                                    <form @submit.prevent="submit" class="p-2 w-full text-center mt-4">
                                        <label for="title" class="leading-7 text-lg text-gray-600">Quel champs voulez-vous exporter ?</label>
                                        <div class="flex flex-wrap mt-6">
                                            <div class="p-2 w-1/3">
                                                <input type="checkbox" v-model="form.lastName" inputId="Checkbox" name="Checkbox" value="Nom" />
                                                <label :for="'Checkbox'" class="ml-2">Nom</label>
                                            </div>
                                            <div class="p-2 w-1/3">
                                                <input type="checkbox" v-model="form.firstName" inputId="Checkbox" name="Checkbox" value="Prénom" />
                                                <label :for="'Checkbox'" class="ml-2">Prénom</label>
                                            </div>
                                            <div class="p-2 w-1/3">
                                                <input type="checkbox" v-model="form.email" inputId="Checkbox" name="Checkbox" value="Email" />
                                                <label :for="'Checkbox'" class="ml-2">Email</label>
                                            </div>
                                            <div class="mt-8 w-1/7 mx-auto">
                                                <a :href="'excel/export?firstName='+form.firstName+'&&lastName='+form.lastName+'&&email='+form.email" class="flex mx-auto text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">Exporter</a>
                                            </div>
                                        </div>
                                    </form>
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
