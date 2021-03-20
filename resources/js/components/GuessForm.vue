<template>
  <form @submit.prevent method="post">
    <input
      type="text"
      name="song"
      id="input_song"
      placeholder="Song Name"
      v-model="guess.song"
      class="border border-gray-200"
      required
      autofocus
    />
    -
    <input
      type="text"
      name="artist"
      id="input_artist"
      placeholder="Artist Name"
      v-model="guess.artist"
      class="border border-gray-300"
      required
    />
    <button type="submit" @click="submit" class="btn btn-primary p-1">
      Done
    </button>
  </form>
</template>

<script lang="ts">
import { defineComponent } from "vue";

export default defineComponent({
  name: "GuessForm",
  data() {
    return {
      guess: {
        artist: "",
        song: "",
      },
    };
  },
  methods: {
    submit() {
      console.log(`Submitting ${this.guess.artist}-${this.guess.song}`);
    },
  },
});
</script>
