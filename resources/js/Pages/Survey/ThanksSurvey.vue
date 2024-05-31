<script setup>

const props = defineProps({
    survey: Object,
});

</script>

<template>
    <div class="py-12">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">  
                <section class="text-gray-600 body-font">
                    <h2 class="text-center">Merci d'avoir répondu au sondage : {{ survey[0].content }}</h2>
                </section>
            </div>
        </div>
    </div>
</template>
