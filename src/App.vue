<template>
  <div>
    <h1>🎯 QuizArena</h1>
    <nav>
      <router-link to="/QuestionDisplay">Fragen</router-link> |
      <router-link to="/Highscore">Highscore</router-link>
    </nav>
    <router-view></router-view>
  </div>
</template>