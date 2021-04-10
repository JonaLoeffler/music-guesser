export default interface Player {
    id: string,
    name: string,
    score: number,
    is_creator: boolean,
    created_at: string,
    updated_at: string,
    spotify_access_token?: string,
}