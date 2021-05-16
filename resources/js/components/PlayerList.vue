<template>
  <ul>
    <li
      v-for="(player, index) in sorted"
      v-bind:key="player.id"
      class="flex p-2"
      :class="{ 'bg-green-200': index % 2 == 0 }"
    >
      <div class="font-bold text-2xl px-2 flex items-center">
        #{{ index + 1 }}
      </div>
      <div class="ml-3">
        <div>
          <span class="font-bold text-lg">{{ player.name }}</span>
          <span v-if="player.id === user.id"> ({{ __("You") }})</span>
        </div>
        {{ Math.round(player.score) }} {{ __("points") }}
      </div>
    </li>
  </ul>
</template>

<script lang="ts">
import __ from "../lang";
import Player from "../models/Player";
import { defineComponent, PropType } from "vue";

export default defineComponent({
  name: "PlayerList",
  props: {
    user: {
      type: Object as PropType<Player[]>,
      required: true,
    },
    initial: {
      type: Object as PropType<Player[]>,
      required: true,
    },
    channel: {
      type: String,
      required: true,
    },
  },
  data(): { players: Player[] } {
    return {
      players: this.initial,
    };
  },
  computed: {
    sorted(): Player[] {
      return this.players.slice().sort((a: Player, b: Player) => {
        if (a.score > 0 && b.score > 0) {
          return b.score - a.score;
        }

        return (
          new Date(a.created_at).getTime() - new Date(b.created_at).getTime()
        );
      });
    },
  },
  mounted(): void {
    window.Echo.join(this.channel)
      .here((players: Player[]) => {
        this.players = players;
      })
      .joining((player: Player) => {
        this.players.push(player);
      })
      .leaving((player: Player) => {
        this.players = this.players.filter((p) => p.id !== player.id);
      })
      .listen("PlayerUpdated", (player: Player) => {
        this.players = this.players.filter((p) => p.id !== player.id);

        this.players.push(player);
      });
  },
  methods: {
    __: __,
  },
});
</script>