<template>
    <div v-show="disp" id="overlay"></div>
</template>

<script setup>
import { defineProps } from 'vue'
defineProps({
  disp: Boolean
})
</script>

<style>
#overlay{
  position: absolute;
  left: 0; top: 0;
  width: 100%; height: 100%;
  background: rgba(100, 100, 100, .8);
  z-index: 2147483647;
}
</style>
