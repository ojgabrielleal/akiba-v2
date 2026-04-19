<script>
    export let title;

    import { page, router, usePoll } from "@inertiajs/svelte";
    import { Section } from "@/ui/components/private/";
    import { hasPermission } from "@/utils";

    $: ({ onair, songRequests } = $page.props);

    let can = {
        toggle: hasPermission("songrequest.toggle"),
        reproduce: hasPermission("songrequest.reproduce"),
        cancel: hasPermission("songrequest.cancel"),
        locution: {
            finish: hasPermission("locution.finish"),
        },
    };

    const requestToggleSongRequest = () => {
        router.patch("/panel/locution/songrequest/toggle", {}, { 
            preserveScroll: true 
        });
    };

    const markToReproduced = (songrequest) => {
        router.patch(`/panel/locution/songrequest/${songrequest}/played`, {}, { 
            preserveScroll: true 
        });
    };

    const markToCanceled = (songrequest) => {
        router.patch(`/panel/locution/songrequest/${songrequest}/canceled`, {}, { 
            preserveScroll: true 
        });
    };

    const requestFinishlocution = () => {
        router.patch(`/panel/locution/locution/finish`);
    };

    usePoll(60 * 1000);
</script>

{#if hasPermission("songrequest.list")}
    <Section {title}>
        <div id="requests" class="flex flex-col gap-5 lg:relative">
            {#if can.locution.finish}
                <button class="cursor-pointer block lg:absolute right-0 w-full lg:w-auto py-2 px-6 border-4 border-solid border-red-crimson rounded-xl text-red-crimson text-xl font-bold font-noto-sans italic uppercase" on:click={() => {
                    requestFinishlocution();
                }}>
                    Encerrar programa
                </button>
            {/if}
            {#if can.toggle}
                <div class="flex justify-center">
                    {#if onair.data.allows_song_requests}
                        <button class="cursor-pointer w-full lg:w-auto py-2 px-6 border-4 border-solid border-neutral-honeycream rounded-xl text-neutral-honeycream text-xl font-bold font-noto-sans italic uppercase" on:click={() => {
                            requestToggleSongRequest();
                        }}>
                            Parar de receber
                        </button>
                    {:else}
                        <button class="cursor-pointer w-full lg:w-auto py-2 px-6 border-4 border-solid border-green-forest rounded-xl text-green-forest text-xl font-bold font-noto-sans italic uppercase" on:click={() => {
                            requestToggleSongRequest();
                        }}>
                            Começar a receber
                        </button>
                    {/if}
                </div>
            {/if}
        </div>
        <div class="grid grid-cols-1 lg:grid-cols-3 2xl:grid-cols-4 gap-2 mt-10">
            {#each songRequests.data as item}
                <article class={["w-full 2xl:w-[23.6rem] rounded-lg p-3",
                    { "bg-green-forest": item.was_reproduced },
                    { "bg-red-crimson": item.was_canceled },
                    { "bg-blue-skywave": !item.was_reproduced && !item.was_canceled },
                ]}>
                    <div class="w-70 flex items-center gap-1.5 text-neutral-aurora text-[1.2rem] font-noto-sans font-bold italic">
                        <img
                            src="/svg/profile.svg"
                            alt=""
                            aria-hidden="true"
                            class="w-5 filter invert"
                            loading="lazy"
                        />
                        <span class="truncate">
                            {item.name}
                        </span>
                    </div>
                    <div class="w-full mt-1 flex gap-1.5 text-neutral-aurora text-[1rem] font-noto-sans">
                        <img
                            src="/svg/gps.svg"
                            alt=""
                            aria-hidden="true"
                            class="w-5 filter invert"
                            loading="lazy"
                        />
                        <span class="truncate">
                            {item.address}
                        </span>
                    </div>
                    <div class="mt-1.5 flex gap-1.5 text-neutral-aurora text-[1rem] font-noto-sans">
                        <img
                            src="/svg/ip.svg"
                            alt=""
                            aria-hidden="true"
                            class="w-5 filter invert"
                            loading="lazy"
                        />
                        {item.ip}
                    </div>
                    <div class="flex items-center justify-center w-full mt-5 mb-5">
                        <div class="relative w-full">
                            <div class="absolute left-0 w-2/5 h-[0.1rem] bg-white rounded-full top-1/2 -translate-y-1/2"></div>
                            <div class="absolute inset-0 flex items-center justify-center">
                                <img
                                    src="/svg/music.svg"
                                    alt=""
                                    aria-hidden="true"
                                    class="w-6 filter invert"
                                    loading="lazy"
                                />
                            </div>
                            <div class="absolute right-0 w-2/5 h-[0.1rem] bg-white rounded-full top-1/2 -translate-y-1/2"></div>
                        </div>
                    </div>
                    <div class="flex flex-wrap xl:flex-nowrap gap-3">
                        <img
                            src={item.music.image}
                            alt={`Capa do anime ${item.music.production}`}
                            class="w-15 h-15 rounded-lg object-cover object-top shrink-0"
                            loading="lazy"
                        />
                        <div>
                            <div class="w-full lg:w-50 xl:w-full block text-neutral-aurora text-sm font-noto-sans">
                                Anime:
                                <span class="truncate">
                                    {item.music.production}
                                </span>
                            </div>
                            <div class="w-full lg:w-50 xl:w-full block text-neutral-aurora text-sm font-noto-sans">
                                Artista:
                                <span class="truncate">
                                    {item.music.artist}
                                </span>
                            </div>
                            <div class="w-full lg:w-50 xl:w-full block text-neutral-aurora text-sm font-noto-sans">
                                Música:
                                <span class="truncate">
                                    {item.music.name}
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center justify-center w-full mt-5 mb-5">
                        <div class="relative w-full">
                            <div class="absolute left-0 w-2/5 h-[0.1rem] bg-white rounded-full top-1/2 -translate-y-1/2"></div>
                            <div class="absolute inset-0 flex items-center justify-center">
                                <img
                                    src="/svg/telegram.svg"
                                    alt=""
                                    aria-hidden="true"
                                    class="w-7 filter invert"
                                    loading="lazy"
                                />
                            </div>
                            <div class="absolute right-0 w-2/5 h-[0.1rem] bg-white rounded-full top-1/2 -translate-y-1/2"></div>
                        </div>
                    </div>
                    <div class="h-15 line-clamp-3 text-neutral-aurora text-sm font-noto-sans mb-7">
                        {item.message}
                    </div>
                    <div class="flex justify-between">
                        <div class="flex items-center gap-1 text-neutral-aurora text-sm font-noto-sans font-bold italic">
                            <img
                                src="/svg/clock.svg"
                                alt=""
                                aria-hidden="true"
                                class="w-5 filter invert"
                                loading="lazy"
                            />
                            {item.created_at}
                        </div>
                        <div class="flex gap-3">
                            {#if !item.was_reproduced && !item.was_canceled}
                                {#if can.cancel}
                                    <button aria-label="Marcar como cancelado" class="cursor-pointer" on:click={() => markToCanceled(item.uuid)}>
                                        <img
                                            src="/svg/close.svg"
                                            alt=""
                                            aria-hidden="true"
                                            class="w-6 filter invert"
                                            loading="lazy"
                                        />
                                    </button>
                                {/if}
                                {#if can.reproduce}
                                    <button aria-label="Marcar como atendido" class="cursor-pointer" on:click={() => markToReproduced(item.uuid)}>
                                        <img
                                            src="/svg/like.svg"
                                            alt=""
                                            aria-hidden="true"
                                            class="w-6 filter invert"
                                            loading="lazy"
                                        />
                                    </button>
                                {/if}
                            {/if}
                        </div>
                    </div>
                </article>
            {/each}
        </div>
    </Section>
{/if}
