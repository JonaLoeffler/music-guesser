export default class Player {
    constructor(
        public id: string,
        public name: string,
        public is_creator: boolean,
        public created_at: string,
        public updated_at: string,
        public spotify_access_token?: string,
    ) { }

    isAuthorizedWithSpotify() {
        return !!this.spotify_access_token;
    }

    isCreator() {
        return this.is_creator;
    }
}