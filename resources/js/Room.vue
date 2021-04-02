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
        <spotify-login v-if="!user.isAuthorizedWithSpotify()" />
        <spotify
          v-if="user.isAuthorizedWithSpotify()"
          :access_token="user.spotify_access_token"
          :room="room"
        />
        <guess-form />
      </div>
      <div class="card">
        <h3>Timeline</h3>
        <button
          class="btn btn-primary"
          @click="start"
          v-if="user.isAuthorizedWithSpotify() && user.isCreator()"
        >
          Start round
        </button>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent, PropType } from "vue";
import Room from "./models/Room";
import Player from "./models/Player";

import Spotify from "./components/Spotify.vue";
import SpotifyLogin from "./components/SpotifyLogin.vue";
import GuessForm from "./components/GuessForm.vue";
import PlayerList from "./components/PlayerList.vue";
import PlayerDetails from "./components/PlayerDetails.vue";
import { AxiosError, AxiosResponse } from "axios";

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
        this.player.is_creator,
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
  methods: {
    start() {
      window.axios
        .post(`/rooms/${this.room.id}/rounds`)
        .then((response: AxiosResponse) => console.log(response))
        .catch((error: AxiosError) => console.log(error));
    },
  },
});
</script>
