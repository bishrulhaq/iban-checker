<template>
    <div>
        <LoginForm v-if="showForm === '/login'" :showForm="showForm" @toggleForms="toggleForms" />
        <RegisterForm v-if="showForm === '/register'" :showForm="showForm" @toggleForms="toggleForms" />
    </div>
</template>
  
<script setup>
import { ref, watch, onMounted } from 'vue';
import LoginForm from '../components/LoginForm.vue';
import RegisterForm from '../components/RegisterForm.vue';
import { useRouter } from 'vue-router';

const showForm = ref('/login');
const router = useRouter();

function toggleForms() {
    showForm.value = showForm.value === '/login' ? '/register' : '/login';
    updateRouteParam();
}

function updateRouteParam() {
    const formType = showForm.value ? '/login' : '/register';
    if (router.currentRoute.value.path !== formType) {
        router.push({ path: formType });
    }
}

onMounted(() => {
    const currentRoute = router.currentRoute.value;
    showForm.value = currentRoute.path;

    if (currentRoute.path === '/') {
        router.replace('/login');
    }
});

watch(() => router.currentRoute.value.path, (path) => {
    showForm.value = path;
    if (showForm.value === `/`) {
        router.push({ path: '/login' });
    }


});

</script>