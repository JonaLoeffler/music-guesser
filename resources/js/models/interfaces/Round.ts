export default interface Round {
    id: number,
    number: number,
    spotify_track_uri: string,
    spotify_track_name: string,
    play_at: Date,
    updated_at: Date,
    created_at: Date,
}