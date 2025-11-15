<template>
  <button @click="loginWithGoogle">
    Google ログイン
  </button>
</template>

<script setup>
import { GoogleAuthProvider, signInWithPopup } from "firebase/auth";
import { auth } from "@/firebase";

const provider = new GoogleAuthProvider();

const loginWithGoogle = async () => {
  try {
    await signInWithPopup(auth, provider);
    console.log("Google ログイン成功");
  } catch (error) {
    console.error(error);
  }
};

</script>

<style>

</style>