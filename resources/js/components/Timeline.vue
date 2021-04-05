<template>
  <ul>
    <li v-for="guess in guesses" v-bind:key="guess.id">
      <span v-if="guess.status === 'correct'" class="text-green-500">
        {{ guess.track }} was correct!
      </span>
      <span v-else-if="guess.status === 'close'" class="text-orange-300">
        {{ guess.track }} was close!
      </span>
      <span v-else> {{ guess.player.name }} guessed {{ guess.track }} </span>
    </li>
  </ul>
</template>

<script lang="ts">
import Guess from "../models/Guess";
import Player from "../models/Player";
import { defineComponent, PropType } from "vue";

export default defineComponent({
  name: "Timeline",
  props: {
    channel: {
      type: String,
      required: true,
    },
    player: {
      type: Object as PropType<Player>,
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
      if (guess.player.id === this.player.id || guess.status != "correct") {
        this.guesses.push(guess);
      }
    });
  },
});
</script>
