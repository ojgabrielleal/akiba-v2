<script>
    export let title; 

    import { page } from "@inertiajs/svelte";
    import { Offcanvas, Section } from "@/ui/components/private/";
    import { ActivityForm } from "@/ui/widgets/private/form";

    $: ({ activities } = $page.props);

    let offcanvasRef;
    let identifier;
</script>

<Offcanvas bind:this={offcanvasRef} title="Atualizar atividade">
    <div slot="content" let:close>
        <ActivityForm {identifier} {close}/>
    </div>
</Offcanvas>

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
                    {#each item.confirmations.slice(0, 3) as conf}
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
                    {#if item.confirmations.length > 3}
                        <div class="relative group/popover">
                            <div class="ml-2 flex items-center justify-center cursor-pointer">
                                <img src="/svg/default/dots.svg" alt="" aria-hidden="true" class="w-5 filter invert" loading="lazy"/>
                            </div>
                            <div class="invisible group-hover/popover:visible opacity-0 group-hover/popover:opacity-100 translate-y-1 group-hover/popover:translate-y-0 transition-all duration-200 absolute bottom-full left-1/2 -translate-x-1/2 pb-3 z-10 pointer-events-auto">
                                <div class="p-3 bg-neutral-900/95 backdrop-blur-md rounded-2xl shadow-2xl flex flex-col gap-2 items-center border border-white/10 max-h-80 overflow-y-auto [&::-webkit-scrollbar]:w-1.5 [&::-webkit-scrollbar-thumb]:bg-white/20 [&::-webkit-scrollbar-thumb]:rounded-full [&::-webkit-scrollbar-track]:bg-transparent">
                                    {#each item.confirmations.slice(3) as rest}
                                        <span class="text-[11px] text-white/90 font-medium max-w-[80px] truncate text-center">
                                            {rest.nickname}
                                        </span>
                                    {/each}
                                </div>
                                <div class="absolute top-[calc(100%-12px)] left-1/2 -translate-x-1/2 border-4 border-transparent border-t-neutral-900/95"></div>
                            </div>
                        </div>
                    {/if}
                    <!-- If there are more than 3 confirmations, show a "+" button -->
                </div>
                <button
                    type="button"
                    aria-label="Editar alerta"
                    class="w-8 h-8 absolute bottom-3 right-4 flex justify-center items-center font-noto-sans italic font-bold cursor-pointer"
                    onclick={() => {
                        identifier = item.uuid;
                        offcanvasRef.open();
                    }}
                >
                    <img src="/svg/default/edit.svg" alt="" aria-hidden="true" class="w-5 filter invert" loading="lazy"/>
                </button>
            </article>
        {/each}
    </div>
</Section>
