<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';

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
		<!-- <template #header>
			<h2 class="p-6 text-2xl font-bold tracking-tight text-gray-950 sm:text-3xl">Stats</h2>
		</template> -->

		<template #default>
			<div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4 mx-80 my-20">
				<div class="relative p-6 bg-white shadow-sm fi-wi-stats-overview-stat rounded-xl ring-1 ring-gray-950/5">
					<div class="grid gap-y-2">
						<div class="flex items-center gap-x-2">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
</svg>

							<span class="text-sm font-medium text-gray-500 dark:text-gray-400">
								Total Users
							</span>
						</div>

						<div class="text-3xl font-semibold tracking-tight text-gray-950">
							{{ totalUsers }}
						</div>
					</div>
				</div>

				<div class="relative p-6 bg-white shadow-sm fi-wi-stats-overview-stat rounded-xl ring-1 ring-gray-950/5">
					<div class="grid gap-y-2">
						<div class="flex items-center gap-x-2">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 0 0 3 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 0 0 5.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 0 0 9.568 3Z" />
  <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6Z" />
</svg>

							<span class="text-sm font-medium text-gray-500 dark:text-gray-400">
								Total Categories
							</span>
						</div>

						<div class="text-3xl font-semibold tracking-tight text-gray-950">
							{{ totalCategories }}
						</div>
					</div>
				</div>

				<div class="relative p-6 bg-white shadow-sm fi-wi-stats-overview-stat rounded-xl ring-1 ring-gray-950/5">
					<div class="grid gap-y-2">
						<div class="flex items-center gap-x-2">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 6v.75m0 3v.75m0 3v.75m0 3V18m-9-5.25h5.25M7.5 15h3M3.375 5.25c-.621 0-1.125.504-1.125 1.125v3.026a2.999 2.999 0 0 1 0 5.198v3.026c0 .621.504 1.125 1.125 1.125h17.25c.621 0 1.125-.504 1.125-1.125v-3.026a2.999 2.999 0 0 1 0-5.198V6.375c0-.621-.504-1.125-1.125-1.125H3.375Z" />
</svg>

							<span class="text-sm font-medium text-gray-500 dark:text-gray-400">
								Total Tickets
							</span>
						</div>

						<div class="text-3xl font-semibold tracking-tight text-gray-950">
							{{ totalTickets }}
						</div>
					</div>
				</div>
                <div class="relative p-6 bg-white shadow-sm fi-wi-stats-overview-stat rounded-xl ring-1 ring-gray-950/5">
					<div class="grid gap-y-2">
						<div class="flex items-center gap-x-2">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M11.35 3.836c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m8.9-4.414c.376.023.75.05 1.124.08 1.131.094 1.976 1.057 1.976 2.192V16.5A2.25 2.25 0 0 1 18 18.75h-2.25m-7.5-10.5H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V18.75m-7.5-10.5h6.375c.621 0 1.125.504 1.125 1.125v9.375m-8.25-3 1.5 1.5 3-3.75" />
</svg>

							<span class="text-sm font-medium text-gray-500 dark:text-gray-400">
								Total Tickets Closed
							</span>
						</div>

						<div class="text-3xl font-semibold tracking-tight text-gray-950">
							{{ totalTicketsSolved }}
						</div>
					</div>
				</div>
                <div class="relative p-6 bg-white shadow-sm fi-wi-stats-overview-stat rounded-xl ring-1 ring-gray-950/5">
					<div class="grid gap-y-2">
						<div class="flex items-center gap-x-2">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0M3.124 7.5A8.969 8.969 0 0 1 5.292 3m13.416 0a8.969 8.969 0 0 1 2.168 4.5" />
</svg>

							<span class="text-sm font-medium text-gray-500 dark:text-gray-400">
								Total Tickets Open
							</span>
						</div>

						<div class="text-3xl font-semibold tracking-tight text-gray-950">
							{{ totalTicketsOpen }}
						</div>
					</div>
				</div>
                <div class="relative p-6 bg-white shadow-sm fi-wi-stats-overview-stat rounded-xl ring-1 ring-gray-950/5">
					<div class="grid gap-y-2">
						<div class="flex items-center gap-x-2">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3v11.25A2.25 2.25 0 0 0 6 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0 1 18 16.5h-2.25m-7.5 0h7.5m-7.5 0-1 3m8.5-3 1 3m0 0 .5 1.5m-.5-1.5h-9.5m0 0-.5 1.5m.75-9 3-3 2.148 2.148A12.061 12.061 0 0 1 16.5 7.605" />
</svg>

							<span class="text-sm font-medium text-gray-500 dark:text-gray-400">
								Total Tickets In Progress
							</span>
						</div>

						<div class="text-3xl font-semibold tracking-tight text-gray-950">
							{{ totalTicketsInProgress }}
						</div>
					</div>
				</div>
			</div>
		</template>

	</AppLayout>
</template>

