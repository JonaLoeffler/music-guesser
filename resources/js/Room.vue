<template>
  <div class="container mx-auto">
    <div class="grid grid-cols-2 gap-4 py-4">
      <h2>Hello World from Vue</h2>
      <player-details :initial="player" />
    </div>

    <div class="grid grid-cols-5 gap-4 min-h-5/6 mt-5">
      <div class="card">
        <h3>Players</h3>
        <player-list :room="room" />
      </div>
      <div class="card col-span-3">
        <h3>Main View</h3>
        <guess-form />
      </div>
      <div class="card"><h3>Timeline</h3></div>
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent, PropType } from "vue";
import Room from "./interfaces/Room";
import Player from "./interfaces/Player";
import GuessForm from "./components/GuessForm.vue";
import PlayerList from "./components/PlayerList.vue";
import PlayerDetails from "./components/PlayerDetails.vue";

export default defineComponent({
  name: "Room",
  components: {
    GuessForm,
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
