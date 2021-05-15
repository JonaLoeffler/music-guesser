<template>
  <div class="text-center p-3">
    <h3 v-if="this.round">Runde #{{ round.number }}</h3>
    <h3 v-else>Warte auf nächste Runde...</h3>
  </div>
</template>

<script lang="ts">
import Round from "../models/Round";
import { defineComponent } from "vue";

export default defineComponent({
  name: "Round",
  props: {
    channel: {
      type: String,
      required: true,
    },
  },
  data(): { round: Round | null } {
    return {
      round: null,
    };
  },
  mounted():void {
    window.Echo.join(this.channel).listen("RoundStarted", (round: Round) => {
      this.round = round;

      setTimeout(
        () => (this.round = null),
        new Date(round.completes_at).getTime() - Date.now()
      );
    });
  },
});
</script>
