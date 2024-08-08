<template>
    <AppLayout>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-40">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-semibold text-gray-900">Categories</h1>
                <div class="flex items-center">
                    <Link :href="route('categories.create')" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg flex items-center">
                        <PlusIcon class="w-5 h-5 mr-2 text-white" />
                        Create Category
                    </Link>
                </div>
            </div>
            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <tr v-for="category in categories" :key="category.id">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ category.name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ category.description }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium flex items-center space-x-2">
                                <Link :href="route('categories.edit', { category: category.id })" class="text-blue-600 hover:text-blue-700 flex items-center">
                                    <PencilSquareIcon class="w-5 h-5 mr-1 text-blue-600 hover:text-blue-700" />
                                    Edit
                                </Link>
                                <Link method="delete" :href="route('categories.destroy', { category: category.id })" class="text-red-600 hover:text-red-700 flex items-center">
                                    <TrashIcon class="w-5 h-5 mr-1 text-red-600 hover:text-red-700" />
                                    Delete
                                </Link>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div>
                    <!-- Uncomment and implement pagination if needed -->
                    <!-- <Paginate :links="categories.links" class="mt-6"/> -->
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link } from '@inertiajs/vue3';
import { PlusIcon, PencilSquareIcon, TrashIcon } from '@heroicons/vue/24/outline';

const props = defineProps({
    categories: Array,
});
</script>
