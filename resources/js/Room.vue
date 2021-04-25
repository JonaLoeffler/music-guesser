<template>
  <div class="container mx-auto pt-2 h-screen">
    <div class="card flex justify-between mb-2">
      <h1 class="text-2xl mx-2">{{ title }}</h1>
      <button
        class="btn btn-primary"
        @click="start"
        v-if="player.spotify_access_token && player.is_creator && !this.round"
      >
        Start round
      </button>
      <player-details :initial="player" />
    </div>

    <div class="grid grid-cols-12 gap-2 h-50">
      <div class="card col-span-3 px-0">
        <info :channel="channel" />
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
          :round="round"
          :access_token="player.spotify_access_token"
        />

        <guess-form :channel="channel" />
      </div>

      <div class="card col-span-3 overflow-auto">
        <timeline :channel="channel" :player="player" />
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import config from "./config";
import Room from "./models/Room";
import Player from "./models/Player";

import Info from "./components/Round.vue";
import Spotify from "./components/Spotify.vue";
import Timeline from "./components/Timeline.vue";
import GuessForm from "./components/GuessForm.vue";
import PlayerList from "./components/PlayerList.vue";
import SpotifyLogin from "./components/SpotifyLogin.vue";
import PlayerDetails from "./components/PlayerDetails.vue";

import { defineComponent, PropType } from "vue";
import { AxiosError, AxiosResponse } from "axios";
import Round from "./models/Round";

export default defineComponent({
  name: "Room",
  components: {
    Info,
    Spotify,
    Timeline,
    GuessForm,
    PlayerList,
    SpotifyLogin,
    PlayerDetails,
  },
  data(): { title: string; round: Round | null } {
    return {
      title: config.app.name,
      round: null,
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
        .then((response: AxiosResponse) => (this.round = response.data.data))
        .catch((error: AxiosError) => console.log(error));
    },
    finish() {
      if (this.round) {
        window.axios
          .put(`/rooms/${this.room.id}/rounds/${this.round.id}`)
          .then((_: AxiosResponse) => (this.round = null))
          .catch((error: AxiosError) => console.log(error));
      }
    },
  },
  mounted() {
    window.Echo.join(this.channel).listen("RoundStarted", (round: Round) => {
      this.round = round;

      setTimeout(
        this.finish,
        new Date(round.completes_at).getTime() - Date.now()
      );
    });
  },
  computed: {
    channel: function (): string {
      return `room.${this.room.id}`;
    },
  },
});
</script>
