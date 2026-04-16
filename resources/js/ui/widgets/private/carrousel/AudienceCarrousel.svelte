<script>
    export let title;

    import { page, usePoll } from "@inertiajs/svelte";
    import { Section } from "@/ui/components/private/";
    import { scrollx } from "@/utils";

    $: audienceStats = $page.props.audienceStats || [];
    $: isLocal = $page.props.isLocal || false;

    // Habilita a atualização automática dos dados a cada 30 segundos
    usePoll(30000, { only: ["audienceStats"] });
</script>

<Section {title}>
    {#if isLocal}
        <div class="mb-8 mx-auto max-w-2xl bg-amber-500/10 border border-amber-500/20 rounded-xl p-4 flex items-center gap-4 text-amber-500 animate-pulse">
            <div class="bg-amber-500/20 p-2 rounded-lg">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z"/><path d="M12 9v4"/><path d="M12 17h.01"/></svg>
            </div>
            <div class="flex-1 text-left">
                <h4 class="text-sm font-bold uppercase tracking-wider">Ambiente Local</h4>
                <p class="text-xs opacity-80">A verificação SSL está desativada para garantir a conectividade com as APIs das rádios neste ambiente.</p>
            </div>
        </div>
    {/if}

    <div class="scroll-x overflow-x-auto flex gap-5 flex-nowrap" on:wheel|nonpassive={scrollx} role="group">
        {#each audienceStats as radio}
            <div class="flex flex-col items-center w-40 text-center">
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

                <!-- Admin -->
                <span class="text-[10px] font-medium text-white/50 tracking-[0.1em] uppercase mb-1">
                    ADMIN: {radio.admin || '-'}
                </span>

                <!-- Listener Count -->
                <div class="flex items-center gap-2 font-black italic text-lg {radio.color || 'text-cyan-400'} uppercase tracking-tight">
                    <svg 
                        xmlns="http://www.w3.org/2000/svg" 
                        class="w-5 h-5 flex-shrink-0 text-blue-500" 
                        viewBox="0 0 24 24" 
                        fill="currentColor"
                    >
                        <path d="M12 3a9 9 0 0 0-9 9v7c0 1.1.9 2 2 2h4v-8H5v-1c0-3.87 3.13-7 7-7s7 3.13 7 7v1h-4v8h4c1.1 0 2-.9 2-2v-7a9 9 0 0 0-9-9z"/>
                    </svg>
                    <span>{radio.listeners ?? 'NaN'} OUVINTES</span>
                </div>
            </div>
        {/each}
    </div>
</Section>
