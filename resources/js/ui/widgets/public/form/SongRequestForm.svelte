<script>
    import axios from 'axios';
    import { debounce } from '@/utils';

    let activeAnimeDropdown = false;
    let activeMusicDropdown = false;

    let animesList = [];
    let animeThemesList = [];

    let selectedAnime;
    let selectedMusic;

    const getAnimeJikanApi = (value) => {
        if (!value) {
            animesList = [];
            return;
        }

        animesList = [];
        animeThemesList = [];
        selectedAnime = null;
        selectedMusic = null;

        axios.get(`https://api.jikan.moe/v4/anime?q=${value}`)
        .then(response => {
            const filtered  = response.data.data.filter(item => item.type === 'TV');
            animesList = filtered.map(item => ({
                title: item.title,
                mal_id: item.mal_id,
                image: item.images.jpg.image_url,
                year: item.aired.from ? new Date(item.aired.from).getFullYear() : 'N/A'
            }));
        })
        .catch(()=>{
            console.error('Jikan API: Error to fetch anime')
        })
    }

    const getAnimeThemesJikanApi = (animeId) => {
        axios.get(`https://api.jikan.moe/v4/anime/${animeId}/themes`)
        .then(response => {
            const { openings, endings } = response.data.data;
            
            const parseTheme = (themeStr, type) => {
                const match = themeStr.match(/"([^"]+)"\s*by\s*([^(\n]+)/);
                
                let music = match ? match[1] : themeStr;
                let artist = match ? match[2].trim() : 'Desconhecido';

                const cleanBrackets = /\s*\([^)]*\)/g;

                return {
                    type: type,
                    music: music.replace(cleanBrackets, '').trim(),
                    artist: artist.replace(cleanBrackets, '').trim(),
                };
            };
            
            animeThemesList = [
                ...openings.map(t => parseTheme(t, 'OP')),
                ...endings.map(t => parseTheme(t, 'ED'))
            ];
        })
        .catch(()=>{
            console.error('Jikan API: Error to fetch anime themes')
        })
    }

    const debouncedGetAnimeJikanApi = debounce(getAnimeJikanApi);
</script>

