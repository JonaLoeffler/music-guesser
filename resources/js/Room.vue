<template>
  <div class="container mx-auto">
    <div class="grid grid-cols-3 gap-4 py-4">
      <h2>Hello World from Vue</h2>
      <button
        class="btn btn-primary"
        @click="start"
        v-if="user.isAuthorizedWithSpotify() && user.isCreator()"
      >
        Start round
      </button>
      <player-details :initial="player" />
    </div>

    <div class="grid grid-cols-5 gap-4 min-h-5/6 mt-5">
      <div class="card">
        <h3>Players</h3>
        <player-list :channel="channel" :initial="room.players" />
      </div>
      <div class="card col-span-3">
        <h3>Main View</h3>
        <spotify-login v-if="!user.isAuthorizedWithSpotify()" />
        <spotify
          v-if="user.isAuthorizedWithSpotify()"
          :access_token="user.spotify_access_token"
          :channel="channel"
        />
        <guess-form :channel="channel" />
      </div>
      <div class="card">
        <h3>Timeline</h3>
        <timeline :channel="channel" />
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import Room from "./models/Room";
import Player from "./models/Player";

import Spotify from "./components/Spotify.vue";
import Timeline from "./components/Timeline.vue";
import GuessForm from "./components/GuessForm.vue";
import PlayerList from "./components/PlayerList.vue";
import SpotifyLogin from "./components/SpotifyLogin.vue";
import PlayerDetails from "./components/PlayerDetails.vue";

import { defineComponent, PropType } from "vue";
import { AxiosError, AxiosResponse } from "axios";

export default defineComponent({
  name: "Room",
  components: {
    Spotify,
    Timeline,
    GuessForm,
    PlayerList,
    SpotifyLogin,
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
        .then((response: AxiosResponse) => {})
        .catch((error: AxiosError) => console.log(error));
    },
  },
  computed: {
    channel: function (): string {
      return `room.${this.room.id}`;
    },
  },
});
</script>
