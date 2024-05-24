<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { reactive } from 'vue'

defineProps({
    question: Object,
    survey: Object,
    answers: Object,
});

</script>

<template>
    <AppLayout title="Question">
        <div class="py-12">
            <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">  
                    <section class="text-gray-600 body-font">
                    <div class="container px-5 py-24 mx-auto">
                        <div class="flex flex-wrap -m-4">
                            <div class="flex flex-col w-full mb-12">
                                <h1 class="sm:text-4xl text-2xl text-center font-medium title-font text-gray-900">{{ question.data[0].content }}</h1>
                                <h2 class="sm:text-1xl text-1xl text-center font-medium title-font text-gray-900 mt-6 mb-4">Cette question est une question de type : <p class="font-bold">{{ question.data[0].type }}</p></h2>
                                <div v-if="question.data[0].type != 'Text'">
                                    <h2 class="sm:text-1xl text-1xl text-center font-medium title-font text-gray-900 mt-4 mb-2">Les réponses possible à cette question sont :</h2>
                                     <p v-for="answer in answers.data" class="font-bold text-center">{{ answer.content }}</p>
                                </div>
                                <h2 class="sm:text-1xl text-1xl text-center font-medium title-font text-gray-900 my-6">Cette question ce trouve dans le sondage : <p class="font-bold">{{ survey.data[0].title }}</p></h2>           
                            </div>
                        </div>
                    </div>
                    </section>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
