<template>
   <section>
      <div class="py-8 lg:py-16 px-4 mx-auto max-w-screen-md md:h-screen" @submit="validateIBAN">
         <h2 class="mb-4 text-4xl tracking-tight font-extrabold text-center text-gray-900 dark:text-white">IBAN Checker
         </h2>
         <p class="mb-8 lg:mb-16 font-light text-center text-gray-500 dark:text-gray-400 sm:text-xl">Welcome to IBAN
            Checker</p>
         <Form class="space-y-8" :validation-schema="schema" @submit="validateIBAN">
            <div class="py-2">
               <label for="iban" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Enter IBAN</label>
               <Field type="text" id="iban" name="iban" v-model="iban"
                  class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 dark:shadow-sm-light"
                  placeholder="Enter IBAN" required />
               <ErrorMessage name="iban" class="error-message" />
            </div>
            <button type="submit"
               class="py-3 px-5 text-sm font-medium text-center text-white rounded-lg bg-blue-500 sm:w-fit focus:ring-4 focus:outline-none focus:ring-primary-300">
               Validate
            </button>
         </Form>

         <div v-if="validationMessage" class="notification py-2 px-2 text-center text-white">
            {{ validationMessage }}
         </div>
      </div>
   </section>
</template>

<script setup>
import { ref } from 'vue';
import api from '../api/api';
import { Field, Form, ErrorMessage } from 'vee-validate';
import * as yup from 'yup';
import { useNotification } from "@kyvg/vue3-notification";

const iban = ref('');
const { notify } = useNotification()
const validationMessage = ref(null);

const schema = yup.object({
   iban: yup.string().required('IBAN is required')
});

async function validateIBAN() {

   try {
      const response = await api.get('/api/validate-iban', { params: { iban: iban.value } });

      validationMessage.value = response.data.message;
      
      notify({
         type: 'success',
         text: response?.data.message
      });

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