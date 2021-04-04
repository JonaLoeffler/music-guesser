import RoundInterface from './interfaces/Round'

export default class Round implements RoundInterface {
    constructor(
        public id: number,
        public number: number,
        public spotify_track_uri: string,
        public spotify_track_name: string,
        public playback_at: string,
        public completes_at: string,
        public created_at: string,
        public updated_at: string) { }
}