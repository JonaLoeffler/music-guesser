<template>
  <div class="container mx-auto">
    <h2 class="text-lg font-bold">Hello World from Vue</h2>
    <p>You're in room {{ room.id }}</p>

    <player-details :initial="player" />

    <player-list :room="room" />
  </div>
</template>

<script lang="ts">
import { defineComponent, PropType } from "vue";
import Room from "./interfaces/Room";
import Player from "./interfaces/Player";
import PlayerList from "./components/PlayerList.vue";
import PlayerDetails from "./components/PlayerDetails.vue";

export default defineComponent({
  name: "Room",
  components: {
    PlayerList,
    PlayerDetails,
  },
  props: {
    room: {
      type: Object as PropType<Room>,
      required: true,
    },
    player: {
      type: Object as PropType<Player>,
      required: true,
    },
  },
});
</script>
