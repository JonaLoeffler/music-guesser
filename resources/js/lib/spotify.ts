const play = ({
    spotify_uri,
    playerInstance: {
        _options: {
            getOAuthToken,
            device_id
        }
    }
}: any) => {
    console.log(spotify_uri)
    getOAuthToken((access_token: string) => {
        console.log(device_id)
        fetch(`https://api.spotify.com/v1/me/player/play?device_id=${device_id}`, {
            method: 'PUT',
            body: JSON.stringify({ uris: [spotify_uri] }),
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${access_token}`
            },
        });
    });
};

export default { play }