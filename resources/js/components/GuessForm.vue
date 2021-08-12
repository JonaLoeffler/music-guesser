<template>
  <form @submit.prevent method="post">
    <div class="flex">
      <input
        type="text"
        name="track"
        id="input_track"
        :placeholder="__('Track name')"
        v-model="guess.track"
        class="text-center text-3xl flex-grow"
        autofocus
      />
      <button
        type="submit"
        @click="submit"
        class="btn btn-primary disabled:opacity-50"
        :disabled="this.round === null"
      >
        {{ __("Send!") }}
      </button>
    </div>
  </form>
</template>

<script lang="ts">
import __ from "../lang";
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
  data(): { guess: { track: string }; round: App.Models.Round | null } {
    return {
      guess: {
        track: "",
      },
      round: null,
    };
  },
  methods: {
    __: __,
    submit(): void {
      if (this.round) {
        window.axios
          .post(`/rounds/${this.round.id}/guesses`, this.guess)
          .then((response: AxiosResponse) => {})
          .catch((error: AxiosError) => console.log(error));

        this.guess.track = "";
      } else {
        console.log("Round not started");
      }
    },
  },
  mounted(): void {
    window.Echo.join(this.channel).listen(
      "RoundStarted",
      (round: App.Models.Round) => (this.round = round)
    );
  },
});
</script>
