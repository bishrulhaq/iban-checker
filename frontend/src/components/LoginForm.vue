<template>
  <section>
    <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">
      <div
        class="w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700">
        <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
          <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
            Sign in to your account
          </h1>
          <Form :validation-schema="schema" @submit="login">
            <div class="py-2">
              <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your email</label>
              <Field v-model="user_email" type="email" name="email"
                class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
              <ErrorMessage name="email" class="error-message" />
            </div>
            <div class="py-2">
              <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password</label>
              <Field v-model="user_password" type="password" name="password"
                class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
              <ErrorMessage name="password" class="error-message" />
            </div>
            <button type="submit"
              class="w-full text-white bg-blue-600 my-2 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:hover:bg-primary-700 dark:focus:ring-primary-800">Sign
              in</button>
            <p class="text-sm font-light text-gray-500 dark:text-gray-400 my-2">
              Don’t have an account yet? <span @click="$emit('toggleForms')"
                class="font-medium text-primary-600 hover:underline dark:text-primary-500">Sign up</span>
            </p>
          </Form>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref } from 'vue';
import { Field, Form, ErrorMessage } from 'vee-validate';
import * as yup from 'yup';
import { useUserStore } from '../stores/auth';
import api from '../api/api';
import { useRouter } from 'vue-router';
import { useNotification } from "@kyvg/vue3-notification";

const props = defineProps({
  showForm: String,
});

const router = useRouter();
const userStore = useUserStore();
const { notify } = useNotification()
const user_email = ref('');
const user_password = ref('');

const schema = yup.object({
  email: yup.string().email('Please enter a valid email').required('Email is required'),
  password: yup.string().min(8, 'Password must be at least 8 characters').required('Password is required')
});

async function login() {
  try {
    const response = await api.post('/api/login', { email: user_email.value, password: user_password.value });
    userStore.setToken(response.data.token, response.data.expires_in);
    userStore.setUser(response.data.user);

    notify({
      type: 'success',
      text: 'Login successful!'
    });

    router.push('/dashboard');

  } catch (error) {
    notify({
      type: 'error',
      text: error.response.data.error || error.response.data.message || 'Registration failed'
    });
  }
}
</script> 
<style scoped>
.error-message {
  color: red;
}
</style>