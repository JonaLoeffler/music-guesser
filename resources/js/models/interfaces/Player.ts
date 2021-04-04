export default interface Player {
    id: string,
    name: string,
    is_creator: boolean,
    updated_at: string,
    created_at: string,
    spotify_access_token?: string,

    isCreator: () => boolean

    isAuthorizedWithSpotify: () => boolean
}