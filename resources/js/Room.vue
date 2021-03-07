<template>
  <div class="container mx-auto">
    <h2 class="text-lg font-bold">Hello World from Vue</h2>
    <p>You're in room {{ room.id }}</p>
  </div>
</template>

<script>
module.exports = {
  name: "App",
  props: {
    room: {
      type: Object,
      required: true,
    },
  },
};
</script>
