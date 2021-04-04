import Player from './Player';

export default interface Room {
    id: string,
    players: Player[],
    updated_at: string,
    created_at: string,
}