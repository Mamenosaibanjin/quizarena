import axios from "axios";

const api = axios.create({
  baseURL: import.meta.env.VITE_API_BASE_URL || "http://localhost:8000/api", // Dein Backend-URL
  withCredentials: true, // Stellen Sie sicher, dass Cookies mitgeschickt werden
});

// Interceptor für Anfragen: Token setzen, wenn vorhanden
api.interceptors.request.use(
  (config) => {
    const token = localStorage.getItem("token");
    if (token) {
      config.headers.Authorization = `Bearer ${token}`;
    }
    return config;
  },
  (error) => Promise.reject(error)
);

export default api;
