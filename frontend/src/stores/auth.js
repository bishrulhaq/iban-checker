import { defineStore } from 'pinia'
import api from '../api/api'

export const useUserStore = defineStore('auth', {
  state: () => ({
    token: localStorage.getItem('authToken') || null,
    user: JSON.parse(localStorage.getItem('authUser')) || null,
    tokenExpiration: localStorage.getItem('tokenExpiration') ? Number(localStorage.getItem('tokenExpiration')) : null
  }),
  getters: {
    isAuthenticated: (state) => !!state.token,
    isTokenExpired: (state) => !!state.tokenExpiration,
    isAdmin: (state) => state.user.roles.includes('admin') ?? false
  },
  actions: {
    setToken (token, expiration) {
      this.token = token
      this.tokenExpiration = expiration
      localStorage.setItem('authToken', token)
      localStorage.setItem('tokenExpiration', expiration)
    },
    setUser (user) {
      this.user = user
      localStorage.setItem('authUser', JSON.stringify(user))
    },
    reset () {
      this.token = null
      this.user = []
      this.tokenExpiration = null
      localStorage.removeItem('authUser')
      localStorage.removeItem('authToken')
      localStorage.removeItem('tokenExpiration')
    },
    async fetchUser () {
      if (!this.token) return

      try {
        const response = await api.get('/api/user')
        this.user = response.data
      } catch (error) {
        console.error(error)
      }
    }
  }
})
