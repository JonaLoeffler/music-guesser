<template>
  <form @submit.prevent method="post">
    <input
      type="text"
      name="track"
      id="input_track"
      placeholder="Track Name"
      v-model="guess.track"
      class="border border-gray-200"
      required
      autofocus
    />
    <button
      type="submit"
      @click="submit"
      class="btn btn-primary p-1 disabled:opacity-50"
      v-if="this.round"
    >
      Done
    </button>
  </form>
</template>

<script lang="ts">
import Round from "../models/Round";
import { defineComponent } from "vue";
import { AxiosError, AxiosResponse } from "axios";

export default defineComponent({
  name: "GuessForm",
  props: {
    channel: {
      type: String,
      required: true,
    },
  },
  data(): { guess: { track: string }; round: Round | null } {
    return {
      guess: {
        track: "",
      },
      round: null,
    };
  },
  methods: {
    submit() {
      if (this.round) {
        window.axios
          .post(`/rounds/${this.round.id}/guesses`, this.guess)
          .then((response: AxiosResponse) => console.log(response))
          .catch((error: AxiosError) => console.log(error));
      } else {
        console.log("Round not started");
      }
    },
  },
  mounted() {
    window.Echo.join(this.channel).listen(
      "PlayTrack",
      (round: Round) => (this.round = round)
    );
  },
});
</script>
