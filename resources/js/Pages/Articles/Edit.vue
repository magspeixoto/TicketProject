<template>
    <AppLayout>
        <div class="max-w-4xl mx-auto py-10 sm:px-6 lg:px-8">
            <h1 class="text-3xl font-semibold text-gray-900 mb-6">Edit Article</h1>
            <form @submit.prevent="submit" class="bg-white shadow-md rounded-lg px-8 pt-6 pb-8 mb-4">
                <div class="mb-4">
                    <label for="title" class="block text-gray-700 text-sm font-bold mb-2">Title</label>
                    <input type="text" v-model="form.title" id="title" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>
                <div class="mb-4">
                    <label for="content" class="block text-gray-700 text-sm font-bold mb-2">Content</label>
                    <textarea v-model="form.content" id="content" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" rows="4"></textarea>
                </div>
                <div class="mb-4">
                    <label for="category_id" class="block text-gray-700 text-sm font-bold mb-2">Category</label>
                    <select v-model="form.category_id" id="category_id" class="block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline">
                        <option v-for="category in categories" :value="category.id" :key="category.id">
                            {{ category.name }}
                        </option>
                    </select>
                </div>
                <div class="flex items-center justify-between">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        Update
                    </button>
                </div>
            </form>
        </div>
    </AppLayout>
</template>

<script setup>
import { ref } from 'vue';
import { usePage, router } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';

const props = defineProps({
    article: Object,
    categories: Array,
});

const form = ref({
    title: props.article?.title || '',
    content: props.article?.content || '',
    category_id: props.article?.category_id || null,
});

const submit = () => {
    router.put(route('articles.update', { article: props.article.id }), form.value, {
        onSuccess: () => {
            router.visit(route('articles.index'));
        },
    });
};
</script>
