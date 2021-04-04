<template>
  <ul>
    <li v-for="guess in guesses" v-bind:key="guess.id">
      {{ guess.player.name }} guessed {{ guess.track }}
    </li>
  </ul>
</template>

<script lang="ts">
import Guess from "../models/Guess";
import { defineComponent, PropType } from "vue";

export default defineComponent({
  name: "Timeline",
  props: {
    channel: {
      type: String,
      required: true,
    },
  },
  data(): { guesses: Guess[] } {
    return {
      guesses: [],
    };
  },
  mounted() {
    window.Echo.join(this.channel).listen("GuessReceived", (guess: Guess) => {
      this.guesses.push(guess);
    });
  },
});
</script>