<form>
    <div class="mb-3">
        <label class="text-md text-gray-700 font-noto-sans block mb-1" for="listener">
            Como gostaria de ser chamado?
        </label>
        <input
            id="listener"
            type="text"
            name="listener"
            class="w-full h-10 bg-white font-noto-sans text-black text-md rounded-lg outline-none pl-4 border border-gray-400"
            placeholder="Ex: Ayasumi"
            required={true}
        />
        <span class="text-[0.8rem] text-gray-500 font-noto-sans mt-1 block">
            Vale apelido, nome social.. Só pra falar que o pedido é seu!
        </span>
    </div>

    <div class="mb-3">
        <label class="text-md text-gray-700 font-noto-sans block mb-1" for="address">
            Qual é a sua cidade e estado?
        </label>
        <input
            id="address"
            type="text"
            name="address"
            class="w-full h-10 bg-white font-noto-sans text-md text-black rounded-lg outline-none pl-4 border border-gray-400"
            placeholder="Ex: Salto - SP"
            required={true}
        />
        <span class="text-[0.8rem] text-gray-500 font-noto-sans mt-1 block">
            Não está no Brasil? Fala ai a cidade e país que está agora.
        </span>
    </div>
    <div class="mb-3 relative">
        <label class="text-md text-gray-700 font-noto-sans block mb-1" for="anime">
            Selecione um anime
        </label>
        <input
            id="anime"
            type="text"
            name="anime"
            class="w-full h-10 bg-white font-noto-sans text-md text-black rounded-lg outline-none pl-4 border border-gray-400"
            placeholder="Ex: Naruto"
            on:input={(e) => debouncedGetAnimeJikanApi(e.target.value)}
            on:focus={() => activeAnimeDropdown = true}
            on:blur={() => activeAnimeDropdown = false}
        />
        <span class="text-[0.8rem] text-gray-500 font-noto-sans mt-1 block">
            Selecione o anime para que possamos identificar a obra.
        </span>
        {#if activeAnimeDropdown}
            {#if animesList.length > 0}
                <div class="absolute w-full bg-white border border-gray-200 rounded-2xl shadow-xl z-25 max-h-56 overflow-y-auto p-2">
                    {#each animesList as item, i (item.id || i)}
                        <button type="button" class="cursor-pointer flex items-center gap-3 w-full p-2 rounded-xl" on:mousedown={() => { 
                            getAnimeThemesJikanApi(item.mal_id); 
                            activeAnimeDropdown = false; 
                            selectedAnime = item;
                        }}>
                            <img
                                src={item.image}
                                alt={item.title}
                                class="w-14 h-14 object-cover object-top rounded-lg border border-gray-100 shadow-sm shrink-0"
                                loading="lazy"
                            />
                            <div class="flex flex-col items-start text-left">
                                <div class="font-noto-sans font-semibold text-gray-900 text-sm line-clamp-1">
                                    {item.title}
                                </div>
                                <div class="font-noto-sans text-gray-500 text-xs">
                                    {item.year}
                                </div>
                            </div>
                        </button>
                    {/each}
                </div>
            {:else}
                <div class="absolute w-full bg-white border border-gray-200 rounded-2xl shadow-xl z-25 p-6">
                    <div class="flex flex-col items-center justify-center text-center space-y-3">
                        <div class="bg-pink-50 p-3 rounded-full">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-pink-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="11" cy="11" r="8"></circle>
                                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                                <path d="M8 11a3 3 0 0 1 3-3"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-gray-900 font-semibold font-noto-sans text-md mb-1">
                                Busque o anime!
                            </h3>
                            <p class="text-gray-500 text-sm font-noto-sans px-4">
                                Digite o nome do anime acima para que possamos achar e trazer as músicas dele para voce terminar o pedido!
                            </p>
                        </div>
                    </div>
                </div>
            {/if}
        {/if}
    </div>
    <div class="mb-5 relative">
        <div class="text-md text-gray-700 font-noto-sans block mb-1">
            Escolha uma música do anime
        </div>
        <button 
            type="button"
            class="w-full h-10 bg-white font-noto-sans text-md text-black rounded-lg outline-none pl-4 border border-gray-400"
            on:click={() => activeMusicDropdown = !activeMusicDropdown}
            on:blur={() => setTimeout(() => activeMusicDropdown = false, 200)}
        >
            {#if selectedMusic}
                <div class="flex flex-col items-start overflow-hidden">
                    <span class="text-sm text-gray-900 font-semibold truncate w-full text-left">
                        {selectedMusic.music}
                    </span>
                </div>
            {:else}
                <span class="text-gray-400 italic text-sm">
                    {selectedAnime ? 'Selecione uma música' : null}
                </span>
            {/if}
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-400 block float-end" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="6 9 12 15 18 9"></polyline>
            </svg>
        </button>
        {#if activeMusicDropdown && animeThemesList.length > 0}
            <div class="absolute w-full mt-2 bg-white border border-gray-100 rounded-2xl shadow-2xl z-30 max-h-56 overflow-y-auto">
                {#each ['OP', 'ED'] as type}
                    <div class="px-3 py-2 text-[0.6rem] font-bold text-gray-400 uppercase tracking-[0.2em]">{type === 'OP' ? 'Aberturas' : 'Encerramentos'}</div>
                    {#each animeThemesList.filter(item => item.type === type) as item}
                        <button 
                            type="button"
                            on:mousedown={() => { selectedMusic = item; activeMusicDropdown = false; }} 
                            class="w-full flex flex-col items-start gap-0.5 p-3 rounded-xl hover:bg-gray-50 active:bg-pink-50 transition-colors border-b last:border-0 border-gray-50 mb-1"
                        >
                            <div class="font-noto-sans font-bold text-gray-900 text-sm line-clamp-1 w-full text-left leading-tight">
                                {item.music}
                            </div>
                            <div class="font-noto-sans text-gray-500 text-xs truncate w-full text-left">
                                {item.artist}
                            </div>
                        </button>
                    {/each}
                {/each}
            </div>
        {/if}
    </div>
    <div class="mb-3">
        <label class="text-md text-gray-700 font-noto-sans block mb-1" for="message">
            Escreva uma mensagem
        </label>
        <textarea 
            id="message" 
            name="message"
            rows="4"
            class="w-full bg-white font-noto-sans text-md text-black rounded-lg outline-none p-4 border border-gray-400 resize-none"
            placeholder="Deixe uma mensagem amigavel"
            required={true}
        ></textarea>
        <span class="text-[0.8rem] text-gray-500 font-noto-sans mt-1 block">
            Vamos evitar ofensas! Se pedido pode não tocar por isso.
        </span>
    </div>

    <button type="submit" class="cursor-pointer w-full bg-blue-skywave px-8 py-2 rounded-md text-neutral-aurora font-noto-sans font-bold italic uppercase">
        Enviar
    </button>
</form>

 