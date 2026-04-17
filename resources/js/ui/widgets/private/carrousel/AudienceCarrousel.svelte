<script>
    export let title;

    import { page, usePoll } from "@inertiajs/svelte";
    import { Section } from "@/ui/components/private/";
    import { scrollx } from "@/utils";

    $: ({ audience } = $page.props);

    usePoll(60 * 1000);
</script>

<Section {title}>
    <div class="scroll-x overflow-x-auto flex gap-5 flex-nowrap mt-5" on:wheel|nonpassive={scrollx} role="group">
            {#each audience as item}
                <article class="shrink-0 flex flex-col items-center justify-center gap-4 px-5 lg:first:pl-0 lg:border-r-2 lg:border-neutral-aurora/10 lg:last:border-0">
                    <div class="">
                        <img 
                            src={item.logo} 
                            alt="" 
                            aria-hidden="true" 
                            loading="lazy" 
                            class="w-15 h-15 object-contain rounded-lg" 
                        />
                    </div>
                    <div class="flex flex-col gap-1">
                        <span class="w-full text-center text-[10px] font-medium text-white/50 tracking-widest uppercase mb-1">
                            {item.nome}
                        </span>
                        <div class="flex items-center gap-1 font-black italic text-lg text-neutral-aurora uppercase">
                            <img 
                                src="/svg/listeners.svg" 
                                alt="Ouvintes" 
                                class="w-5 h-5 shrink-0 filter invert" 
                            />
                            <span>{item.listeners} OUVINTES</span>
                        </div>
                    </div>
                </article>
            {/each}
        </div>
</Section>

