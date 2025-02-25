<template>
    <div class="login-container">
      <h2>Login</h2>
      <form @submit.prevent="login">
        <div>
          <label for="email">E-Mail:</label>
          <input type="email" v-model="email" required />
        </div>
        <div>
          <label for="password">Passwort:</label>
          <input type="password" v-model="password" required />
        </div>
        <button type="submit">Login</button>
      </form>
      <p v-if="errorMessage" class="error">{{ errorMessage }}</p>
    </div>
  </template>
  
  <script>
  import api from "@/services/api";
  
  export default {
    data() {
      return {
        email: "",
        password: "",
        errorMessage: "",
      };
    },
    methods: {
      async login() {
        try {
          const response = await api.post("/login", {
            email: this.email,
            password: this.password,
          });
  
          const token = response.data.token;
          localStorage.setItem("token", token);
  
          // Weiterleitung zur geschützten Seite (z. B. Dashboard)
          this.$router.push("/dashboard");
        } catch (error) {
          this.errorMessage = "Login fehlgeschlagen. Überprüfe deine Eingaben.";
        }
      },
    },
  };
  </script>
  
  <style scoped>
  .login-container {
    max-width: 300px;
    margin: auto;
    padding: 20px;
    border: 1px solid #ccc;
    border-radius: 5px;
    text-align: center;
  }
  .error {
    color: red;
    margin-top: 10px;
  }
  </style>
  