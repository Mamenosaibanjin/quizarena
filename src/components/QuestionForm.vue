<template>
    <form @submit.prevent="submitForm">
      <!-- Auswahl der Kategorie -->
      <select v-model="category" required>
        <option v-for="cat in categories" :key="cat.id" :value="cat.id">{{ cat.name }}</option>
      </select>
  
      <button type="button" @click="showCategoryInput = !showCategoryInput">Neue Kategorie erstellen</button><br>
  
      <div v-if="showCategoryInput">
        <input v-model="newCategory" type="text" placeholder="Neue Kategorie" required /><br>
        <textarea v-model="newCategoryDescription" placeholder="Beschreibung der Kategorie" rows="4"></textarea><br>
        <button type="button" @click="createCategory">Kategorie speichern</button><br><br>
      </div>
  
      <!-- Auswahl der Regel -->
      <select v-model="rule">
        <option v-for="rule in rules" :key="rule.id" :value="rule.id">{{ rule.name }}</option>
      </select>
  
      <button type="button" @click="showRuleInput = !showRuleInput">Neue Regel erstellen</button><br>
  
      <div v-if="showRuleInput">
        <input v-model="newRule" type="text" placeholder="Neue Regel" required /><br>
        <input v-model="newRulePoints" type="number" placeholder="Punkte" required /><br>
        <input v-model="newRuleCondition" type="text" placeholder="Bedingung (z.B. answered_in < 10s)" /><br>
        <button type="button" @click="createRule">Regel speichern</button><br><br>
      </div>
  
      <!-- Frageeingabe -->
      <input v-model="questionText" type="text" placeholder="Frage" required /><br>
  
      <!-- Auswahl des Fragetypes -->
      <select v-model="type" required>
        <option value="text">Freitext</option>
        <option value="multiple_choice">Multiple Choice</option>
      </select>
  
      <!-- Multiple-Choice-Optionen -->
      <div v-if="type === 'multiple_choice'">
        <input v-model="answers[0]" type="text" placeholder="Antwort" required />
        
        <!-- Falsche Antworten (dynamisch hinzufügen) -->
        <div v-for="(answer, index) in falseAnswers" :key="index">
          <input v-model="falseAnswers[index]" type="text" :placeholder="'Falsche Antwort ' + (index + 1)" />
        </div>
        <button type="button" @click="addFalseAnswer">Falsche Antwort hinzufügen</button>
      </div>
  
      <button type="submit">Frage speichern</button>
    </form>
  </template>
  
  <script>
  import api from "@/services/api";
  
  export default {
    data() {
      return {
        category: null,
        rule: null,
        questionText: "",
        answers: ["", ""],
        falseAnswers: [],
        type: "text",
        categories: [],
        rules: [],
        newCategory: "",
        newCategoryDescription: "",
        newRule: "",
        newRulePoints: 0,
        newRuleCondition: "",
        showCategoryInput: false,
        showRuleInput: false,
      };
    },
    async mounted() {
      try {
        const categoriesResponse = await api.get("/categories");
        const rulesResponse = await api.get("/rules");
        this.categories = categoriesResponse.data;
        this.rules = rulesResponse.data;
      } catch (error) {
        console.error("Fehler beim Laden der Kategorien und Regeln:", error.response ? error.response.data : error.message);
    }
    },
    methods: {
      async submitForm() {
        const formData = {
          category_id: this.category,
          rule_id: this.rule,
          question_text: this.questionText,
          type: this.type,
          answers: this.answers,
          false_answers: this.falseAnswers,
        };

        if (!localStorage.getItem("token")) {
            alert("Bitte zuerst einloggen!");
            return;
        }
  
        try {
          await api.post("/questions", formData);
          alert("Frage erfolgreich erstellt!");
        } catch (error) {
          console.error("Fehler beim Erstellen der Frage", error);
          alert("Fehler beim Erstellen der Frage");
        }
      },
      async createCategory() {
        if (this.newCategory.trim() === "") return;
  
        try {
          const response = await api.post("/categories", { name: this.newCategory, description: this.newCategoryDescription });
          this.categories.push(response.data); // Kategorie zur Liste hinzufügen
          this.category = response.data.id; // Setze die neue Kategorie als gewählt
          this.newCategory = ""; // Eingabefeld leeren
          this.newCategoryDescription = ""; // Beschreibung leeren
          this.showCategoryInput = false; // Eingabefeld ausblenden
        } catch (error) {
          console.error("Fehler beim Erstellen der Kategorie", error);
        }
      },
      async createRule() {
        if (this.newRule.trim() === "") return;
  
        try {
          const response = await api.post("/rules", { 
            name: this.newRule, 
            points: this.newRulePoints, 
            condition: this.newRuleCondition 
          });
          this.rules.push(response.data); // Regel zur Liste hinzufügen
          this.rule = response.data.id; // Setze die neue Regel als gewählt
          this.newRule = ""; // Eingabefeld leeren
          this.newRulePoints = 0; // Punkte zurücksetzen
          this.newRuleCondition = ""; // Bedingung zurücksetzen
          this.showRuleInput = false; // Eingabefeld ausblenden
        } catch (error) {
          console.error("Fehler beim Erstellen der Regel", error);
        }
      },
      addAnswer() {
        this.answers.push(""); // Neue Antwort hinzufügen
      },
      addFalseAnswer() {
        this.falseAnswers.push(""); // Neue falsche Antwort hinzufügen
      }
    },
  };
  </script>
  