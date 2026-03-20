<script>
    import { page, router} from "@inertiajs/svelte";
    import { Section } from "@/ui/components/private/";
    import { Offcanvas } from "@/ui/components/private";
    import { MarketingForm } from "@/ui/widgets/private/form";

    $: ({ repositories } = $page.props);

    let offCanvasRef;
    let itemIdentifier;

    let tutorials;
    let packages;
    let softwares; 

    $:if(repositories){
        tutorials = repositories.data.filter(item => item.type === 'tutorial');
        packages = repositories.data.filter(item => item.type === 'package');
        softwares = repositories.data.filter(item => item.type === 'software');
    }

    const deleteRepository = (repositoryId) => {
        router.delete(`/painel/marketing/deactivate/repository/${repositoryId}`);
    }
</script>

<Offcanvas bind:this={offCanvasRef} title={itemIdentifier ? 'Atualizar arquivo' : 'Cadastrar arquivo'}>
    <div slot="content" let:close>
        <MarketingForm {itemIdentifier} {close}/>
    </div>
</Offcanvas>

{#if repositories}
    <Section title="Tutoriais">
        <div class="mb-10 grid sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-7 gap-4">
            {#if tutorials > 0}
                {#each tutorials as item}
                    <article class="w-full bg-blue-skywave relative">
                        <a href={item.url} target="_blank">
                            <img src={item.image} alt={item.name} class="w-full h-48 object-cover aspect-square" loading="lazy"/>
                            <div class="p-2 text-neutral-aurora text-center font-noto-sans font-light">
                                {item.name}
                            </div>
                        </a>
                    </article>
                {/each}
            {:else}
                <article class="w-full bg-blue-skywave relative opacity-50">
                    <img src="https://placehold.co/500x500?text=Rede+Akiba" alt="" aria-hidden="true" class="w-full h-48 object-cover aspect-square" loading="lazy"/>
                    <div class="p-2 text-neutral-aurora text-center font-noto-sans font-light">
                        Nada por aqui, até agora
                    </div>
                </article>
            {/if}
        </div>
    </Section>

    <Section title="Instaladores">
        <div class="mb-10 grid sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-7 gap-4">
            {#if softwares.length > 0}
                {#each softwares as item}
                    <article class="w-full bg-blue-skywave relative">
                        <a href={item.url} target="_blank">
                            <img src={item.image} alt={item.name} class="w-full h-48 object-cover aspect-square" loading="lazy"/>
                            <div class="p-2 text-neutral-aurora text-center font-noto-sans font-light">
                                {item.name}
                            </div>
                        </a>
                    </article>
                {/each}
            {:else}
                <article class="w-full bg-blue-skywave relative opacity-50">
                    <img src="https://placehold.co/500x500?text=Rede+Akiba" alt="" aria-hidden="true" class="w-full h-48 object-cover aspect-square" loading="lazy"/>
                    <div class="p-2 text-neutral-aurora text-center font-noto-sans font-light">
                        Nada por aqui, até agora
                    </div>
                </article>
            {/if}
        </div>
    </Section>

    <Section title="Pacotes e Modelos">
        <div class="mb-10 grid sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-7 gap-4">
            {#if packages > 0}
                {#each packages as item}
                    <article class="w-full bg-blue-skywave relative">
                        <a href={item.url} target="_blank">
                            <img src={item.image} alt={item.name} class="w-full h-48 object-cover aspect-square" loading="lazy"/>
                            <div class="p-2 text-neutral-aurora text-center font-noto-sans font-light">
                                {item.name}
                            </div>
                        </a>
                    </article>
                {/each}
            {:else}
                <article class="w-full bg-blue-skywave relative opacity-50">
                    <img src="https://placehold.co/500x500?text=Rede+Akiba" alt="" aria-hidden="true" class="w-full h-48 object-cover aspect-square" loading="lazy"/>
                    <div class="p-2 text-neutral-aurora text-center font-noto-sans font-light">
                        Nada por aqui, até agora
                    </div>
                </article>
            {/if}
        </div>
    </Section>
{/if}

<Section title="Todos os conteúdos">
    <div class="flex justify-center mt-5 mb-15">
        <button class="cursor-pointer w-full lg:w-auto py-2 px-6 border-4 border-solid border-orange-amber rounded-xl text-orange-amber text-xl font-bold font-noto-sans italic uppercase" onclick={()=> offCanvasRef.open()}>
            Upar conteúdo
        </button>
    </div>
    {#if repositories}
        <div class="mb-20 grid sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-7 gap-x-4 gap-y-20">
            {#if repositories.data.length > 0}
                {#each repositories.data as item}
                    <article class="w-full bg-blue-skywave relative">
                        <a href={item.url} target="_blank">
                            <img src={item.image} alt={item.name}  class="w-full h-48 object-cover aspect-square" loading="lazy"/>
                            <div class="p-2 text-neutral-aurora text-center font-noto-sans font-light">
                                {item.name}
                            </div>
                        </a>
                        <div class="absolute -bottom-9 right-0 flex flex-row gap-4">
                            <button class="cursor-pointer" aria-label="editar" onclick={()=> {
                                offCanvasRef.open();
                                itemIdentifier = item.uuid;
                            }}>
                                <img src="/svg/default/edit.svg" alt="" aria-hidden="true" class="w-5 filter-blue-skywave" loading="lazy"/>
                            </button>
                            <button aria-label="remover" class="cursor-pointer" onclick={()=>deleteRepository(item.id)}>
                                <img src="/svg/default/trash.svg" alt="" aria-hidden="true" class="w-5 filter-red-crimson" loading="lazy"/>
                            </button>
                        </div>
                    </article>
                {/each}
            {:else}
                <article class="w-full bg-blue-skywave relative opacity-50">
                    <img src="https://placehold.co/500x500?text=Rede+Akiba" alt="" aria-hidden="true" class="w-full h-48 object-cover aspect-square" loading="lazy"/>
                    <div class="p-2 text-neutral-aurora text-center font-noto-sans font-light">
                        Nada por aqui, até agora
                    </div>
                </article>
            {/if}
        </div>
    {/if}
</Section>
