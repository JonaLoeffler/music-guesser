<template>
  <ul>
    <li v-for="player in sorted" v-bind:key="player.id">{{ player.name }}</li>
  </ul>
</template>

<script lang="ts">
import Player from "../models/Player";
import { defineComponent, PropType } from "vue";

export default defineComponent({
  name: "PlayerList",
  props: {
    initial: {
      type: Object as PropType<Player[]>,
      required: true,
    },
    channel: {
      type: String,
      required: true,
    },
  },
  data(): { players: Player[] } {
    return {
      players: this.initial,
    };
  },
  computed: {
    sorted: function (): Player[] {
      return this.players.sort(
        (a: Player, b: Player) =>
          new Date(a.created_at).getTime() - new Date(b.created_at).getTime()
      );
    },
  },
  mounted() {
    window.Echo.join(this.channel)
      .here((players: Player[]) => {
        this.players = players;
      })
      .joining((player: Player) => {
        this.players.push(player);
      })
      .leaving((player: Player) => {
        this.players = this.players.filter((p) => p.id !== player.id);
      })
      .listen("PlayerUpdated", (player: Player) => {
        this.players = this.players.filter((p) => p.id !== player.id);

        this.players.push(player);
      });
  },
});
</script>