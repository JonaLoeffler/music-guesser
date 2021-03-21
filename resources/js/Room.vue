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
        <spotify-login v-if="!this.user.isAuthorizedWithSpotify()" />
        <spotify
          v-if="this.user.isAuthorizedWithSpotify()"
          :access_token="this.user.spotify_access_token"
        />
        <guess-form />
      </div>
      <div class="card"><h3>Timeline</h3></div>
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent, PropType } from "vue";
import Room from "./classes/Room";
import Player from "./classes/Player";

import Spotify from "./components/Spotify.vue";
import SpotifyLogin from "./components/SpotifyLogin.vue";
import GuessForm from "./components/GuessForm.vue";
import PlayerList from "./components/PlayerList.vue";
import PlayerDetails from "./components/PlayerDetails.vue";

export default defineComponent({
  name: "Room",
  components: {
    Spotify,
    SpotifyLogin,
    GuessForm,
    PlayerList,
    PlayerDetails,
  },
  data() {
    return {
      user: new Player(
        this.player.id,
        this.player.name,
        this.player.created_at,
        this.player.updated_at,
        this.player.spotify_access_token
      ),
    };
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
