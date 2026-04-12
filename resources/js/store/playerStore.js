import { writable, get } from "svelte/store";
import axios from "axios";

export const player = writable({
    playing: false,
    volume: 0.05,
});

let audio;
let metadataInterval;

const getAudio = () => {
    if (!audio) {
        audio = new Audio("/api/cast");
        audio.volume = get(player).volume;

        audio.addEventListener('playing', () => {
            player.update(s => ({ ...s, playing: true }));
            if ('mediaSession' in navigator) {
                navigator.mediaSession.playbackState = "playing";
            }
        });

        audio.addEventListener('pause', () => {
            player.update(s => ({ ...s, playing: false }));
            if ('mediaSession' in navigator) {
                navigator.mediaSession.playbackState = "paused";
            }
        });
    }

    return audio;
}

const updateMetadata = async () => {
    try {
        const { data: response } = await axios.get('/api/cast/metadata');

        const info = response.data[0];

        if (info && 'mediaSession' in navigator) {
            navigator.mediaSession.metadata = new MediaMetadata({
                title: info.current_song.music,
                artist: info.program.name + " - " + info.program.host.name,
                album: "Rede Akiba - O Paraíso dos Otakus",
                artwork: [
                    { src: info.current_song.cover, sizes: '192x192', type: 'image/png' },
                    { src: info.current_song.cover, sizes: '512x512', type: 'image/png' }
                ]
            });
        }
    } catch (e) {
        console.error("Erro ao buscar metadados do streaming para o media session");
    }
}

const setupMediaSession = () => {
    if (!('mediaSession' in navigator)) return;

    navigator.mediaSession.setActionHandler('play', () => toggleAudio());
    navigator.mediaSession.setActionHandler('pause', () => toggleAudio());

    if (!metadataInterval) {
        updateMetadata();
        metadataInterval = setInterval(updateMetadata, 30 * 1000);
    }
}

export const toggleAudio = () => {
    let audio = getAudio();
    let isPlaying = !audio.paused;

    if (isPlaying) {
        audio.pause();
    } else {
        audio.play();

        if ('mediaSession' in navigator) {
            setupMediaSession();
        }
    }
}

export const setVolume = (volume) => {
    let audio = getAudio();
    audio.volume = volume;

    player.update((state) => ({
        ...state,
        volume: volume
    }));
}

const mediaSession = () => {
    if ('mediaSession' in navigator) {
        setInterval(async () => {
            const { data } = await axios.get(import.meta.env.CAST_METADATA);

            navigator.mediaSession.metadata = new MediaMetadata({
                title: data.musica_atual,
                artist: data.title,
            artwork: [
                {
                    src: data.capa_musica,
                    sizes: '192x192',
                    type: 'image/png'
                }
            ]
        });
        }, 5000);

        navigator.mediaSession.setActionHandler('play', () => {
            toggleAudio();
        });

        navigator.mediaSession.setActionHandler('pause', () => {
            toggleAudio();
        });
    }
}