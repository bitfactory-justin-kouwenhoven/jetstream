<template>
    <div>
        <app-layout>
            <template #header>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Show user - {{ person.name }}
                </h2>
            </template>

            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                        <div>
                            <div class="p-6 sm:px-10 bg-white border-b border-gray-200">
                                <form @submit.prevent="submit">
                                    <div>
                                        <jet-label for="name" value="Name" />
                                        <div id="name" class="mt-1 block w-full">{{ person.name }}</div>
                                    </div>

                                    <div class="mt-4">
                                        <jet-label for="email" value="Email" />
                                        <div id="email" class="mt-1 block w-full">{{ person.email }}</div>
                                    </div>

                                    <div class="flex items-center justify-end mt-4">
                                        <inertia-link :href="route('users.index')" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:ring focus:ring-blue-200 active:text-gray-800 active:bg-gray-50 disabled:opacity-25 transition">
                                            Back
                                        </inertia-link>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </app-layout>
    </div>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import JetLabel from '@/Jetstream/Label'

    export default {
        components: {
            AppLayout,
            JetLabel,
        },
        props: {
            person: Object
        },
        data() {
            return {
            }
        },
        methods: {
        },
    }
</script>
