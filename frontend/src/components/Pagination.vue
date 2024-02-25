<template>
    <nav>
      <ul class="pagination">
        <li :class="{ disabled: pagination.current_page === 1 }">
          <a @click.prevent="emitPage(1)">First</a>
        </li>
  
        <li :class="{ disabled: pagination.current_page === 1 }">
          <a @click.prevent="emitPage(pagination.current_page - 1)">Previous</a>
        </li>
  
        <li v-for="page in pages" :key="page" :class="{ active: page === pagination.current_page }">
          <a @click.prevent="emitPage(page)">{{ page }}</a>
        </li>
  
        <li :class="{ disabled: pagination.current_page === pagination.last_page }">
          <a @click.prevent="emitPage(pagination.current_page + 1)">Next</a>
        </li>
  
        <li :class="{ disabled: pagination.current_page === pagination.last_page }">
          <a @click.prevent="emitPage(pagination.last_page)">Last</a>
        </li>
      </ul>
    </nav>
  </template>
  
  <script setup>
  import { ref, computed } from 'vue';
  
  const props = defineProps({
    pagination: {
      type: Object,
      required: true,
    },
  });
  
  const emit = defineEmits(['pageChange']);
  
  const pages = computed(() => {
    let start = props.pagination.current_page - 2; // Show 2 pages before current
    let end = props.pagination.current_page + 2; // Show 2 pages after current
  
    if (start < 1) {
      end += (1 - start);
      start = 1;
    }
    if (end > props.pagination.last_page) {
      start -= (end - props.pagination.last_page);
      end = props.pagination.last_page;
    }
    if (start < 1) start = 1; 
  
    return Array.from({ length: (end - start + 1) }, (v, k) => start + k);
  });
  
  const emitPage = (page) => {
    emit('pageChange', page);
  };
  </script>
  
  <style scoped>
  .pagination {
    display: flex;
    list-style: none;
    margin: 20px 0;
    padding: 0;
  }
  
  .pagination li {
    margin-right: 5px;
  }
  
  .pagination li a {
    display: block;
    padding: 5px 10px;
    border: 1px solid #ddd;
    text-decoration: none;
  }
  
  .pagination li.active a {
    background-color: #eee;
  }
  
  .pagination li.disabled a {
    opacity: 0.5;
    cursor: default;
  }
  </style>
  