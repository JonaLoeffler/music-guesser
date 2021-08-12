<template>
  <form @submit.prevent method="post">
    <input
      type="text"
      name="player.name"
      id="input-player-name"
      v-model="player.name"
    />
    <button type="submit" @click="submit" class="btn btn-primary">
      {{ __("Save") }}
    </button>
  </form>
</template>

<script lang="ts">
import __ from "../lang";
import { defineComponent, PropType } from "vue";
import { AxiosResponse, AxiosError } from "axios";

export default defineComponent({
  props: {
    initial: {
      type: Object as PropType<App.Models.Player>,
      required: true,
    },
  },
  data(): { player: App.Models.Player } {
    return {
      player: { ...this.initial },
    };
  },
  methods: {
    __: __,
    submit(): void {
      window.axios
        .patch(`/players/${this.player.id}`, this.player)
        .then((response: AxiosResponse) => (this.player = response.data.data))
        .catch((error: AxiosError) => console.log(error));
    },
  },
});
</script>