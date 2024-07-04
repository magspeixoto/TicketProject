<template>
  <AppLayout>
    <template #header>
      <h2 class="px-40 font-semibold text-xl text-gray-800 leading-tight">
        Customer Support Requests
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-40">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 text-gray-900 dark:text-gray-100">
            <table class="w-full">
              <thead>
                <tr>
                  <th class="border px-4 py-2">ID</th>
                  <th class="border px-4 py-2">User Name</th>
                  <th class="border px-4 py-2">Message Count</th>
                  <th class="border px-4 py-2">Last Update</th>
                  <th class="border px-4 py-2">Actions</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="chatRoom in chatRooms" :key="chatRoom.id">
                  <td class="border px-4 py-2">{{ chatRoom.identifier }}</td>
                  <td class="border px-4 py-2">{{ chatRoom.user.name }}</td>
                  <td class="border px-4 py-2">{{ chatRoom.chat_messages_count }}</td>
                  <td class="border px-4 py-2">{{ chatRoom.updated_at }}</td>
                  <td class="border px-4 py-2">
                    <a :href="`/chatRooms/${chatRoom.id}`"
                       class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">View</a>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import { ref } from 'vue'
import { usePage } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue';

// Accessing page props using usePage
const { props } = usePage()
const chatRooms = ref(props.chatRooms)
</script>