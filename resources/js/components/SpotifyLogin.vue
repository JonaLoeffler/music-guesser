<template>
  <div>
    <button @click="login">Login</button>
  </div>
</template>

<script lang="ts">
import { defineComponent } from "vue";

export default defineComponent({
  name: "SpotifyLogin",
  methods: {
    login() {
      const url =
        "https://accounts.spotify.com/authorize?" +
        new URLSearchParams({
          client_id: "dda4c90684cd45dc85329402cbefbcd8",
          response_type: "code",
          redirect_uri: `${window.location.origin}/callback/spotify`,
          state: window.location.pathname,
          scope: ["streaming", "user-read-email", "user-read-private"].join(
            " "
          ),
        });

      console.log(url);

      window.location.replace(url);
    },
  },
});
</script>