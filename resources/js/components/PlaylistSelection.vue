<template>
  <ul>
    <li v-for="playlist in playlists" v-bind:key="playlist.id">
      {{ playlist.name }}
    </li>
  </ul>
</template>

<script lang="ts">
import Player from "../models/Player";
import Overlay from "../components/Overlay.vue";
import { defineComponent, PropType } from "vue";

interface Playlist {
  id: string;
  uri: string;
  name: string;
}

export default defineComponent({
  name: "PlaylistSelection",
  components: {
    Overlay,
  },
  props: {
    player: {
      type: Object as PropType<Player>,
      required: true,
    },
  },
  data(): { loading: boolean; playlists: Playlist[] } {
    return {
      loading: false,
      playlists: [],
    };
  },
  mounted(): void {
    this.loading = true;
    fetch(`https://api.spotify.com/v1/me/playlists?limit=50`, {
      method: "GET",
      body: null,
      headers: {
        "Content-Type": "application/json",
        Authorization: `Bearer ${this.player.spotify_access_token}`,
      },
    })
      .then((response) => response.json())
      .then((body) => (this.playlists = body.items))
      .catch((error) => console.log(error));

    this.loading = false;
  },
});
</script>
