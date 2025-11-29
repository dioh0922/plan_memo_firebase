<template>
  <v-btn v-show="!authStore.isLogin()" @click="login" :loading="loading">ログイン</v-btn>
  <v-btn v-show="authStore.isLogin()" @click="logout" :loading="loading">ログアウト</v-btn>
</template>

<script setup>
import { useAuthStore } from '@/store/auth'
import { ref } from 'vue'
const authStore = useAuthStore()
const loading = ref(false)
const login = () => {
  loading.value = true
  authStore.loginWithGoogle().finally(() => {
    loading.value = false
  })
}
const logout = () => {
  loading.value = true
  authStore.logout().finally(() => {
    loading.value = false
  })
}

</script>

<style>

</style>