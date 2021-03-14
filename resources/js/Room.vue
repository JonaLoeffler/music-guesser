<template>
  <div class="container mx-auto">
    <h2 class="text-lg font-bold">Hello World from Vue</h2>
    <p>You're in room {{ room.id }}</p>

    <player-details :initial="player" />

    <player-list :room="room" />
  </div>
</template>

<script>
import PlayerList from "./components/PlayerList.vue";
import PlayerDetails from "./components/PlayerDetails.vue";

export default {
  name: "App",
  components: {
    PlayerList,
    PlayerDetails,
  },
  props: {
    room: {
      type: Object,
      required: true,
    },
    player: {
      type: Object,
      required: true,
    },
  },
};
</script>
