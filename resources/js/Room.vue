<template>
  <div class="container mx-auto min-h-screen">
    <div class="grid grid-cols-2 gap-4 my-4">
      <h2>Hello World from Vue</h2>
      <player-details :initial="player" />
    </div>

    <div class="grid grid-cols-3 gap-4 h-5/6">
      <div class="bg-white rounded-md p-1">
        <h3>Players</h3>
        <player-list :room="room" />
      </div>
      <div class="bg-white rounded-md p-1"><h3>Main View</h3></div>
      <div class="bg-white rounded-md p-1"><h3>Timeline</h3></div>
    </div>
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
