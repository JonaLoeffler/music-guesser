<template>
  <div>
    <overlay></overlay>
    <button class="btn btn-secondary" @click.prevent="Overlay.open = !Overlay.open">
      Playlists hinzufügen
    </button>
  </div>
</template>

<script lang="ts">
import Overlay from "../components/Overlay.vue";
import { defineComponent } from "vue";

export default defineComponent({
  name: "PlaylistSelection",
  components: {
    Overlay,
  },
});
</script>
