<template>
  <div class="container mx-auto">
    <h2 class="text-lg font-bold">Hello World from Vue</h2>
    <p>You're in room {{ room.id }}</p>
  </div>
</template>

<script>
export default {
  name: "App",
  props: {
    room: {
      type: Object,
      required: true,
    },
  },
  mounted() {
    Echo.join(`room.${this.room.id}`)
      .here((users) => {
        console.table(users);
      })
      .joining((user) => {
        console.log(user);
      })
      .leaving((user) => {
        console.log(user);
      });
  },
};
</script>
