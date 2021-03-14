<template>
  <form @submit.prevent method="post">
    <input
      type="text"
      name="player.name"
      id="input-player-name"
      v-model="player.name"
    />
    <button type="submit" @click="submit" class="btn btn-primary">
      Speichern
    </button>
  </form>
</template>

<script>
export default {
  props: {
    initial: {
      type: Object,
      required: true,
    },
  },
  data() {
    return {
      player: { ...this.initial },
    };
  },
  methods: {
    submit() {
      axios
        .patch(`/players/${this.player.id}`, this.player)
        .then((response) => this.player = response.data.data)
        .catch((error) => console.log(error));
    },
  },
};
</script>