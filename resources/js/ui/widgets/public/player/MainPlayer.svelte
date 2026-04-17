<script>
    import { page, usePoll } from "@inertiajs/svelte";
    import { Modal } from "@/ui/components/public";
    import { SongRequestForm } from "@/ui/widgets/public";
    import { player, toggleAudio, setVolume } from "@/store";

    $: ({ onair } = $page.props);

    $: air = onair.data[0];

    let modalRef;

    usePoll(60 * 1000);
</script>

<Modal bind:this={modalRef}>
    <div slot="content">
        <SongRequestForm />
    </div>
</Modal>
<section class="w-full bg-blue-ocean mb-5">
    <div class="cont-player-main py-4 relative">
        <div class="hidden lg:block absolute -top-7 -left-10 z-10">
            <img
                src="/img/player/rains.webp"
                alt=""
                aria-hidden="true"
                class="w-20 transform -scale-x-100 -scale-y-100"
                loading="lazy"
            />
        </div>
        <!-- svelte-ignore a11y_distracting_elements -->
        <marquee class="w-5xl flex overflow-x-hidden relative marquee-container">
            <div class="whitespace-nowrap w-full md:w-auto text-neutral-aurora text-3xl font-noto-sans font-bold uppercase italic">
                <span class="mx-4">
                    {air.phrase}
                </span>
            </div>
        </marquee>
        <div class="hidden lg:block absolute bottom-0 -right-4 z-10">
            <img
                src={air.icon}
                alt=""
                aria-hidden="true"
                class="w-32"
                loading="lazy"
            />
        </div>
        <div class="hidden lg:block absolute -top-8 -right-10 z-10">
            <img
                src="/img/player/rains.webp"
                alt=""
                aria-hidden="true"
                class="w-20"
                loading="lazy"
            />
        </div>
    </div>
</section>

