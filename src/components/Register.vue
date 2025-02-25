<template>
    <div>
      <h2>Registrieren</h2>
      <form @submit.prevent="register">
        <div>
          <label>Name:</label>
          <input v-model="name" type="text" required />
        </div>
        <div>
          <label>Email:</label>
          <input v-model="email" type="email" required />
        </div>
        <div>
          <label>Passwort:</label>
          <input v-model="password" type="password" required />
        </div>
        <div>
          <label>Passwort bestätigen:</label>
          <input v-model="password_confirmation" type="password" required />
        </div>
        <button type="submit">Registrieren</button>
      </form>
    </div>
  </template>
  
  <script>
  import api from "@/services/api";
  
  export default {
    data() {
      return {
        name: "",
        email: "",
        password: "",
        password_confirmation: "",
      };
    },
    methods: {
      async register() {
        try {
          const response = await api.post("/register", {
            name: this.name,
            email: this.email,
            password: this.password,
            password_confirmation: this.password_confirmation,
          });
  
          localStorage.setItem("token", response.data.token);
          api.defaults.headers.common["Authorization"] = `Bearer ${response.data.token}`;
          alert("Registrierung erfolgreich!");
          this.$router.push("/dashboard"); // Weiterleitung nach erfolgreicher Registrierung
        } catch (error) {
          console.error("Fehler bei der Registrierung:", error.response.data);
          alert("Fehler bei der Registrierung: " + (error.response.data.message || "Unbekannter Fehler"));
        }
      },
    },
  };
  </script>
  