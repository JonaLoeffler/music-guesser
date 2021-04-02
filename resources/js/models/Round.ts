import RoundInterface from './interfaces/Round'

export default class Round implements RoundInterface {
    constructor(
        public id: number,
        public number: number,
        public spotify_track_uri: string,
        public play_at: Date,
        public created_at: Date,
        public updated_at: Date) { }
}