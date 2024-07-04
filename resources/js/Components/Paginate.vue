<template>
    <div class="flex justify-center">
        <Link 
                                :is="link.url ? 'Link' : 'span'"
                                v-for="link in links" 
                                :href="link.url" 
                                v-html="link.label"
                                class="px-10 m-5 bg-gray-900 text-white rounded-md"
                                :class="{ 'text-gray-500': ! link.url, 'font-bold bg-blue-700' : link.active }"
                            />
    </div>

</template>

<script setup>
import { Link } from '@inertiajs/vue3'

const props = defineProps({
    links: Array,
});

</script>