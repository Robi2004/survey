<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { reactive } from 'vue'

defineProps({
    survey: Object,
});

const form = reactive({
    firstName: null,
    lastName: null,
    city: null,
});

</script>

<template>
    <AppLayout title="Survey">
        <div class="py-12">
            <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">  
                    <section class="text-gray-600 body-font">
                    <div class="container px-5 py-24 mx-auto">
                        <div class="flex flex-wrap -m-4">
                                    <div class="flex flex-col w-full mb-12">
                                <h1 class="sm:text-3xl text-2xl text-center font-medium title-font text-gray-900">{{ survey[0].title }}</h1>
                                <div v-if="survey[0].image" class="rounded-lg h-72 overflow-hidden">
                                    <img class="object-center h-full w-full" :src="'/storage/'+ survey[0].image" alt="Aucune image existante">
                                </div>
                                <form @submit.prevent="submit" class="container px-5 py-24 mx-auto">
                                    <div class="lg:w-1/2 md:w-2/3 mx-auto">
                                    <h2 class="sm:text-2xl text-2xl text-center font-medium title-font mb-4 text-gray-900">Vos informations</h2>
                                    <div class="flex flex-wrap -m-2">
                                        <div class="p-2 w-1/2">
                                        <div class="relative">
                                            <label for="title" class="leading-7 text-sm text-gray-600">Nom</label>
                                            <input type="text" id="title" name="title"  class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                        </div>
                                        </div>
                                        <div class="p-2 w-1/2">
                                        <div class="relative">
                                            <label for="title" class="leading-7 text-sm text-gray-600">Prénom</label>
                                            <input type="text" id="title" name="title"  class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                        </div>
                                        </div>
                                        <div class="p-2 w-1/2">
                                        <div class="relative">
                                            <label for="title" class="leading-7 text-sm text-gray-600">Ville</label>
                                            <input type="text" id="title" name="title"  class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                        </div>
                                        </div>
                                    </div>
                                    <h2 class="sm:text-2xl text-2xl text-center font-medium title-font my-4 text-gray-900">Questions</h2>
                                    <div v-for="item in survey['questions']">
                                        <div v-if="item.type == 'Text'" class="p-2 w-full">
                                            <div class="relative">
                                                <label for="title" class="leading-7 text-sm text-gray-600">{{ item.content }}</label>
                                                <input type="text" id="title" name="title"  class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                            </div>
                                        </div>
                                        <div v-if="item.type == 'Select'" class="p-2 w-full">
                                            <div class="relative">
                                                <label for="title" class="leading-7 text-sm text-gray-600">{{ item.content }}</label>
                                                <select id="answerSelect" name="answerSelect" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                                    <option v-for="answer in item.answer" v-bind:value="answer.id">{{ answer.content }}</option>
                                                </select></div>
                                        </div>
                                        <div v-if="item.type == 'SelectMultiple'" class="p-2 w-full">
                                                <label for="title" class="leading-7 text-sm text-gray-600">{{ item.content }}</label>
                                                <select type="select" id="answerMultiple" name="answerMultiple" multiple class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                                    <option v-for="answer in item.answer" v-bind:value="answer.id">{{ answer.content }}</option>
                                                </select>
                                        </div>
                                        </div>
                                    <div class="text-center">
                                        <span class="inline-block h-1 w-10 rounded bg-indigo-500 mt-8 mb-6"></span>
                                        <h2 class="text-gray-900 font-medium title-font tracking-wider text-sm">{{ survey.user[0].firstName }}</h2>
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
    </AppLayout>
</template>
