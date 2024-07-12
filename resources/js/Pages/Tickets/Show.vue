<template>
    <AppLayout>

        <div class="max-w-4xl mx-auto py-10 sm:px-6 lg:px-8">
            <h1 class="text-3xl font-semibold text-gray-900 mb-6">Ticket Details</h1>
            <div class="bg-white shadow-md rounded-lg px-8 pt-6 pb-8 mb-4">
                <div class="mb-4">
                    <strong class="block text-gray-700 text-sm font-bold mb-2">Title:</strong>
                    <p class="text-gray-900">{{ ticket.title }}</p>
                </div>
                <div class="mb-4">
                    <strong class="block text-gray-700 text-sm font-bold mb-2">Description:</strong>
                    <p class="text-gray-900">{{ ticket.description }}</p>
                </div>
                <div class="mb-4">
                    <strong class="block text-gray-700 text-sm font-bold mb-2">Status:</strong>
                    <p class="text-gray-900">{{ ticket.status }}</p>
                </div>
                <div class="mb-4">
                    <strong class="block text-gray-700 text-sm font-bold mb-2">Priority:</strong>
                    <p class="text-gray-900">{{ ticket.priority }}</p>
                </div>
                <div class="mb-4">
                    <strong class="block text-gray-700 text-sm font-bold mb-2">Category:</strong>
                    <!-- <p class="text-gray-900">{{ ticket.category.name }}</p> -->
                </div>
                <div class="mb-4">
                    <strong class="block text-gray-700 text-sm font-bold mb-2">Created by:</strong>
                    <p class="text-gray-900">{{ ticket.user.name }}</p>
                </div>
                <div v-if="ticket.agent" class="mb-4">
                    <strong class="block text-gray-700 text-sm font-bold mb-2">Assigned to:</strong>
                    <p class="text-gray-900">{{ ticket.agent.name }}</p>
                </div>
                <div class="mb-4">
                    <strong class="block text-gray-700 text-sm font-bold mb-2">Created at:</strong>
                    <p class="text-gray-900">{{ new Date(ticket.created_at).toLocaleString() }}</p>
                </div>
                <div class="mb-4">
                    <strong class="block text-gray-700 text-sm font-bold mb-2">Updated at:</strong>
                    <p class="text-gray-900">{{ new Date(ticket.updated_at).toLocaleString() }}</p>
                </div>

                <div>
                    <div>
    <h1>Ticket: {{ ticket.title }}</h1>
    <p>Description: {{ ticket.description }}</p>
    <p>Category: {{ ticket.category }}</p>
    <p v-if="ticket.assignedAgent">
      Assigned to: {{ ticket.assignedAgent.name }}
    </p>
    <p v-else>
      Not assigned
    </p>
    <p v-if="routed">Ticket was successfully routed.</p>
    <p v-else>Ticket could not be routed at this time.</p>
  </div>
  </div>

                <Link :href="route('tickets.index')" class="inline-block bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Back to Tickets
                </Link>

            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import { ref, computed } from 'vue';
import { usePage } from '@inertiajs/vue3';
import { Link } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue';

const props = defineProps({
    ticket: Array,
    agent: Array,
    routed: Boolean,
})
const assignedAgentName = computed(() => {
  return props.ticket.assignedAgent?.name || 'Not assigned';
});
</script>
