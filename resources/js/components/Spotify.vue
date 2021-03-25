<template>
  <div class="flex h-80">
    <div class="m-auto">Spotify</div>
  </div>
</template>

<script lang="ts">
import { defineComponent } from "vue";
export default defineComponent({
  name: "Spotify",
  props: {
    access_token: {
      required: true,
      type: String,
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
        console.log("Ready with Device ID", device_id);
      });

      // Not Ready
      player.addListener("not_ready", ({ device_id }: any) => {
        console.log("Device ID has gone offline", device_id);
      });

      // Connect to the player!
      player.connect();
    };
  },
});
</script>