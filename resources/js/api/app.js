import axios from 'axios'

const api = axios.create({
    baseURL: import.meta.env.VITE_API_URL,
    headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json'
    },
    withCredentials: true
})

// Добавляем токен в заголовки
api.interceptors.request.use(config => {
    const token = localStorage.getItem('auth_token')
    if (token) {
        config.headers.Authorization = `Bearer ${token}`
        console.log('Authorization token added to headers:', token)
    } else {
        console.warn('No auth token found in localStorage')
    }
    return config
})

export default {
    async authWithTelegram(initData) {
        try {
            const response = await api.post('/auth/telegram', {
                initData: decodeURIComponent(initData)
            }, {
                headers: {
                    'X-Telegram-Init-Data': decodeURIComponent(initData)
                }
            })
            console.log('Data: ', response.data)
            localStorage.setItem('auth_token', response.data.token)
            return response.data.user
        } catch (error) {
            console.error('Auth error:', error.response?.data || error.message)
            throw error
        }
    },

    async getCurrentUser() {
        try {
            console.log('Attempting to get current user...')
            const response = await api.get('/user')
            console.log('User data received:', response.data)
            return response.data
        } catch (error) {
            console.error('Error fetching user:', error)
            throw error
        }
    },

    async getTodayEvents() {
        try {
            console.log('Fetching today events...')
            const response = await api.get('/events/today')
            return response.data
        } catch (error) {
            console.error('Error fetching events:', error)
            throw error
        }
    },

    isTelegramWebApp() {
        return !!window.Telegram?.WebApp
    }
}
