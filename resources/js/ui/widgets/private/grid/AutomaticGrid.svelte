<script>
    export let title;

    import { page, router } from "@inertiajs/svelte";
    import { Offcanvas, Section } from "@/ui/components/private/";
    import { AutomaticForm } from "@/ui/widgets/private";
    import { hasPermission } from "@/utils";

    $: ({ automatics } = $page.props);

    let can = {
        create: hasPermission("automatic.create"),
        update: hasPermission("automatic.update"),
        deactivate: hasPermission("automatic.deactivate"),
    };

    let offcanvasRef;
    let identifier;

    const requestDeactivateProgram = (uuid) => {
        router.delete(`/panel/administration/automatic/${uuid}`, {
            preserveScroll: true,
        });
    };
</script>

<Offcanvas bind:this={offcanvasRef} title={identifier ? "Atualizar auto DJ" : "Cadastrar auto DJ"}>
    <div slot="content" let:close>
        <AutomaticForm {identifier} {close} />
    </div>
</Offcanvas>

{#if automatics}
    <Section {title}>
        {#if can.create}
            <div class="flex justify-center gap-5 mb-14">
                <button class="cursor-pointer bg-blue-skywave px-4 py-2 rounded-lg font-noto-sans font-bold italic uppercase text-suspense-aurora" on:click={() => { identifier = null; offcanvasRef.open(); }}>
                    Cadastrar auto DJ
                </button>
            </div>
        {/if}
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-5">
            {#each automatics.data as item}
                <article class="w-full flex items-start">
                    <div class="w-[95%]">
                        <img
                            class="w-40 mb-3"
                            src={item.image}
                            alt={item.name}
                            loading="lazy"
                        />
                        <div class="w-full rounded-md py-3 px-4 bg-suspense-aurora relative mb-2">
                            {#if item.is_default}
                                <span class="absolute -top-2.5 -right-1.5 bg-blue-skywave text-suspense-aurora text-[0.6rem] font-noto-sans font-bold px-2 py-1 rounded-md uppercase italic shadow-md z-10">
                                    Padrão
                                </span>
                            {/if}
                            <div class="text-blue-skywave text-md font-noto-sans uppercase">
                                <strong class="font-bold">
                                    Com:
                                </strong>
                                {item.host.nickname}
                            </div>
                            <img
                                class="w-36 aspect-square absolute right-0 bottom-0 object-cover object-top"
                                src={item.host.avatar}
                                alt={item.host.nickname}
                                loading="lazy"
                            />
                        </div>
                    </div>
                    <div class="flex flex-col flex-1 gap-5">
                        {#if can.update}
                            <button
                                class="cursor-pointer"
                                aria-label="atualizar auto DJ"
                                on:click={() => { identifier = item.uuid; offcanvasRef.open(); }}
                            >
                                <img
                                    src="/svg/edit.svg"
                                    alt=""
                                    aria-hidden="true"
                                    class="w-[1.2rem] filter-blue-skywave"
                                    loading="lazy"
                                />
                            </button>
                        {/if}
                        {#if can.deactivate}
                            <button
                                class="cursor-pointer"
                                aria-label="desativar auto DJ"
                                on:click={()
                            >
                                    requestDeactivateProgram(item.uuid)}
                            >
                                <img
                                    src="/svg/trash.svg"
                                    alt=""
                                    aria-hidden="true"
                                    class="w-[1.2rem] filter-red-crimson"
                                    loading="lazy"
                                />
                            </button>
                        {/if}
                    </div>
                </article>
            {/each}
        </div>
    </Section>
{/if}
