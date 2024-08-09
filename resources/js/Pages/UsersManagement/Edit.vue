<template>
    <AppLayout>
        <div class="max-w-4xl mx-auto py-10 sm:px-6 lg:px-8">
            <h1 class="text-3xl font-semibold text-gray-900 mb-6">Edit Users and Roles</h1>
            <form @submit.prevent="submit" class="bg-white shadow-md rounded-lg px-8 pt-6 pb-8 mb-4">
                <div class="mb-4">
                    <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Name</label>
                    <input type="text" v-model="form.name" id="name"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>
                <div class="mb-4">
                    <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email</label>
                    <input type="email" v-model="form.email" id="email"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>
                <div class="mb-4">
                    <label for="password" class="block text-gray-700 text-sm font-bold mb-2">Password</label>
                    <input type="password" v-model="form.password" id="password"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Role</label>
                    <div>
                        <label class="inline-flex items-center mr-4">
                            <input type="radio" v-model="form.role" value="user" class="form-radio" name="role">
                            <span class="ml-2">User</span>
                        </label>
                        <label class="inline-flex items-center mr-4">
                            <input type="radio" v-model="form.role" value="agent" class="form-radio" name="role">
                            <span class="ml-2">Agent</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="radio" v-model="form.role" value="admin" class="form-radio" name="role">
                            <span class="ml-2">Admin</span>
                        </label>
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <button type="submit"
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
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
    user: Object,
});
console.log('User prop:', props.user);

const form = ref({
    name: props.user.name,
    email: props.user.email,
    password: '',
    role: props.user.role,
});

const submit = () => {
    router.put(route('usersManagement.update', props.user.id), form.value, {
        onSuccess: () => {
            router.visit(route('usersManagement.index'));
        },
    });
};
</script>
