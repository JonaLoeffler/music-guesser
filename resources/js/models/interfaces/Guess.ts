import Round from "./Round";
import Player from "./Player";

export default interface Guess {
    id: number,
    track: string,
    round: Round,
    player: Player,
    updated_at: string,
    created_at: string,
}