<template>
    <div v-if="show" class="toast" :class="type">
      {{ message }}
    </div>
  </template>

  <script setup>
  import { ref, onMounted, watch } from 'vue';

  const props = defineProps({
    message: String,
    type: { type: String, default: 'info' },
    duration: { type: Number, default: 3000 }
  });

  const show = ref(false);

  function displayToast() {
    show.value = true;
    setTimeout(() => {
      show.value = false;
    }, props.duration);
  }

  onMounted(displayToast);

  watch(() => props.message, displayToast);
  </script>

  <style scoped>
  .toast {
    position: fixed;
    top: 20px;
    right: 20px;
    padding: 10px 20px;
    border-radius: 4px;
    color: white;
    z-index: 9999;
  }

  .info { background-color: #3498db; }
  .success { background-color: #2ecc71; }
  .warning { background-color: #f39c12; }
  .error { background-color: #e74c3c; }
  </style>
