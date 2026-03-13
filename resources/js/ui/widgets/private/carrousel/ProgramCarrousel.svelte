<script>
    export let title;

    import { router, page } from "@inertiajs/svelte";
    import { Offcanvas, Section } from "@/ui/components/private/";
    import { ProgramForm } from "@/ui/widgets/private/form";
    import { scrollx, hasPermission } from "@/utils";

    $: ({ programs } = $page.props);
    
    let permissions = {
        show_button_create_program: hasPermission('program.create'),
        show_button_update_program: hasPermission('program.update'),
        show_button_delete_program: hasPermission('program.delete'),
    }

    let offcanvasRef;
    let identifier;

    const requestDeactivateProgram = (program) => {
        router.delete(`/painel/radio/program/${program}`)
    }
</script>

<Offcanvas bind:this={offcanvasRef} title={identifier ? 'Atualizar programa' : 'Cadastrar programa'}>
    <div slot="content" let:close>
        <ProgramForm {identifier} {close}/>
    </div>
</Offcanvas>

{#if permissions.show_button_create_program}
    <div class="flex justify-center mb-10">
        <button class="cursor-pointer bg-blue-skywave px-4 py-2 rounded-sm font-noto-sans font-bold italic uppercase text-neutral-aurora" on:click={()=> { 
            identifier = null; 
            offcanvasRef.open()
        }}>
            Cadastrar programa
        </button>
    </div>
{/if}

{#if programs}
    <Section {title} styles="mb-15">
        <div class="scroll-x overflow-x-auto flex gap-5 flex-nowrap mt-5" on:wheel|nonpassive={scrollx} role="group">
            {#if programs.data.length > 0}
                {#each programs.data as item}
                    <div class="shrink-0 flex justify-center gap-5 px-5 lg:first:pl-0 lg:border-r-2 lg:border-neutral-aurora/10 lg:last:border-0">
                        <div>
                            <img src={item.image} alt="" aria-hidden="true" loading="lazy" class='w-60 transition duration-300 ease-in-out'>
                        </div>
                        <div class="flex flex-col gap-5">
                            {#if permissions.show_button_update_program}
                                <button class="cursor-pointer" aria-label="atualizar programa" on:click={()=> {
                                    identifier = item.uuid;
                                    offcanvasRef.open();
                                }}>
                                    <img src="/svg/default/edit.svg" alt="" aria-hidden="true" class="w-[1.2rem] filter-blue-skywave" loading="lazy"/>
                                </button>
                            {/if}
                            {#if permissions.show_button_delete_program}
                                <button class="cursor-pointer" aria-label="desativar programa" on:click={()=>requestDeactivateProgram(item.uuid)}>
                                    <img src="/svg/default/trash.svg" alt="" aria-hidden="true" class="w-[1.2rem] filter-red-crimson" loading="lazy"/>
                                </button>
                            {/if}
                        </div>
                    </div>
                {/each}
            {/if}
        </div>
    </Section>
{/if}