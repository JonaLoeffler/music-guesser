export default interface Player {
    id: string,
    name: string,
    updated_at: Date,
    created_at: Date,
    spotify_access_token?: string,

    isAuthorizedWithSpotify: () => boolean
}