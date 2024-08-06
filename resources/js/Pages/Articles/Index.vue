<template>
    <AppLayout>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-10">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-semibold text-gray-900">Knowledge Base</h1>
                <div class="flex items-center">

                    <Link :href="route('articles.create')" class="bg-gray-950 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded ml-4">
                        Create Article
                    </Link>
                </div>
            </div>
            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Content</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>

                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <tr v-for="article in props.articles" :key="article.id">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ article.title }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ truncateContent(article.content) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ article.category.name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <Link :href="route('articles.edit', { article: article.id })" class=" bg-gray-950 text-white rounded-md p-2 ml-3 hover:text-indigo-900">Edit</Link>
                                <Link method="DELETE" :href="route('articles.destroy', { article: article.id })" class=" bg-gray-950 text-white rounded-md p-2 ml-3 hover:text-indigo-900">Delete</Link>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div>
                    <!-- <Paginate :links="categories.links" class="mt-6"/> -->
                </div>
            </div>
        </div>

    </AppLayout>
</template>

<script setup>
import { ref, computed } from 'vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link } from '@inertiajs/vue3';
import MagnifyingGlass from '../../Components/MagnifyingGlass.vue';
import Paginate from '@/Components/Paginate.vue';

const props = defineProps({
    articles: Object,
});

function truncateContent(content) {
    const maxLength = 50; // Define o comprimento máximo do conteúdo
    return content.length > maxLength ? content.substring(0, maxLength) + "..." : content;
}

</script>
