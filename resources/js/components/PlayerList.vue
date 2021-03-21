<template>
  <ul>
    <li v-for="player in sorted" v-bind:key="player.id">{{ player.name }}</li>
  </ul>
</template>

<script lang="ts">
import { defineComponent, PropType } from "vue";
import Room from "../classes/Room";
import Player from "../classes/Player";

export default defineComponent({
  name: "PlayerList",
  props: {
    room: {
      type: Object as PropType<Room>,
      required: true,
    },
  },
  data() {
    return {
      players: this.room.players,
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
    window.Echo.join(`room.${this.room.id}`)
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