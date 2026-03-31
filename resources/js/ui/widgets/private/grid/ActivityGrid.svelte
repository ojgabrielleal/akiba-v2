<script>
    export let title; 

    import { fly } from 'svelte/transition';
    import { page, router } from "@inertiajs/svelte";
    import { Section } from "@/ui/components/private/";

    $: ({ activities } = $page.props);

    let popoverId = null;
</script>

<Section {title}>
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-4 ">
        {#each activities.data as item}  
            <article class='h-50 w-full shrink-0 rounded-lg p-4 relative bg-blue-skywave'>
                <div class='font-noto-sans font-black italic uppercase text-xl text-neutral-aurora'>
                    {item.author.nickname}
                </div>
                <div class="font-noto-sans text-sm text-neutral-aurora line-clamp-5 mt-1">
                    {item.content}
                </div>        
                <div class="flex gap-2 absolute bottom-3 left-4 items-center">
                    {#each item.confirmations.slice(0, 2) as conf}
                        <div class="relative group/avatar">
                            <img
                                src={conf.avatar}
                                alt={conf.nickname}
                                class="w-10 h-10 rounded-full bg-neutral-aurora border-2 border-white/10 shadow-sm object-cover object-top hover:scale-105 transition-transform duration-300"
                                loading="lazy"
                            />
                            <div class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 px-2 py-1 bg-neutral-900/90 backdrop-blur-sm text-white text-[10px] font-medium rounded-lg invisible group-hover/avatar:visible opacity-0 group-hover/avatar:opacity-100 transition-all duration-200 whitespace-nowrap z-50 pointer-events-none border border-white/10 shadow-xl">
                                {conf.nickname}
                                <div class="absolute top-full left-1/2 -translate-x-1/2 border-4 border-transparent border-t-neutral-900/90"></div>
                            </div>
                        </div>
                    {/each}
                    <!-- If there are more than 2 confirmations, show a "+" button -->
                    {#if item.confirmations.length > 2}
                        <div class="relative">
                            <button 
                                type="button" 
                                class="ml-2 flex items-center justify-center cursor-pointer outline-none"
                                on:click|stopPropagation={() => popoverId = popoverId === item.id ? null : item.id}
                            >
                                <img src="/svg/default/dots.svg" alt="" aria-hidden="true" class="w-5 filter invert" loading="lazy"/>
                            </button>
                            {#if popoverId === item.id}
                                <div transition:fly={{ y: 5, duration: 200 }} class="absolute bottom-full left-1/2 -translate-x-1/2 mb-3 z-10 pointer-events-auto">
                                    <div class="p-3 bg-neutral-900/95 backdrop-blur-md rounded-2xl shadow-2xl flex flex-col gap-3 items-center border border-white/10 max-h-80 overflow-y-auto [&::-webkit-scrollbar]:w-1.5 [&::-webkit-scrollbar-thumb]:bg-white/20 [&::-webkit-scrollbar-thumb]:rounded-full [&::-webkit-scrollbar-track]:bg-transparent">
                                        {#each item.confirmations.slice(2) as rest}
                                            <div class="flex flex-col items-center gap-1.5 min-w-[56px] shrink-0">
                                                <div class="relative">
                                                    <img
                                                        src={rest.avatar}
                                                        alt={rest.nickname}
                                                        class="w-10 h-10 rounded-full bg-neutral-aurora object-cover object-top border-2 border-white/20 shadow-md ring-2 ring-neutral-aurora/20"
                                                        loading="lazy"
                                                    />
                                                </div>
                                                <span class="text-[10px] text-white/90 font-medium max-w-[64px] truncate text-center">
                                                    {rest.nickname}
                                                </span>
                                            </div>
                                        {/each}
                                    </div>
                                </div>
                            {/if}
                        </div>
                    {/if}
                    <!-- If there are more than 2 confirmations, show a "+" button -->
                </div>
                <button
                    type="button"
                    aria-label="Editar alerta"
                    class="w-8 h-8 absolute bottom-3 right-4 flex justify-center items-center font-noto-sans italic font-bold cursor-pointer"
                >
                    <img src="/svg/default/edit.svg" alt="" aria-hidden="true" class="w-5 filter invert" loading="lazy"/>
                </button>
            </article>
        {/each}
    </div>
</Section>

<svelte:window on:click={() => popoverId = null} />
