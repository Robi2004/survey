<script setup>

import ApplicationMark from '@/Components/ApplicationMark.vue';

const props = defineProps({
    survey: Object,
});

</script>

<template>
    <div class="py-12 my-auto h-full">
        <div class="max-w-8xl my-auto h-full sm:px-6 lg:px-8">
            <div class="mb-4 flex items-center justify-center">
                <ApplicationMark class="block h-12 " />
                <h2 class="text-xl ml-4">Sondix</h2>
            </div>
            <h2 class="text-center text-2xl">Merci d'avoir répondu au sondage : {{ survey[0].title }}</h2>
        </div>
    </div>
</template>
