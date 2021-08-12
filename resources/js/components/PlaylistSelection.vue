<template>
  <div
    v-for="(playlist, index) in playlists"
    :key="playlist.uri"
    :class="{
      'bg-green-100': index % 2 == 0,
      'bg-green-200': index % 2 == 1,
    }"
  >
    <add-playlist :room="room" :playlist="playlist" />
  </div>
</template>

<script lang="ts">
import Playlist from "../models/Spotify/Playlist";
import AddPlaylist from "../components/AddPlaylist.vue";
import { defineComponent, PropType } from "vue";

export default defineComponent({
  name: "PlaylistSelection",
  components: {
    AddPlaylist,
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
  data(): { playlists: Playlist[] } {
    return {
      playlists: [],
    };
  },
  methods: {},
  mounted(): void {
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
  },
});
</script>
