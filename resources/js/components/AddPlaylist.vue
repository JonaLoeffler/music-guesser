<template>
  <div class="flex justify-between min-w-max p-1">
    <span class="p-2 pr-5">{{ playlist.name }} </span>
    <button type="submit" @click="submit" class="btn btn-primary">
      {{ text }}
    </button>
  </div>
</template>

<script lang="ts">
import Room from "../models/Room";
import Playlist from "../models/Spotify/Playlist";
import { AxiosError, AxiosResponse } from "axios";
import { defineComponent, PropType } from "vue";

export default defineComponent({
  name: "AddPlaylist",
  props: {
    room: {
      type: Object as PropType<Room>,
      required: true,
    },
    playlist: {
      type: Object as PropType<Playlist>,
      required: true,
    },
  },
  data(): { text: string } {
    return {
      text: "Add",
    };
  },
  methods: {
    submit() {
      this.text = "...";
      window.axios
        .post(`/rooms/${this.room.id}/tracks`, {
          playlist_uri: this.playlist.uri,
        })
        .then((response: AxiosResponse) => {
          this.text = "Done.";
        })
        .catch((error: AxiosError) => {
          this.text = "Error.";
        });
    },
  },
});
</script>
