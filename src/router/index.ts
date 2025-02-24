import { createRouter, createWebHistory } from "vue-router";
import QuestionDisplay from "@/components/QuestionDisplay.vue";
import Highscore from "@/components/Highscore.vue";

const routes = [
  { path: "/QuestionDisplay", component: QuestionDisplay },
  { path: "/Highscore", component: Highscore },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
