<script>
    import { page, usePoll } from "@inertiajs/svelte";
    import { Modal } from "@/ui/components/public";
    import { SongRequestForm } from "@/ui/widgets/public/form";
    import { player, toggleAudio, setVolume } from "@/store"
    
    $: ({ onair } = $page.props);

    usePoll(30*6000);
    $: air = onair.data[0];

    let modalRef;
</script>

<Modal bind:this={modalRef}>
    <div slot="content">
        <SongRequestForm/>
    </div>
</Modal>

<section class="flex flex-col w-full bg-blue-midnight p-6 gap-8 rounded-3xl overflow-hidden relative">
    <!-- Info Card (Glassmorphism) -->
    <div class="relative z-10 bg-neutral-aurora/5 backdrop-blur-xl border border-white/10 rounded-3xl p-5 flex flex-col gap-4 shadow-xl">
        <div class="flex items-center gap-4">
            <div class="w-16 h-16 rounded-xl overflow-hidden border border-white/20 shrink-0">
                <img
                    src={air.program.host.avatar}
                    alt="Programa"
                    class="w-full h-full object-cover object-top scale-165"
                />
            </div>
            <div class="flex flex-col min-w-0">
                <span class="text-orange-amber text-[10px] uppercase font-bold tracking-widest leading-none mb-1">
                    PROGRAMA
                </span>
                <h3 class="text-neutral-aurora text-lg font-bold leading-tight uppercase italic truncate">
                    {air.program.name}
                </h3>
                <div class="flex flex-wrap items-center gap-2 mt-1">
                    <span class={["text-[9px] px-2 py-0.5 rounded-full text-white font-bold uppercase italic", 
                        {'bg-purple-mystic': air.type === "automatic"},
                        {'bg-green-forest': air.type === "live"},
                        {'bg-green-forest': air.type === "scheduled"},
                    ]}>
                        {#if air.type === "automatic"} 
                            Robô
                        {:else if air.type === "live"} 
                            Humano
                        {:else} 
                            Agendado
                        {/if}
                    </span>
                    <span class="text-neutral-aurora/60 text-xs font-medium italic">
                        com {air.program.host.nickname}
                    </span>
                </div>
            </div>
        </div>

        <div class="w-full h-px bg-neutral-aurora/10"></div>

        <div class="flex flex-col gap-1">
            <span class="text-orange-amber text-[10px] uppercase font-bold tracking-widest">TOCANDO AGORA</span>
            <p class="text-neutral-aurora text-base font-bold italic line-clamp-2 leading-tight">
                {air.current_song.music}
            </p>
        </div>
    </div>

    <!-- Controls -->
    <div class="relative z-10 flex flex-col gap-6 mt-2">
        <div class="flex items-center justify-center gap-8">
            <!-- Play Button -->
            <button on:click={toggleAudio} class="w-20 h-20 rounded-full bg-blue-skywave flex items-center justify-center shadow-[0_0_30px_rgba(0,145,255,0.4)] hover:bg-blue-skywave/90 active:scale-95 transition-all group">
                <div class="bg-neutral-aurora rounded-full p-4 flex items-center justify-center group-hover:scale-105 transition-transform">
                    <img
                        src={$player.playing ? "/svg/default/pause.svg" : "/svg/default/play.svg"}
                        alt={$player.playing ? "Pause" : "Play"}
                        class="w-8 filter-blue-skywave"
                    />
                </div>
            </button>
        </div>

        <!-- Volume Slider -->
        <div class="px-4 flex flex-col gap-2">
            <div class="flex justify-between items-center px-1">
                <span class="text-[10px] text-neutral-aurora/40 font-bold uppercase">Volume</span>
                <span class="text-[10px] text-orange-amber font-bold">{Math.round($player.volume * 100)}%</span>
            </div>
            <input
                type="range"
                min="0"
                max="1"
                step="0.01"
                value={$player.volume}
                on:input={(e) => setVolume(e.target.value)}
                class="w-full accent-orange-amber h-1.5 rounded-full bg-neutral-aurora/10 cursor-pointer transition-all hover:bg-neutral-aurora/20"
            />
        </div>

        <!-- Request Button -->
        <button on:click={() => modalRef.open()} class="cursor-pointer w-full py-2 px-1 border border-neutral-aurora rounded-full text-blue-skywave text-xl text-center font-noto-sans font-bold italic uppercase">
            & Faça seu <strong class="text-orange-amber">Pedido</strong>
        </button>
    </div>
</section>
