declare namespace App.Models {
    export interface Player {
        id: string;
        room_id: string;
        is_creator: boolean;
        name: string | null;
        score: number;
        spotify_access_token: string | null;
        spotify_token_type: string | null;
        spotify_expires_at: string | null;
        spotify_refresh_token: string | null;
        spotify_scope: string | null;
        created_at: string | null;
        updated_at: string | null;
        room?: App.Models.Room | null;
    }
    export interface Track {
        id: number;
        room_id: string;
        name: string;
        uri: string;
        created_at: string | null;
        updated_at: string | null;
        room?: App.Models.Room | null;
    }
    export interface Guess {
        id: number;
        round_id: number;
        player_id: string;
        track: string;
        status: 'wrong' | 'close' | 'correct';
        created_at: string | null;
        updated_at: string | null;
        round?: App.Models.Round | null;
        player?: App.Models.Player | null;
    }
    export interface Round {
        id: number;
        room_id: string;
        number: number;
        track_id: number;
        created_at: string | null;
        updated_at: string | null;
        room?: App.Models.Room | null;
        track?: App.Models.Track | null;
        guesses?: Array<App.Models.Guess> | null;
        readonly playback_at?: any;
        readonly completes_at?: any;
    }
    export interface Room {
        id: string;
        created_at: string | null;
        updated_at: string | null;
        creator?: App.Models.Player | null;
        players?: Array<App.Models.Player> | null;
        rounds?: Array<App.Models.Round> | null;
        tracks?: Array<App.Models.Track> | null;
    }
}