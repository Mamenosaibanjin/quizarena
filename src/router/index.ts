import { createRouter, createWebHistory } from "vue-router";
import QuestionDisplay from "@/components/QuestionDisplay.vue";
import Highscore from "@/components/Highscore.vue";
import Login from "@/components/Login.vue";
import Register from "@/components/Register.vue";
import QuestionForm from "@/components/QuestionForm.vue";

const routes = [
  { path: "/QuestionDisplay", component: QuestionDisplay },
  { path: "/login", component: Login },
  { path: "/Highscore", component: Highscore },
  { path: "/QuestionForm", component: QuestionForm },
  { path: "/Register", component: Register },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
