<template>
  <div class="container mx-auto">
    <div class="flex justify-between py-4">
      <h1 class="text-2xl mx-2">{{ title }}</h1>
      <button
        class="btn btn-primary px-5"
        @click="start"
        v-if="player.spotify_access_token && player.is_creator"
      >
        Start round
      </button>
      <player-details :initial="player" />
    </div>

    <div class="grid grid-cols-12 gap-2 min-h-5/6 mt-5">
      <div class="card col-span-3">
        <round :channel="channel" />
        <player-list
          :channel="channel"
          :initial="room.players"
          :user="player"
        />
      </div>

      <div class="card col-span-6 flex flex-col justify-between">
        <spotify-login v-if="!player.spotify_access_token" />
        <spotify
          v-else
          :access_token="player.spotify_access_token"
          :channel="channel"
        />

        <guess-form :channel="channel" />
      </div>

      <div class="card col-span-3">
        <timeline :channel="channel" :player="player" />
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import config from "./config";
import Room from "./models/Room";
import Player from "./models/Player";

import Round from "./components/Round.vue";
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
    Round,
    Spotify,
    Timeline,
    GuessForm,
    PlayerList,
    SpotifyLogin,
    PlayerDetails,
  },
  data(): { title: string } {
    return {
      title: config.app.name,
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
