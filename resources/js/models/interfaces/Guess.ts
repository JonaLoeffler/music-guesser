import Round from "./Round";
import Player from "./Player";

export default interface Guess {
    id: number,
    track: string,
    status: 'correct' | 'close' | 'wrong',
    round: Round,
    player: Player,
    updated_at: string,
    created_at: string,
}