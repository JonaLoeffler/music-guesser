require('./bootstrap');

import { createApp } from 'vue';

import Room from './Room.vue';

const el: any = document.querySelector('#room');
const room = JSON.parse(el.dataset.room)
const player = JSON.parse(el.dataset.player)

createApp(Room, { room, player }).mount('#room');