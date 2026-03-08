<script>
    export let title;

    import { page } from "@inertiajs/svelte";
    import { Offcanvas, Section } from "@/ui/components/private/";
    import { ProgramForm } from "@/ui/widgets/private/form";
    import { scrollx, hasPermission } from "@/utils";

    $: ({ programs } = $page.props);

    let offcanvasRef;
    let identifier;
</script>


<Offcanvas bind:this={offcanvasRef}>
    <div slot="content" let:close>
        <ProgramForm {identifier} {close}/>
    </div>
</Offcanvas>

<div class="flex justify-center mb-10">
    <button class="cursor-pointer bg-blue-skywave px-4 py-2 rounded-sm font-noto-sans font-bold italic uppercase text-neutral-aurora" on:click={()=>offcanvasRef.open()}>
        Cadastrar programa
    </button>
</div>
<Section {title}>
    <div class="scroll-x overflow-x-auto flex gap-5 flex-nowrap mt-5" on:wheel|nonpassive={scrollx} role="group">
        {#if programs.data.length > 0}
            {#each programs.data as item}
                <div class="shrink-0 flex justify-center gap-5 px-5 lg:first:pl-0 lg:border-r-2 lg:border-neutral-aurora/10 lg:last:border-0">
                    <div>
                         <img src={item.image} alt="" aria-hidden="true" loading="lazy" class='w-60 transition duration-300 ease-in-out'>
                    </div>
                    <div class="flex flex-col gap-5">
                        <button class="cursor-pointer" aria-label="atualizar programa" on:click={()=> {
                            identifier = item.uuid;
                            offcanvasRef.open();
                        }}>
                            <img src="/svg/default/edit.svg" alt="" aria-hidden="true" class="w-[1.2rem] filter-blue-skywave" loading="lazy"/>
                        </button>
                        <button>
                            <img src="/svg/default/trash.svg" alt="" aria-hidden="true" class="w-[1.2rem] filter-red-crimson" loading="lazy"/>
                        </button>
                    </div>
                </div>
            {/each}
        {/if}
    </div>
</Section>
