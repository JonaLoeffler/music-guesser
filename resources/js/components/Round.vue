<template>
  <div class="text-center p-3">
    <h3 v-if="this.round">{{ __("Round") }} #{{ round.number }}</h3>
    <h3 v-else>{{ __("Waiting for next round...") }}</h3>
  </div>
</template>

<script lang="ts">
import __ from "../lang";
import { defineComponent } from "vue";

export default defineComponent({
  name: "Round",
  props: {
    channel: {
      type: String,
      required: true,
    },
  },
  data(): { round: App.Models.Round | null } {
    return {
      round: null,
    };
  },
  mounted(): void {
    window.Echo.join(this.channel).listen("RoundStarted", (round: App.Models.Round) => {
      this.round = round;

      setTimeout(
        () => (this.round = null),
        new Date(round.completes_at).getTime() - Date.now()
      );
    });
  },
  methods: {
    __: __,
  },
});
</script>
