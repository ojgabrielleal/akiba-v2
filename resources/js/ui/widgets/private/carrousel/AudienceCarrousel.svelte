<script>
    export let title;

    import { page, usePoll } from "@inertiajs/svelte";
    import { Section } from "@/ui/components/private/";
    import { scrollx } from "@/utils";

    $: audienceStats = $page.props.audienceStats || [];

    // Habilita a atualização automática dos dados a cada 30 segundos
    usePoll(30 * 1000);
</script>

<Section {title}>
    <div class="scroll-x overflow-x-auto flex gap-5 flex-nowrap" on:wheel|nonpassive={scrollx} role="group">
        {#each audienceStats as radio}
            <article class="shrink-0 flex flex-col items-center w-60 text-center px-6 lg:first:pl-0 lg:border-r-2 lg:border-neutral-aurora/10 lg:last:border-r-0">
                <!-- Logo -->
                <div class="flex items-center justify-center h-16 w-full mb-3">
                    {#if radio.logo}
                        <img 
                            src={radio.logo} 
                            alt={radio.nome} 
                            class="max-h-full max-w-full object-contain filter drop-shadow-lg" 
                        />
                    {:else}
                        <div class="w-24 h-8 bg-gray-800/50 rounded border border-dashed border-gray-600 flex items-center justify-center text-[10px] text-gray-500 uppercase tracking-tighter">
                            Logo {radio.nome}
                        </div>
                    {/if}
                </div>

                <!-- Radio Name -->
                <span class="text-[10px] font-medium text-white/50 tracking-widest uppercase mb-1">
                    {radio.nome}
                </span>

                <!-- Listener Count -->
                <div class="flex items-center gap-2 font-black italic text-lg {radio.color || 'text-cyan-400'} uppercase tracking-tight">
                    <svg 
                        xmlns="http://www.w3.org/2000/svg" 
                        class="w-5 h-5 shrink-0 text-blue-500" 
                        viewBox="0 0 24 24" 
                        fill="currentColor"
                    >
                        <path d="M12 3a9 9 0 0 0-9 9v7c0 1.1.9 2 2 2h4v-8H5v-1c0-3.87 3.13-7 7-7s7 3.13 7 7v1h-4v8h4c1.1 0 2-.9 2-2v-7a9 9 0 0 0-9-9z"/>
                    </svg>
                    <span>{radio.listeners ?? 'NaN'} OUVINTES</span>
                </div>
            </article>
        {/each}
    </div>
</Section>

