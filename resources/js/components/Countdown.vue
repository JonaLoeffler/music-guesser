<template>
  <span><slot></slot> {{ countdown }} </span>
</template>

<script lang="ts">
import { defineComponent } from "vue";

export default defineComponent({
  name: "CountDown",
  emits: ["done"],
  props: {
    date: {
      type: Date,
      required: true,
    },
  },
  data(): { now: Date } {
    return {
      now: new Date(),
    };
  },
  computed: {
    remaining(): number {
      return Math.floor((this.date.getTime() - this.now.getTime()) / 1000);
    },
    countdown(): number {
      return Math.max(this.remaining, 0);
    },
  },
  watch: {
    remaining(fresh: number, old: number): void {
      if (fresh < 0 && old === 0) {
        this.$emit("done");
      }
    },
  },
  mounted(): void {
    window.setInterval(() => {
      this.now = new Date();
    }, 1000);
  },
});
</script>
