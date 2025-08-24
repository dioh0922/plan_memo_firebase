<template>
  <link href="https://cdn.jsdelivr.net/npm/@mdi/font/css/materialdesignicons.min.css" rel="stylesheet">

  <div>
    <v-app>
      <v-app-bar app absolute color="primary">
        <v-app-bar-title>
          実現機能ネタまとめ
        </v-app-bar-title>
      </v-app-bar>
      <v-main>
        <RouteList />
      </v-main>
    </v-app>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import RouteList from './components/routeList.vue'
  const isInit = ref(false)
  onMounted(() => {
    isInit.value = true
  })
</script>
