import { defineStore } from 'pinia'
import { ref } from 'vue'
import { GoogleAuthProvider, signInWithPopup, onAuthStateChanged, signOut } from 'firebase/auth'
import { auth } from '@/firebase'

export const useAuthStore = defineStore('auth', () => {
  const isLoggedIn = ref(false)
  const user = ref(null)
  
  const provider = new GoogleAuthProvider()

  const isLogin = () => {
    return isLoggedIn.value
  }
  
  const loginWithGoogle = async () => {
    try {
      const result = await signInWithPopup(auth, provider)
      isLoggedIn.value = true
      user.value = {
        name: result.user.displayName,
        email: result.user.email,
        uid: result.user.uid
      }
    } catch (error) {
      alert(error.message)
    }
  }

  const logout = async () => {
    await signOut(auth)
    isLoggedIn.value = false
    user.value = null
  }

  onAuthStateChanged(auth, () => {
  })

  return { user, loginWithGoogle, logout, isLogin }
  
})

