<template>
  <div class="bg-gray-50 dark:bg-gray-900">
    <nav class="border-gray-200 bg-gray-50 dark:bg-gray-800 dark:border-gray-700">
      <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
        <router-link to="/" class="flex items-center space-x-3 rtl:space-x-reverse">
          <img src="./assets/images/iban.png" class="h-8" alt="Flowbite Logo" />
          <span class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white">IBAN Checker</span>
        </router-link>
        <button data-collapse-toggle="navbar-solid-bg" type="button"
          class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
          aria-controls="navbar-solid-bg" aria-expanded="false">
          <span class="sr-only">Open main menu</span>
          <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M1 1h15M1 7h15M1 13h15" />
          </svg>
        </button>
        <div class="hidden w-full md:block md:w-auto" id="navbar-solid-bg">
          <ul v-if="isLoggedIn"
            class="flex flex-col font-medium mt-4 rounded-lg bg-gray-50 md:space-x-8 rtl:space-x-reverse md:flex-row md:mt-0 md:border-0 md:bg-transparent dark:bg-gray-800 md:dark:bg-transparent dark:border-gray-700">
            <li>
              <router-link to="/dashboard"
                class="block py-2 px-3 md:p-0 text-white bg-blue-700 rounded md:bg-transparent md:text-blue-700 md:dark:text-blue-500 dark:bg-blue-600 md:dark:bg-transparent"
                aria-current="page">Dashboard</router-link>
            </li>

            <li v-if="userStore.isAdmin">
              <router-link to="/validated-iban"
                class="block py-2 px-3 md:p-0 text-white bg-blue-700 rounded bg-primary-600 md:text-blue-700 md:dark:text-blue-500 dark:bg-blue-600 md:dark:bg-transparent"
                aria-current="page">Validated IBAN's</router-link>
            </li>

            <li>
              <button @click="logout"
                class="block py-2 px-3 md:p-0 text-white bg-blue-700 rounded bg-primary-600 md:text-blue-700 md:dark:text-blue-500 dark:bg-blue-600 md:dark:bg-transparent"
                aria-current="page">Logout</button>
            </li>

          </ul>

          <ul v-else
            class="flex flex-col font-medium mt-4 rounded-lg bg-gray-50 md:space-x-8 rtl:space-x-reverse md:flex-row md:mt-0 md:border-0 md:bg-transparent dark:bg-gray-800 md:dark:bg-transparent dark:border-gray-700">
            <li>
              <router-link to="/login"
                class="block py-2 px-3 md:p-0 text-white bg-blue-700 rounded md:bg-transparent md:text-blue-700 md:dark:text-blue-500 dark:bg-blue-600 md:dark:bg-transparent"
                aria-current="page">Login</router-link>
            </li>
            <li>
              <router-link to="/register"
                class="block py-2 px-3 md:p-0 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">
                Register</router-link>
            </li>
          </ul>
        </div>
      </div>
    </nav>

    <main class="py-6">
      <notifications />
      <router-view />
    </main>
  </div>
</template>

<script setup>
import { computed } from 'vue';
import { useUserStore } from './stores/auth';
import { useRouter } from 'vue-router';

const userStore = useUserStore();
const router = useRouter();

const isLoggedIn = computed(() => !!userStore.token);

function logout() {
  userStore.reset();
  router.push('/login');
}
</script>
