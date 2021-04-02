export default interface Player {
    id: string,
    name: string,
    is_creator: boolean,
    updated_at: Date,
    created_at: Date,
    spotify_access_token?: string,

    isCreator: () => boolean

    isAuthorizedWithSpotify: () => boolean
}