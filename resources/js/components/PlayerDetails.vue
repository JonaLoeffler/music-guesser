<template>
  <form @submit.prevent method="post">
    <input
      type="text"
      name="player.name"
      id="input-player-name"
      v-model="player.name"
    />
    <button type="submit" @click="submit" class="btn btn-primary p-1">
      Speichern
    </button>
  </form>
</template>

<script lang="ts">
import Player from "../classes/Player";
import { defineComponent, PropType } from "vue";
import { AxiosResponse, AxiosError } from "axios";

export default defineComponent({
  props: {
    initial: {
      type: Object as PropType<Player>,
      required: true,
    },
  },
  data() {
    return {
      player: { ...this.initial },
    };
  },
  methods: {
    submit() {
      window.axios
        .patch(`/players/${this.player.id}`, this.player)
        .then((response: AxiosResponse) => (this.player = response.data.data))
        .catch((error: AxiosError) => console.log(error));
    },
  },
});
</script>