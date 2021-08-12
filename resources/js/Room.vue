<template>
  <div class="container mx-auto pt-2 h-screen">
    <div class="card flex justify-between mb-2">
      <h1 class="text-2xl my-auto mx-4">{{ title }}</h1>
      <button
        class="btn btn-primary"
        @click="start"
        v-if="player.spotify_access_token && player.is_creator && !this.round"
      >
        {{ __("Start round") }}
      </button>

      <div class="flex flex-row">
        <overlay class="mr-1">
          <template v-slot:title>{{ player.name }}</template>
          <player-details :initial="player" />
        </overlay>

        <overlay>
          <template v-slot:title>{{ __("Select Songs") }}</template>
          <playlist-selection :player="player" :room="room" />
        </overlay>
      </div>
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
import __ from "./lang";
import config from "./config";

import Info from "./components/Round.vue";
import Spotify from "./components/Spotify.vue";
import Overlay from "./components/Overlay.vue";
import Timeline from "./components/Timeline.vue";
import GuessForm from "./components/GuessForm.vue";
import PlayerList from "./components/PlayerList.vue";
import SpotifyLogin from "./components/SpotifyLogin.vue";
import PlayerDetails from "./components/PlayerDetails.vue";
import PlaylistSelection from "./components/PlaylistSelection.vue";

import { defineComponent, PropType } from "vue";
import { AxiosError, AxiosResponse } from "axios";

export default defineComponent({
  name: "Room",
  components: {
    Info,
    Spotify,
    Overlay,
    Timeline,
    GuessForm,
    PlayerList,
    SpotifyLogin,
    PlayerDetails,
    PlaylistSelection,
  },
  data(): { title: string; round: App.Models.Round | null } {
    return {
      title: config.app.name,
      round: null,
    };
  },
  props: {
    room: {
      type: Object as PropType<App.Models.Room>,
      required: true,
    },
    player: {
      type: Object as PropType<App.Models.Player>,
      required: true,
    },
  },
  methods: {
    __: __,
    start(): void {
      window.axios
        .post(`/rooms/${this.room.id}/rounds`)
        .then((response: AxiosResponse) => (this.round = response.data.data))
        .catch((error: AxiosError) => console.log(error));
    },
    finish(): void {
      if (this.round) {
        window.axios
          .put(`/rooms/${this.room.id}/rounds/${this.round.id}`)
          .then((_: AxiosResponse) => (this.round = null))
          .catch((error: AxiosError) => console.log(error));
      }
    },
  },
  mounted(): void {
    window.Echo.join(this.channel).listen("RoundStarted", (round: App.Models.Round) => {
      this.round = round;

      setTimeout(
        this.finish,
        new Date(round.completes_at).getTime() - Date.now()
      );
    });
  },
  computed: {
    channel(): string {
      return `room.${this.room.id}`;
    },
  },
});
</script>
