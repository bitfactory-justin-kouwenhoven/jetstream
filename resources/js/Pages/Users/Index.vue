<template>
    <div>
        <app-layout>
            <template #header>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Users
                </h2>
            </template>

            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                        <div>
                            <div class="p-6 sm:px-10 bg-white border-b border-gray-200">

                                <inertia-link :href="route('users.create')" class="mb-2 inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition">
                                    Create
                                </inertia-link>

                                <Table
                                        :filters="queryBuilderProps.filters"
                                        :search="queryBuilderProps.search"
                                        :columns="queryBuilderProps.columns"
                                        :on-update="setQueryBuilder"
                                        :meta="users"
                                    >
                                        <template #head>
                                        <tr>
                                            <th @click.prevent="sortBy('name')">Name</th>
                                            <th v-show="showColumn('email')" @click.prevent="sortBy('email')">Email</th>
                                            <th v-show="showColumn('current_team_id')" @click.prevent="sortBy('current_team_id')">Current team</th>
                                            <th>Action</th>
                                        </tr>
                                        </template>

                                        <template #body>
                                        <tr v-for="user in users.data" :key="user.id">
                                            <td>{{ user.name }}</td>
                                            <td v-show="showColumn('email')">{{ user.email }}</td>
                                            <td v-show="showColumn('current_team_id')">{{ user.current_team?.name }}</td>
                                            <td>
                                                <inertia-link :href="route('users.edit', user.id)" class="inline-flex items-center px-2 py-2 bg-gray-800 border border-transparent rounded-md text-xs text-white tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                                    </svg>
                                                </inertia-link>
                                                <inertia-link :href="route('users.show', user.id)" class="ml-3 inline-flex items-center px-2 py-2 bg-gray-800 border border-transparent rounded-md text-xs text-white tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                    </svg>
                                                </inertia-link>

                                                <jet-button @click="showModal(user)" class="ml-3 inline-flex items-center px-2 py-2 bg-gray-800 border border-transparent rounded-md text-xs text-white tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </jet-button>
                                            </td>
                                        </tr>
                                        </template>
                                    </Table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <jet-dialog-modal :show="showDeleteModal" @close="closeModal">
                <template #title>
                    Delete
                </template>

                <template #content>
                    Are you sure you want to delete user: {{ deleteItem.name }}?
                </template>

                <template #footer>
                    <jet-secondary-button @click="closeModal">
                        Cancel
                    </jet-secondary-button>

                    <jet-danger-button class="ml-2" @click="deleteItemButton">
                        Delete
                    </jet-danger-button>
                </template>
            </jet-dialog-modal>
        </app-layout>
    </div>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import JetDialogModal from '@/Jetstream/DialogModal'
    import JetButton from '@/Jetstream/Button'
    import JetDangerButton from '@/Jetstream/DangerButton'
    import JetSecondaryButton from '@/Jetstream/SecondaryButton'
    import { InteractsWithQueryBuilder, Tailwind2 } from '@protonemedia/inertiajs-tables-laravel-query-builder';

    export default {
        mixins: [InteractsWithQueryBuilder],
        components: {
            AppLayout,
            JetDialogModal,
            JetButton,
            JetDangerButton,
            JetSecondaryButton,
            Table: Tailwind2.Table
        },
        props: {
            users: Object
        },
        data() {
            return {
                showDeleteModal: false,
                deleteItem: null,
            }
        },
        methods: {
            showModal(item) {
                this.deleteItem = item;
                this.showDeleteModal = true;
            },
            closeModal() {
                this.showDeleteModal = false;
            },
            deleteItemButton() {
            },
        },
    }
</script>
