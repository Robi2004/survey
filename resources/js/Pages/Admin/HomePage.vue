<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';

const props = defineProps({
    surveys: Object,
    users: Object,
    inscriptions: Object,
});

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
                        <div class="container px-5 py-24 mx-auto flex text-center items-center">
                            <h2 class="w-1/3 text-xl">Nombre de sondages : {{ surveys }}</h2>
                            <h2 class="w-1/3 text-xl">Nombre d'utilisateurs : {{ users }}</h2>
                            <h2 class="w-1/3 text-xl">Nombre d'inscriptions : {{ inscriptions }}</h2>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
