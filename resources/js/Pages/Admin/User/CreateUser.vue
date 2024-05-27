<script setup>
import { Link, useForm } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import Checkbox from '@/Components/Checkbox.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';

const form = useForm({
    firstName: '',
    lastName: '',
    email: '',
    password: '',
    password_confirmation: '',
    terms: false,
});

const submit = () => {
    form.post(route('users.store'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
        <AppLayout title="EditUser">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Créer un utilisateur
            </h2>
        </template>
        <div class="py-12">
            <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">  
                        <div class="container px-5 py-24 mx-auto">
                            <div class="flex flex-wrap -m-4">
                                <div class="flex flex-col text-center w-full">
                                    <h1 class="sm:text-3xl text-2xl font-medium title-font mb-4 text-gray-900">Créer un utilisateur</h1>
                                </div>
                        <form @submit.prevent="submit" class="container px-96 py-16 mx-auto">
                            <div>
                                <InputLabel for="firstName" value="Prénom" />
                                <TextInput
                                    id="name"
                                    v-model="form.firstName"
                                    type="text"
                                    class="mt-1 block w-full"
                                    required
                                    autofocus
                                    autocomplete="firstName"
                                />
                                <InputError class="mt-2" :message="form.errors.firstName" />
                            </div>
                            
                            <div class="mt-4">
                                <InputLabel for="lastName" value="Nom" />
                                <TextInput
                                    id="lastName"
                                    v-model="form.lastName"
                                    type="text"
                                    class="mt-1 block w-full"
                                    required
                                    autocomplete="lastName"
                                />
                                <InputError class="mt-2" :message="form.errors.lastName" />
                            </div>

                            <div class="mt-4">
                                <InputLabel for="email" value="Email" />
                                <TextInput
                                    id="email"
                                    v-model="form.email"
                                    type="email"
                                    class="mt-1 block w-full"
                                    required
                                    autocomplete="username"
                                />
                                <InputError class="mt-2" :message="form.errors.email" />
                            </div>

                            <div class="mt-4">
                                <InputLabel for="password" value="Mot de passe" />
                                <TextInput
                                    id="password"
                                    v-model="form.password"
                                    type="password"
                                    class="mt-1 block w-full"
                                    required
                                    autocomplete="new-password"
                                />
                                <InputError class="mt-2" :message="form.errors.password" />
                            </div>
                            <div class="mt-8 w-full">
                                <button type="submit" class="flex mx-auto text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">Créer</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            </div>
        </div>
    </AppLayout>
</template>
