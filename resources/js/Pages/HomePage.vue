<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import Chart from 'chart.js/auto';
import { onBeforeMount, onMounted} from 'vue';
import { router } from '@inertiajs/vue3';

const props = defineProps({
    surveys: Object,
});

const dataAnswers = {
    labels: [],
    datasets: [{  
        type: 'bar',
        label: 'Nombre de personne ayant répondu au sondage',
        data: [],
        borderWidth: 1
    }]
}

onBeforeMount(() => {
    if(props.surveys.data[0] != null){
        props.surveys.data.forEach(element => {
            dataAnswers.labels.push(element.title);
            dataAnswers.datasets[0].data.push(element.nbAnswer);
        });
    }
})

onMounted(() => {
    const ctx = document.getElementById('myChart');
    const myChart = new Chart(ctx, {
        data: dataAnswers,
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
})

const createSurvey = () =>{
    router.get('/surveys/create',);
};

</script>

<template>
    <AppLayout title="HomePage">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Accueil
            </h2>
        </template>
        <div class="py-12">
            <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">  
                    <section class="text-gray-600 body-font">
                        <div class="container px-5 py-24 mx-auto">
                            <div v-if="surveys.data[0] == null">
                                <h2 class="text-center text-2xl font-medium title-font text-gray-900">Vous n'avez créer aucun sondage !</h2>
                                <div class="mt-16 text-center mb-12">
                                    <PrimaryButton @click="createSurvey">Créer votre premier sondage</PrimaryButton>
                                </div>
                            </div>
                            <canvas id="myChart"></canvas>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
