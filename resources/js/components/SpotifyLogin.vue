<template>
  <div class="flex h-80">
    <button class="btn btn-primary m-auto" @click="login">Login</button>
  </div>
</template>

<script lang="ts">
import config from "../config";
import { defineComponent } from "vue";

export default defineComponent({
  name: "SpotifyLogin",
  methods: {
    login(): void {
      window.location.replace(this.url);
    },
  },
  computed: {
    url(): string {
      return config.spotify.authorize_url + this.params;
    },
    params(): URLSearchParams {
      return new URLSearchParams({
        client_id: config.spotify.client_id,
        response_type: "code",
        redirect_uri: `${window.location.origin}/callback/spotify`,
        state: window.location.pathname,
        scope: ["streaming", "user-read-email", "user-read-private"].join(" "),
      });
    },
  },
});
</script>