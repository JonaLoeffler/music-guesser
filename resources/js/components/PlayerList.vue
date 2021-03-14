<template>
  <ul>
    <li v-for="player in sorted" v-bind:key="player.id">{{ player.name }}</li>
  </ul>
</template>

<script>
export default {
  props: {
    room: {
      type: Object,
      required: true,
    },
  },
  data() {
    return {
      players: this.room.players,
    };
  },
  computed: {
    sorted: function () {
      return this.players.sort(
        (a, b) => new Date(a.created_at) - new Date(b.created_at)
      );
    },
  },
  mounted() {
    Echo.join(`room.${this.room.id}`)
      .here((players) => {
        this.players = players;
      })
      .joining((player) => {
        this.players.push(player);
      })
      .leaving((player) => {
        this.players = this.players.filter((p) => p.id !== player.id);
      })
      .listen("PlayerUpdated", (player) => {
        this.players = this.players.filter((p) => p.id !== player.id);

        this.players.push(player);
      });
  },
};
</script>