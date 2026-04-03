import { writable, get } from "svelte/store";

export const player = writable({
    playing: false,
    volume: 0.05,
});

let audio;
const getAudio = () => {
    if (!audio) {
        audio = new Audio(import.meta.env.CAST_URL);
        audio.volume = get(player).volume;
    }

    return audio;
}

export const toggleAudio = () => {
    let audio = getAudio();

    let playing = get(player).playing;

    if (playing) {
        audio.pause();
        player.update((state) => ({
            ...state,
            playing: false
        }));
    } else {
        audio.play();
        player.update((state) => ({
            ...state,
            playing: true
        }));
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