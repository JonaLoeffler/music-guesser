<template>
  <div class="flex h-80">
    <div class="m-auto">
      <countdown v-if="round" :date="new Date(round.playback_at)">
        {{ __("Playback starts in") }}:
      </countdown>
      <br />

      <countdown v-if="round" :date="new Date(round.completes_at)">
        {{ __("Round ends in") }}:
      </countdown>
    </div>
  </div>
</template>

<script lang="ts">
import __ from "../lang";
import config from "../config";
import Countdown from "./Countdown.vue";
import SpotifyApi from "../lib/spotify";
import { defineComponent, PropType } from "vue";

export default defineComponent({
  name: "Spotify",
  components: {
    Countdown,
  },
  props: {
    access_token: {
      type: String,
      required: true,
    },
    round: {
      type: Object as PropType<App.Models.Round | null>,
      required: false,
    },
  },
  watch: {
    round: function (fresh: App.Models.Round | null, old: App.Models.Round | null) {
      if (fresh === null) return;

      const delay = new Date(fresh.playback_at).getTime() - Date.now();

      if (delay > 0) setTimeout(() => this.play(fresh.track!.uri), delay);
    },
  },
  methods: {
    __: __,
    play(uri: String) {
      SpotifyApi.play({
        playerInstance: window.Player,
        spotify_uri: uri,
      });
    },
  },
  mounted(): void {
    // @ts-ignore: Provided by Spotify CDN
    window.onSpotifyWebPlaybackSDKReady = () => {
      // @ts-ignore: Provided by Spotify CDN
      const player = new Spotify.Player({
        name: config.app.name,
        getOAuthToken: (cb: any) => {
          cb(this.access_token);
        },
      });

      player.addListener("player_state_changed", () => {
        setTimeout(() => window.Player.pause(), config.playback.duration);
      });

      player.addListener("ready", ({ device_id }: { device_id: string }) => {
        player._options.device_id = device_id;
      });

      player.connect();

      window.Player = player;
    };
  },
});
</script>