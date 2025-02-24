<script setup>
import { ref, onMounted } from "vue";
import api from "@/services/api"; // Importiere die API-Funktion

const questions = ref([]);
const loading = ref(true);

const fetchQuestions = async () => {
  try {
    const response = await api.get("/questions");
    questions.value = response.data;
  } catch (error) {
    console.error("Fehler beim Abrufen der Fragen:", error);
  } finally {
    loading.value = false;
  }
};

onMounted(fetchQuestions);
</script>

<template>
  <div>
    <h2>Quiz Fragen</h2>
    <div v-if="loading">Lade Fragen...</div>
    <div v-else>
      <div v-for="question in questions" :key="question.id">
        <p>{{ question.question_text }}</p>
        <!-- Antworten anzeigen -->
        <ul>
          <li v-for="answer in question.answers" :key="answer.id">
            {{ answer.text }}
          </li>
        </ul>
      </div>
    </div>
  </div>
</template>
