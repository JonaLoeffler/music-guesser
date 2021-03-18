import Player from './Player';

export default interface Room {
    id: number,
    players: Player[],
    updated_at: Date,
    created_at: Date,
}