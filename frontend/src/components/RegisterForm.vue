<template>
    <section>
        <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">
            <div
                class="w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700">
                <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                    <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
                        Register your account
                    </h1>

                    <Form :validation-schema="schema" @submit="register">
                        <div class="py-2">
                            <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your
                                Name</label>
                            <Field v-model="name" type="text" name="name" id="name"
                                class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                required="" />
                            <ErrorMessage name="name" class="error-message" />
                        </div>

                        <div class="py-2">
                            <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your
                                email</label>
                            <Field v-model="email" type="email" name="email" id="email"
                                class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                required="" />
                            <ErrorMessage name="email" class="error-message" />
                        </div>

                        <div class="py-2">
                            <label for="password"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password</label>
                            <Field v-model="password" type="password" name="password" id="password"
                                class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                required="" />
                            <ErrorMessage name="password" class="error-message" />
                        </div>

                        <div class="py-2">
                            <label for="password_confirmation"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Confirm
                                Password</label>
                            <Field v-model="passwordConfirmation" type="password" name="password_confirmation"
                                id="password_confirmation"
                                class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                required="" />
                            <ErrorMessage name="password_confirmation" class="error-message" />
                        </div>

                        <button type="submit"
                            class="w-full text-white my-2 bg-blue-600 hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">Register</button>

                        <p class="text-sm font-light text-gray-500 dark:text-gray-400 my-2">
                            Already Have an account, <span @click="$emit('toggleForms')"
                                class="font-medium text-primary-600 hover:underline dark:text-primary-500">Sign In</span>
                        </p>
                    </Form>
                </div>
            </div>
        </div>
    </section>
</template>


<script setup>
import { ref } from 'vue';
import { Field, Form, ErrorMessage, defineRule } from 'vee-validate';
import * as yup from 'yup';
import api from '../api/api';
import { useRouter } from 'vue-router';
import { useUserStore } from '../stores/auth';
import { useNotification } from "@kyvg/vue3-notification";

const schema = yup.object({
    name: yup.string().min(2, 'Name must be at least 2 characters').required('Name is required'),
    email: yup.string().email('Please enter a valid email').required('Email is required'),
    password: yup.string().min(8, 'Password must be at least 8 characters').required('Password is required'),
    password_confirmation: yup.string().oneOf([yup.ref('password'), null], 'Passwords must match')
});

defineRule('required', value => {
    if (!value || value.length === 0) {
        return 'This field is required';
    }
    return true;
});

const router = useRouter();
const userStore = useUserStore();
const { notify } = useNotification();

const name = ref('');
const email = ref('');
const password = ref('');
const passwordConfirmation = ref('');

async function register() {
    try {
        const response = await api.post('/api/register', {
            name: name.value,
            email: email.value,
            password: password.value,
            password_confirmation: passwordConfirmation.value
        });

        userStore.setToken(response.data.token, response.data.expires_in);
        userStore.setUser(response.data.user);

        notify({
            type: 'success',
            text: 'Registration successful!'
        });

        router.push('/dashboard');

    } catch (error) {
        if (error.response && error.response.data) {

            notify({
                type: 'error',
                text: error.response.data.error || error.response.data.message || 'Registration failed'
            });
        } else {
            notify({
                type: 'error',
                text: 'Registration failed'
            });
        }
    }
}
</script>
<style scoped>
.error-message {
    color: red;
}
</style>