import RoomInterface from './interfaces/Room'
import PlayerInterface from './interfaces/Player'

export default class Room implements RoomInterface {
    constructor(
        public id: string,
        public players: PlayerInterface[],
        public created_at: string,
        public updated_at: string) { }
}