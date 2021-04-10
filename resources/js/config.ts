interface Config {
    app: { name: string },
    playback: { duration: number }
    spotify: {
        client_id: string,
        authorize_url: string,
    }
};

const config: Config = {
    app: {
        name: process.env.MIX_APP_NAME ?? "Which-Track.game",
    },
    playback: {
        duration: 4000,
    },
    spotify: {
        client_id: "dda4c90684cd45dc85329402cbefbcd8",
        authorize_url: "https://accounts.spotify.com/authorize?",
    }
}

export default config;