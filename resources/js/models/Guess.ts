import Round from './Round';
import Player from './Player';
import GuessInterface from './interfaces/Guess'

export default class Guess implements GuessInterface {
    constructor(
        public id: number,
        public track: string,
        public round: Round,
        public player: Player,
        public created_at: string,
        public updated_at: string) { }
}