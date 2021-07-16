<template>
    <div>
        <app-layout>
            <template #header>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Edit user - {{ person.name }}
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
                                        <jet-input id="name" type="text" class="mt-1 block w-full" v-model="form.name" autofocus />
                                        <jet-input-error :message="form.errors.name" class="mt-2" />
                                    </div>

                                    <div class="mt-4">
                                        <jet-label for="email" value="Email" />
                                        <jet-input id="email" type="email" class="mt-1 block w-full" v-model="form.email"/>
                                        <jet-input-error :message="form.errors.email" class="mt-2" />
                                    </div>

                                    <div class="mt-4">
                                        <jet-label for="password" value="New Password" />
                                        <jet-input id="password" type="password" class="mt-1 block w-full" v-model="form.password" ref="password" autocomplete="new-password" />
                                        <jet-input-error :message="form.errors.password" class="mt-2" />
                                    </div>

                                    <div class="mt-4">
                                        <jet-label for="password_confirmation" value="Confirm Password" />
                                        <jet-input id="password_confirmation" type="password" class="mt-1 block w-full" v-model="form.password_confirmation" autocomplete="new-password" />
                                        <jet-input-error :message="form.errors.password_confirmation" class="mt-2" />
                                    </div>

                                    <div class="flex items-center justify-end mt-4">
                                        <inertia-link :href="route('users.index')" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:ring focus:ring-blue-200 active:text-gray-800 active:bg-gray-50 disabled:opacity-25 transition">
                                            Cancel
                                        </inertia-link>

                                        <jet-button class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                            Save
                                        </jet-button>
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
    import { useForm } from '@inertiajs/inertia-vue3'

    import JetButton from '@/Jetstream/Button'
    import JetSecondaryButton from '@/Jetstream/SecondaryButton'
    import JetInput from '@/Jetstream/Input'
    import JetInputError from '@/Jetstream/InputError'
    import JetLabel from '@/Jetstream/Label'
    import JetValidationErrors from '@/Jetstream/ValidationErrors'

    export default {
        components: {
            AppLayout,
            JetButton,
            JetSecondaryButton,
            JetInput,
            JetInputError,
            JetLabel,
            JetValidationErrors
        },
        props: {
            person: Object
        },
        data() {
            return {
                form: this.$inertia.form({
                    name: this.person.name,
                    email: this.person.email,
                    password: null,
                    password_confirmation: null,
                    terms: true,
                }),
            }
        },
        methods: {
            submit() {
                this.form.put(`/users/${this.person.id}/update`, {
                    preserveScroll: true,
                })
            }
        },
    }
</script>
