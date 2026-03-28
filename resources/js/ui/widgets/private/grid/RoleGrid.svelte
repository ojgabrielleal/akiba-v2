<script>
    export let title;

    import { page } from "@inertiajs/svelte";
    import { Section, Offcanvas } from "@/ui/components/private/";
    import { RoleForm } from "@/ui/widgets/private/form"

    $: ({ roles } = $page.props);

    let offCanvasRef;
    let identifier;
</script>

<Offcanvas bind:this={offCanvasRef} title={identifier ? "Atualizar cargo" : "Cadastrar cargo"}>
    <div slot="content" let:close>
        <RoleForm {identifier} {close}/>
    </div>
</Offcanvas>

<Section {title}>
    <div class="flex justify-center gap-5 mb-5">
        <button class="cursor-pointer bg-blue-ocean px-4 py-2 rounded-sm font-noto-sans font-bold italic uppercase text-neutral-aurora" on:click={()=> { 
            identifier = null;
            offCanvasRef.open()
        }}>
            Cadastrar cargo
        </button>
    </div>
    <div class="grid grid-cols-4 gap-4">
        {#each roles.data as item}
            <div class="w-full h-50 bg-blue-ocean rounded-lg p-4 relative">
                <div class="font-noto-sans font-black italic uppercase text-lg text-neutral-aurora">
                    {item.label}
                </div> 
                <div class="font-noto-sans text-sm text-neutral-aurora">
                    <b>Peso:</b> {item.weight}
                </div>
                <div class="flex items-center gap-4 mb-2 mt-2 flex-1 h-px bg-neutral-aurora">
                </div>
                <div class="font-noto-sans text-sm line-clamp-3 text-neutral-aurora">
                    {item.description}
                </div>
                <div class="absolute bottom-4 right-5 flex gap-3">
                    <button class="cursor-pointer" aria-label="atualizar programa" on:click={()=> { 
                        identifier = item.uuid;
                        offCanvasRef.open()
                    }}>
                        <img src="/svg/default/edit.svg" alt="" aria-hidden="true" class="w-[1.2rem] filter invert" loading="lazy"/>
                    </button>
                    <button class="cursor-pointer" aria-label="desativar programa" >
                        <img src="/svg/default/trash.svg" alt="" aria-hidden="true" class="w-[1.2rem] filter invert" loading="lazy"/>
                    </button>
                </div>
            </div>  
        {/each}         
    </div>
</Section>