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
        audio = new Audio(import.meta.env.CAST_URL);
        audio.volume = get(player).volume;
    }

    return audio;
}

const updateMetadata = async () => {
    try {
        const { data } = await axios.get(import.meta.env.CAST_METADATA, {
            headers: {
                'x-requested-with': undefined
            }
        });
        
        if ('mediaSession' in navigator) {
            navigator.mediaSession.metadata = new MediaMetadata({
                title: data.musica_atual,
                artist: data.title,
                artwork: [
                    { src: data.capa_musica, sizes: '192x192', type: 'image/png' },
                    { src: data.capa_musica, sizes: '512x512', type: 'image/png' }
                ]
            });
        }
    } catch (e) {
        console.error("Erro ao buscar metadados", e);
    }
}

const setupMediaSession = () => {
    if (!('mediaSession' in navigator)) return;

    navigator.mediaSession.setActionHandler('play', () => toggleAudio());
    navigator.mediaSession.setActionHandler('pause', () => toggleAudio());

    if (!metadataInterval) {
        updateMetadata();
        metadataInterval = setInterval(updateMetadata, 10000);
    }
}

export const toggleAudio = () => {
    let audio = getAudio();
    let isPlaying = get(player).playing;

    if (isPlaying) {
        audio.pause();
        if ('mediaSession' in navigator) {
            navigator.mediaSession.playbackState = "paused";
        }
        player.update(s => ({ ...s, playing: false }));
    } else {
        audio.play();
        if ('mediaSession' in navigator) {
            navigator.mediaSession.playbackState = "playing";
            setupMediaSession();
        }
        player.update(s => ({ ...s, playing: true }));
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