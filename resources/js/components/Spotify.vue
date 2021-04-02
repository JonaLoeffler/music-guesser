<template>
  <div class="flex h-80">
    <div class="m-auto">
      Spotify
      <button @click="play">Play</button>
    </div>
  </div>
</template>

<script lang="ts">
import SpotifyApi from "../lib/spotify";
import { defineComponent, PropType } from "vue";
import Room from "../models/Room";
import Round from "../models/Round";

export default defineComponent({
  name: "Spotify",
  props: {
    access_token: {
      required: true,
      type: String,
    },
    room: {
      required: true,
      type: Object as PropType<Room>,
    },
  },
  methods: {
    play(uri: string) {
      SpotifyApi.play({
        playerInstance: window.Player,
        spotify_uri: uri,
      });
      setTimeout(() => window.Player.pause(), 4000);
    },
  },
  mounted() {
    // @ts-ignore: Provided by Spotify CDN
    window.onSpotifyWebPlaybackSDKReady = () => {
      // @ts-ignore: Provided by Spotify CDN
      const player = new Spotify.Player({
        name: "Which-Song.game",
        getOAuthToken: (cb: any) => {
          cb(this.access_token);
        },
      });

      // Error handling
      player.addListener("initialization_error", ({ message }: any) => {
        console.error(message);
      });
      player.addListener("authentication_error", ({ message }: any) => {
        console.error(message);
      });
      player.addListener("account_error", ({ message }: any) => {
        console.error(message);
      });
      player.addListener("playback_error", ({ message }: any) => {
        console.error(message);
      });

      // Playback status updates
      player.addListener("player_state_changed", (state: any) => {
        console.log(state);
      });

      // Ready
      player.addListener("ready", ({ device_id }: any) => {
        player._options.device_id = device_id;
        console.log("Ready with Device ID", device_id);
      });

      // Not Ready
      player.addListener("not_ready", ({ device_id }: any) => {
        console.log("Device ID has gone offline", device_id);
      });

      // Connect to the player!
      player.connect();

      window.Player = player;
    };

    window.Echo.join(`room.${this.room.id}`).listen(
      "PlayTrack",
      (round: Round) => {
        setTimeout(
          () => this.play(round.spotify_track_uri),
          new Date(round.play_at).getTime() - Date.now()
        );
      }
    );
  },
});
</script>