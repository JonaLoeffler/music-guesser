import PlayerInterface from './interfaces/Player'

export default class Player implements PlayerInterface {
    constructor(
        public id: string,
        public name: string,
        public created_at: Date,
        public updated_at: Date,
        public spotify_access_token?: string,
    ) { }

    isAuthorizedWithSpotify() {
        return !!this.spotify_access_token;
    }
}