<section class="cont-player-main grid grid-cols-[2fr_1fr_0.84fr] items-center gap-5">
    <div class="block">
        <div class="flex items-center gap-5 mb-15">
            <div class="w-52">
                <img src={air.program.image} alt="Programa" loading="lazy" />
            </div>
            <div class="text-gray-500">
                <img
                    src="/svg/arrowRightTwo.svg"
                    alt=""
                    aria-hidden="true"
                    class="w-8 filter-neutral-gray"
                    loading="lazy"
                />
            </div>
            <div>
                <div class="text-orange-amber font-noto-sans uppercase">
                    {air.program.host.gender === "male" ? "Com o DJ" : "Com a DJ"}
                </div>
                <div class="w-full text-neutral-aurora text-2xl font-noto-sans font-bold uppercase italic line-clamp-1">
                    {air.program.host.nickname}
                </div>
                <div class={["mt-[0.4rem] w-24 rounded-xl text-center text-sm text-neutral-aurora font-noto-sans font-bold italic uppercase",
                    { "bg-purple-mystic": air.type === "automatic" },
                    { "bg-green-forest": air.type === "live" },
                    { "bg-orange-sunset": air.type === "scheduled" },
                ]}>
                    {#if air.type === "automatic"}
                        Robô
                    {:else if air.type === "live"}
                        Humano
                    {:else}
                        Gravado
                    {/if}
                </div>
            </div>
            <div class="text-gray-500">
                <img
                    src="/svg/arrowRightTwo.svg"
                    alt=""
                    aria-hidden="true"
                    class="w-8 filter-neutral-gray"
                    loading="lazy"
                />
            </div>
        </div>
        <div class="flex gap-3 items-end">
            <div class="w-20 shrink-0">
                <img
                    src={air.current_song.cover || "https://cdn.vectorstock.com/i/500p/57/71/music-note-icon-set-vector-2855771.jpg"}
                    alt=""
                    aria-hidden="true"
                    class="rounded-lg"
                    loading="lazy"
                />
            </div>
            <div class="w-full srink-0">
                <div class="text-orange-amber font-noto-sans uppercase italic">
                    Tocando agora:
                </div>
                <!-- svelte-ignore a11y_distracting_elements -->
                <marquee class="w-full text-neutral-aurora text-xl font-noto-sans font-bold uppercase italic line-clamp-1">
                    {decodeURIComponent(escape(air.current_song.music || "Estamos offline"))}
                </marquee>
            </div>
        </div>
    </div>
    <div class="block">
        <div class="w-76">
            <img
                src={air.program.host.avatar}
                alt=""
                aria-label="hidden"
                class="w-full h-full"
                loading="lazy"
            />
        </div>
    </div>
    <div class="block pt-10">
        <div class="flex flex-col gap-10 px-3">
            <div class={["py-3 px-6 flex gap-2  justify-center items-center rounded-md",
                { "bg-purple-mystic": air.type === "automatic" },
                { "bg-green-forest": air.type === "live" },
                { "bg-orange-sunset": air.type === "scheduled" },
            ]}>
                <div>
                    {#if air.type === "automatic"}
                        <img
                            src="/svg/robot.svg"
                            alt=""
                            aria-hidden="true"
                            class="w-20"
                            loading="lazy"
                        />
                    {:else if air.type === "live"}
                        <img
                            src="/svg/stream.svg"
                            alt=""
                            aria-hidden="true"
                            class="w-17"
                            loading="lazy"
                        />
                    {:else}
                        <img
                            src="/svg/disc.svg"
                            alt=""
                            aria-hidden="true"
                            class="w-13"
                            loading="lazy"
                        />
                    {/if}
                </div>
                <div class="font-noto-sans font-medium italic uppercase text-center leading-5">
                    {#if air.type === "automatic"}
                        Programação automática
                    {:else if air.type === "live"}
                        Estamos ao vivo agora
                    {:else}
                        Programação gravada
                    {/if}
                </div>
            </div>
            <div class="flex flex-col mb-7">
                <div class="flex justify-center mb-1">
                    <div>
                        <div class="ml-2 text-neutral-aurora text-xl font-noto-sans font-bold uppercase italic">
                            Dê o
                        </div>
                        <div class={["-mt-4 font-noto-sans font-extrabold uppercase italic text-[3rem]",
                            { "text-blue-skywave": !$player.playing },
                            { "text-orange-amber": $player.playing },
                        ]}>
                            {$player.playing ? "Pause" : "Start"}
                        </div>
                    </div>
                    <button on:click={toggleAudio} class={["cursor-pointer shrink-0 w-14 h-14 rounded-full flex justify-center items-center active:shadow-[0_0_20px_rgba(0,145,255,0.8)] active:scale-95 transition-all",
                        { "bg-blue-skywave": !$player.playing },
                        { "bg-orange-amber": $player.playing },
                    ]}>
                        <img
                            src={$player.playing ? "/svg/pause.svg" : "/svg/play.svg"}
                            alt=""
                            aria-hidden="true"
                            class="w-5"
                            loading="lazy"
                        />
                    </button>
                </div>
                <div class="flex flex-col gap-2">
                    <div class="flex justify-between items-center px-1">
                        <span class="text-[10px] text-neutral-aurora/40 font-bold uppercase">Volume</span>
                        <span class="text-[10px] text-orange-amber font-bold">
                            {Math.round($player.volume * 100)}%
                        </span>
                    </div>
                    <input
                        id="volume"
                        name="volume"
                        type="range"
                        min="0"
                        max="1"
                        step="0.01"
                        value={$player.volume}
                        on:input={(e) => setVolume(e.target.value)}
                        class="w-full accent-orange-amber h-1.5 rounded-full bg-white/10 cursor-pointer transition-all hover:bg-white/20"
                    />
                </div>
            </div>
        </div>
        <button aria-label="Faça seu pedido" class="cursor-pointer w-full py-2 px-1 border border-neutral-aurora rounded-full text-blue-skywave text-xl text-center font-noto-sans font-bold italic uppercase disabled:cursor-not-allowed" on:click={() => {
            modalRef.open();
        }}>
            & Faça seu <strong class="text-orange-amber">Pedido</strong>
        </button>
    </div>
</section>

<section class="cont-player-main">
    <div class="mb-10 grid grid-cols-2 gap-5">
        <div class="bg-neutral-aurora/10 h-30 rounded-lg flex justify-center items-center text-neutral-aurora/40 text-lg font-bold uppercase italic">
            Anúncio
        </div>
        <div class="bg-neutral-aurora/10 h-30 rounded-lg flex justify-center items-center text-neutral-aurora/40 text-lg font-bold uppercase italic">
            Anúncio
        </div>
    </div>
</section>
