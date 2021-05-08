<template>
  <form @submit.prevent method="post">
    <ul>
      <li
        v-for="(playlist, index) in playlists"
        v-bind:key="playlist.id"
        class="py-2 px-5"
        :class="{
          'bg-green-100': index % 2 == 0,
          'bg-green-200': index % 2 == 1,
        }"
      >
        <input
          type="checkbox"
          :name="playlist.uri"
          class="pr-3"
          v-model="selected"
          :value="playlist.uri"
        />
        {{ playlist.name }}
      </li>
    </ul>
    <button
      type="submit"
      @click="submit"
      class="btn btn-primary mt-2 float-right"
    >
      Speichern
    </button>
  </form>
</template>

<script lang="ts">
import Player from "../models/Player";
import Overlay from "../components/Overlay.vue";
import { defineComponent, PropType } from "vue";
import { AxiosError, AxiosResponse } from "axios";

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
  data(): { loading: boolean; playlists: Playlist[]; selected: string[] } {
    return {
      loading: false,
      playlists: [],
      selected: [],
    };
  },
  methods: {
    submit() {
      window.axios
        .post(`/rooms/${this.room.id}/tracks`, { playlist_uris: this.selected })
        .then((response: AxiosResponse) => {})
        .catch((error: AxiosError) => console.log(error));
    },
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
