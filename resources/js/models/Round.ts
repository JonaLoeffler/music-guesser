import Track from './Track'

export default interface Round {
    id: number,
    number: number,
    track: Track,
    playback_at: string,
    completes_at: string,
    updated_at: string,
    created_at: string,
}