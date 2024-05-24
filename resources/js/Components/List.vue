<script setup>
    defineProps({
        item: Object
    });

</script>
<template>
    <div class="p-4 md:w-1/3">
        <div class="mh-25 border-2 border-gray-200 border-opacity-60 rounded-lg overflow-hidden">
        <img v-if="item.picture != null" class="lg:h-48 md:h-36 w-full object-cover object-center" :src="'/storage/'+item.picture" alt="Aucune image existante">
        <div class="p-6">
            <h1 class="title-font text-lg font-medium text-gray-900 mb-3">{{ item.id + item.title }}</h1>
            <p class="lg:h-32 leading-relaxed mb-3 overflow-hidden">{{ item.content }}</p>
            <div class="flex items-center flex-wrap ">
            <a :href="'/surveys/'+item.id" class="text-indigo-500 inline-flex items-center md:mb-2 lg:mb-0">Learn More
                <svg class="w-4 h-4 ml-2" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path d="M5 12h14"></path>
                <path d="M12 5l7 7-7 7"></path>
                </svg>
            </a>
            </div>
        </div>
        </div>
    </div>
</template>