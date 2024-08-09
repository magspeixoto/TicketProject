<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link } from '@inertiajs/vue3';

defineProps({
    totalUsers: {
        type: Number,
        default: 0,
    },
    totalCategories: {
        type: Number,
        default: 0,
    },
    totalTickets: {
        type: Number,
        default: 0,
    },
    totalTicketsSolved: {
        type: Number,
        default: 0,
    },
    totalTicketsOpen: {
        type: Number,
        default: 0,
    },
    totalTicketsInProgress: {
        type: Number,
        default: 0,
    }
})
</script>

<template>
    <Head title="Dashboard" />

    <AppLayout>
        <template #default>
            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 mx-4 sm:mx-6 lg:mx-8 my-10">
                <div v-for="stat in stats" :key="stat.label" class="relative p-6 bg-white shadow-sm rounded-xl ring-1 ring-gray-200 hover:shadow-lg transition-shadow duration-300">
                    <Link :href="stat.route" class="grid gap-y-2">
                        <div class="flex items-center gap-x-2">
                            <component :is="stat.icon" class="w-6 h-6 text-gray-500" />
                            <span class="text-sm font-medium text-gray-500">{{ stat.label }}</span>
                        </div>
                        <div class="text-3xl font-semibold tracking-tight text-gray-900">{{ stat.value }}</div>
                    </Link>
                </div>
            </div>
        </template>
    </AppLayout>
</template>

<script setup>
const stats = [
    {
        label: 'Total Users',
        value: totalUsers,
        route: route('usersManagement.index'),
        icon: 'UserIcon',
    },
    {
        label: 'Total Categories',
        value: totalCategories,
        route: route('categories.index'),
        icon: 'CategoryIcon',
    },
    {
        label: 'Total Tickets',
        value: totalTickets,
        route: route('tickets.index'),
        icon: 'TicketIcon',
    },
    {
        label: 'Total Tickets Closed',
        value: totalTicketsSolved,
        route: route('tickets.index'),
        icon: 'ClosedTicketIcon',
    },
    {
        label: 'Total Tickets Open',
        value: totalTicketsOpen,
        route: route('tickets.index'),
        icon: 'OpenTicketIcon',
    },
    {
        label: 'Total Tickets In Progress',
        value: totalTicketsInProgress,
        route: route('tickets.index'),
        icon: 'InProgressTicketIcon',
    },
];
</script>

<style scoped>
/* Add any additional styling here */
</style>
