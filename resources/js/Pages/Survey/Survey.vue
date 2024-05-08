<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';

defineProps({
    survey: Object,
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
                                <div class="xl:w-1/2 lg:w-3/4 w-full mx-auto text-center">
                                    <h1 class="sm:text-3xl text-2xl font-medium title-font mb-4 text-gray-900">{{ survey[0].title }}</h1>
                                    <p class="leading-relaxed text-lg">{{ survey[0].content }}</p>
                                    <span class="inline-block h-1 w-10 rounded bg-indigo-500 mt-8 mb-6"></span>
                                    <h2 v-for="item in survey['question']" class="text-gray-900 font-medium title-font tracking-wider text-sm px-2">{{ item.content }}</h2>
                                    <span class="inline-block h-1 w-10 rounded bg-indigo-500 mt-8 mb-6"></span>
                                    <h2 class="text-gray-900 font-medium title-font tracking-wider text-sm">{{ survey['user'][0].firstName }}</h2>
                                </div>
                        </div>
                    </div>
                    </section>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
