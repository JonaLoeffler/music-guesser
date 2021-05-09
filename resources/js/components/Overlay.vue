<template>
  <div>
    <button
      class="btn btn-primary"
      type="button"
      v-on:click="toggle()"
    >
      Open large modal
    </button>
    <div
      v-if="show"
      class="overflow-x-hidden overflow-y-auto fixed inset-0 z-50 outline-none focus:outline-none justify-center items-center flex"
    >
      <div class="relative w-auto my-6 mx-auto max-w-6xl">
        <div
          class="border-0 rounded-lg shadow-lg relative flex flex-col w-full bg-white outline-none focus:outline-none"
        >
          <div
            class="flex items-start justify-between p-3 border-b border-solid border-blueGray-200 rounded-t"
          >
            <h3 class="text-2xl font-semibold">
              <slot name="title" />
            </h3>
            <button
              class="p-1 ml-auto bg-transparent border-0 text-black float-right text-3xl leading-none font-semibold outline-none focus:outline-none"
              v-on:click="toggle()"
            >
              <span
                class="bg-transparent text-black h-6 w-6 text-2xl block outline-none focus:outline-none"
              >
                ×
              </span>
            </button>
          </div>

          <div class="relative p-4 flex-auto">
            <slot />
          </div>
        </div>
      </div>
    </div>
    <div v-if="show" class="opacity-25 fixed inset-0 z-40 bg-black"></div>
  </div>
</template>

<script lang="ts">
import { defineComponent } from "@vue/runtime-core";

export default defineComponent({
  name: "Overlay",
  data(): { show: boolean } {
    return {
      show: false,
    };
  },
  methods: {
    toggle: function (): void {
      this.show = !this.show;
    },
  },
});
</script>