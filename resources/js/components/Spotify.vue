<template>
  <div class="flex h-80">
    <div class="m-auto">
      <countdown v-if="round" :date="new Date(round.playback_at)">
        Playback starts in:
      </countdown>
      <br />

      <countdown v-if="round" :date="new Date(round.completes_at)">
        Round ends in:
      </countdown>
    </div>
  </div>
</template>

<script lang="ts">
import config from "../config";
import Round from "../models/Round";
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
      type: Object as PropType<Round | null>,
      required: false,
    },
  },
  watch: {
    round: function (fresh: Round | null, old: Round | null) {
      if (old === null && fresh !== null) {
        setTimeout(
          this.play,
          new Date(fresh.playback_at).getTime() - Date.now()
        );
      }
    },
  },
  methods: {
    play() {
      if (this.round) {
        SpotifyApi.play({
          playerInstance: window.Player,
          spotify_uri: this.round.spotify_track_uri,
        });
      }
    },
  },
  mounted() {
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