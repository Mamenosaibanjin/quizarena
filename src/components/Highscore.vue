<script setup>
import { ref, onMounted } from "vue";
import api from "@/services/api.js"; // Importiere die API-Funktion

const highscores = ref([]);
const loading = ref(true);

const fetchHighscores = async () => {
  try {
    const response = await api.get("/highscores");
    highscores.value = response.data;
  } catch (error) {
    console.error("Fehler beim Abrufen der Highscores:", error);
  } finally {
    loading.value = false;
  }
};

onMounted(fetchHighscores);
</script>

<template>
  <div>
    <h2>🏆 Highscore-Liste</h2>
    <div v-if="loading">Lade Highscores...</div>
    <ul v-else>
      <li v-for="score in highscores" :key="score.id">
        {{ score.username }} - {{ score.points }} Punkte
      </li>
    </ul>
  </div>
</template>
