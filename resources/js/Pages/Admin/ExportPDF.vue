<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { reactive } from 'vue'
import { router } from '@inertiajs/vue3'

const form = reactive({
    title: false,
    image: false,
});

function submit (){
    router.post('/pdf', form);
};

</script>

<template>
    <AppLayout title="Survey">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Export PDF
            </h2>
        </template>
        <div class="py-12">
            <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">  
                    <section class="text-gray-600 body-font">
                    <div class="container px-5 py-24 mx-auto">
                        <div class="flex flex-wrap -m-4">
                            <div class="flex flex-col w-full mb-12">
                                <h1 class="sm:text-3xl text-2xl text-center font-medium title-font text-gray-900">Export des sondages au format PDF</h1>   
                                <div class="lg:w-1/2 mx-auto">
                                    <form @submit.prevent="submit" class="p-2 w-full text-center mt-4">
                                        <label for="title" class="leading-7 text-lg text-gray-600">Quel champs voulez-vous exporter ?</label>
                                        <div class="flex flex-wrap mt-6">
                                            <div class="p-2 w-1/2">
                                                <input type="checkbox" v-model="form.title" inputId="Checkbox" name="Checkbox" value="Titre" />
                                                <label :for="'Checkbox'" class="ml-2">Titre</label>
                                            </div>
                                            <div class="p-2 w-1/2">
                                                <input type="checkbox" v-model="form.image" inputId="Checkbox" name="Checkbox" value="Image" />
                                                <label :for="'Checkbox'" class="ml-2">Image</label>
                                            </div>
                                            <div class="mt-8 w-1/7 mx-auto">
                                                <a :href="'pdf/export?title='+form.title+'&&image='+form.image" class="flex mx-auto text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">Exporter</a>
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
