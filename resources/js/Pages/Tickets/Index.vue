<template>
    <AppLayout>
        <div class="w-full max-w-7xl mx-auto py-10 px-2 sm:px-4 lg:px-6">
            <div
                class="flex flex-col sm:flex-row justify-between items-center mb-8"
            >
                <h1 class="text-4xl font-bold text-gray-900 mb-4 sm:mb-0">
                    Tickets
                </h1>
                <div
                    class="flex flex-col sm:flex-row items-center space-y-4 sm:space-y-0 sm:space-x-4 w-full sm:w-auto"
                >
                    <div class="relative w-full sm:w-auto">
                        <input
                            v-model="filters.search"
                            @input="handleInput"
                            type="text"
                            placeholder="Search tickets..."
                            class="w-full sm:w-64 pl-8 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        />
                        <span
                            class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none"
                        >
                            <MagnifyingGlassIcon
                                class="w-5 h-5 text-gray-500"
                            />
                        </span>
                    </div>
                    <select
                        v-model="filters.status"
                        @change="handleInput"
                        class="w-full sm:w-48 border border-gray-300 text-gray-700 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    >
                        <option value="">By Status</option>
                        <option value="open">Open</option>
                        <option value="in_progress">In Progress</option>
                        <option value="closed">Closed</option>
                    </select>
                    <select
                        v-model="filters.priority"
                        @change="handleInput"
                        class="w-full sm:w-48 border border-gray-300 text-gray-700 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    >
                        <option value="">By Priority</option>
                        <option value="low">Low</option>
                        <option value="medium">Medium</option>
                        <option value="high">High</option>
                    </select>
                    <select
                        v-model="filters.category"
                        @change="handleInput"
                        class="w-full sm:w-48 border border-gray-300 text-gray-700 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    >
                        <option value="">By Category</option>
                        <option
                            v-for="category in categories"
                            :key="category.id"
                            :value="category.id"
                        >
                            {{ category.name }}
                        </option>
                    </select>
                    <Link
                        :href="route('tickets.create')"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg flex items-center shadow-lg transition transform hover:scale-105"
                    >
                        <PlusIcon class="w-5 h-5 mr-2 text-white" />
                        Create Ticket
                    </Link>
                </div>
            </div>
            <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                <table
                    v-if="tickets.data.length"
                    class="w-full divide-y divide-gray-200"
                >
                    <thead class="bg-gray-100">
                        <tr>
                            <th
                                class="px-4 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider"
                            >
                                Title
                            </th>
                            <th
                                class="px-4 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider"
                            >
                                Status
                            </th>
                            <th
                                class="px-4 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider"
                            >
                                Priority
                            </th>
                            <th
                                class="px-4 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider"
                            >
                                Category
                            </th>
                            <th
                                class="px-4 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider"
                            >
                                Response Time
                            </th>
                            <th
                                class="px-4 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider"
                            >
                                Resolution Time
                            </th>
                            <th
                                class="px-4 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider"
                            >
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <tr
                            v-for="ticket in tickets.data"
                            :key="ticket.id"
                            class="hover:bg-gray-100 transition"
                        >
                            <td
                                class="px-4 py-4 whitespace-nowrap text-sm font-medium text-gray-900"
                            >
                                {{ ticket.subject }}
                            </td>
                            <td
                                class="px-4 py-4 whitespace-nowrap text-sm text-gray-500"
                            >
                                {{ ticket.status }}
                            </td>
                            <td
                                class="px-4 py-4 whitespace-nowrap text-sm text-gray-500"
                            >
                                {{ ticket.priority }}
                            </td>
                            <td
                                class="px-4 py-4 whitespace-nowrap text-sm text-gray-500"
                            >
                                {{ ticket.category }}
                            </td>
                            <td
                                class="px-4 py-4 whitespace-nowrap text-sm text-gray-500"
                            >
                                {{ responseDueTime }}
                            </td>
                            <td
                                class="px-4 py-4 whitespace-nowrap text-sm text-gray-500"
                            >
                                {{ resolutionDueTime }}
                            </td>
                            <td
                                class="px-4 py-4 whitespace-nowrap text-right text-sm font-medium flex items-center space-x-2"
                            >
                                <Link
                                    :href="`/tickets/${ticket.id}`"
                                    class="text-blue-600 hover:text-blue-800 flex items-center transition"
                                >
                                    <EyeIcon
                                        class="w-5 h-5 mr-1 text-blue-600"
                                    />
                                    View
                                </Link>
                                <Link
                                    :href="
                                        route('tickets.edit', {
                                            ticket: ticket.id,
                                        })
                                    "
                                    class="text-yellow-500 hover:text-yellow-700 flex items-center transition"
                                >
                                    <PencilSquareIcon
                                        class="w-5 h-5 mr-1 text-yellow-500"
                                    />
                                    Edit
                                </Link>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div v-else class="p-6 text-center text-gray-500">
                    No results found.
                </div>
                <div v-if="tickets.data.length" class="py-4">
                    <Paginate :links="tickets.links" class="mt-6" />
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import { ref, watch, computed } from "vue";
import { debounce } from "lodash";
import AppLayout from "@/Layouts/AppLayout.vue";
import { Link, usePage } from "@inertiajs/vue3";
import { router } from "@inertiajs/vue3";
import {
    MagnifyingGlassIcon,
    PlusIcon,
    EyeIcon,
    PencilSquareIcon,
} from "@heroicons/vue/24/outline";
import Paginate from "@/Components/Paginate.vue";

const { props } = usePage();
const tickets = ref(props.tickets);
const categories = ref(props.categories);
const filters = ref({
    search: props.filters?.search || "",
    status: props.filters?.status || "",
    priority: props.filters?.priority || "",
    category: props.filters?.category || "",
});

const search = debounce(() => {
    router.get(route("tickets.index"), filters.value, {
        preserveState: true,
        replace: true,
        onSuccess: (page) => {
            tickets.value = page.props.tickets;
        },
    });
}, 300);

const handleInput = () => {
    search();
};

watch(
    filters,
    () => {
        search();
    },
    { deep: true }
);

const ticket = {
    title: "Primary SLA",
    description: "Exemplo de Descrição",
    priority: {
        name: "High",
    },
    sla: {
        name: "SLA",
    },
    response_due_time: new Date(Date.now() + 3600 * 1000), // 1 hora a partir de agora
    resolution_due_time: new Date(Date.now() + 7200 * 1000), // 2 horas a partir de agora
};

const responseDueTime = computed(() => {
    return new Date(ticket.response_due_time).toLocaleString();
});

const resolutionDueTime = computed(() => {
    return new Date(ticket.resolution_due_time).toLocaleString();
});
</script>
