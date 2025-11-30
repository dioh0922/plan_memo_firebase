import { defineStore } from 'pinia'
import { ref } from 'vue'
import { GoogleAuthProvider, signInWithPopup, signOut } from 'firebase/auth'
import { auth, db } from '@/firebase'
import { ref as dbRef, get} from "firebase/database"

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
        uid: result.user.uid,
        role: null
      }
      await loadRole(result.user.uid)
    } catch (error) {
      alert(error.message)
    }
  }

  const logout = async () => {
    await signOut(auth)
    isLoggedIn.value = false
    user.value = null
  }

  const loadRole = async (uid) => {
    const dataRef = dbRef(db, '/' + uid)
    const snapshot = await get(dataRef)
    if(snapshot.exists()){
      const userDetail = snapshot.val()
      user.value.role = userDetail.role
    }
  }

  const checkRole = () => {
    return user.value && user.value.role === 'admin'
  }

  if (auth.currentUser) {
    isLoggedIn.value = true
  }

  return { user, loginWithGoogle, logout, isLogin, checkRole }
  
})

