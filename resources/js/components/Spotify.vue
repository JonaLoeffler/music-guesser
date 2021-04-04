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
import { defineComponent } from "vue";

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
    channel: {
      type: String,
      required: true,
    },
  },
  data(): { round: Round | null } {
    return {
      round: null,
    };
  },
  methods: {
    play(uri: string) {
      if (this.round) {
        SpotifyApi.play({
          playerInstance: window.Player,
          spotify_uri: uri,
        });
      }
    },
  },
  mounted() {
    console.log(config.app.name);
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

    window.Echo.join(this.channel).listen("RoundStarted", (round: Round) => {
      this.round = round;

      setTimeout(
        () => this.play(round.spotify_track_uri),
        new Date(round.playback_at).getTime() - Date.now()
      );

      setTimeout(
        () => (this.round = null),
        new Date(round.completes_at).getTime() - Date.now()
      );
    });
  },
});
</script>