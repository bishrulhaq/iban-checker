<template>
    <div class="p-4 text-center text-white md:h-screen">
        <h1 class="text-2xl font-bold mb-4">Validated IBANs</h1>
        <div v-if="ibansLoading" class="mb-4">Loading...</div>
        <ul v-else>
            <li v-for="iban in ibans" :key="iban.id" class="mb-2">
                {{ iban.iban }}
            </li>
        </ul>
        <Pagination :pagination="pagination" @pageChange="loadIbans" class="mt-4" />
    </div>
</template>
  
<script setup>
import api from '../api/api';
import { useUserStore } from '../stores/auth';
import { ref, onMounted } from 'vue';
import Pagination from '../components/Pagination.vue';

const userStore = useUserStore();
const ibans = ref([]);
const pagination = ref({});
const ibansLoading = ref(false);
const fetchError = ref(null);

const loadIbans = async (page = 1) => {
    ibansLoading.value = true;
    fetchError.value = null;

    try {
        const response = await api.get(`/api/fetch-validated-iban?page=${page}`);
        ibansLoading.value = false;
        const data = response.data;
        ibans.value = data.ibans;
        pagination.value = data.pagination;

    } catch (error) {
        fetchError.value = error.message;
    } finally {
        ibansLoading.value = false;
    }
};

onMounted(() => {
    loadIbans();
});
</script>
  