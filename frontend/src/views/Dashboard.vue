<template>
  <div v-if="isLoggedIn">
    <IBANValidator></IBANValidator>
  </div>
</template>

<script setup>
import { computed } from 'vue';
import { useUserStore } from '../stores/auth';
import IBANValidator from '../components/IBANValidator.vue';

const userStore = useUserStore();
const isLoggedIn = computed(() => !!userStore.token);

</script>