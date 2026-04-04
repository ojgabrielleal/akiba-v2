<script>
    export let title;

    import { router, page } from "@inertiajs/svelte";
    import { Section, Offcanvas } from "@/ui/components/private/";
    import { RoleForm } from "@/ui/widgets/private/form";
    import { hasPermission } from "@/utils";

    $: ({ roles } = $page.props);

    let can = {
        create: hasPermission("role.create"),
        update: hasPermission("role.update"),
        remove: hasPermission("role.remove"),
    };

    let offCanvasRef;
    let identifier;

    const requestRemoveRole = (role) => {
        router.delete(`/painel/adms/roles/${role}`, {
            preserveScroll: true,
            preserveState: true,
        });
    };
</script>

<Offcanvas
    bind:this={offCanvasRef}
    title={identifier ? "Atualizar cargo" : "Cadastrar cargo"}
>
    <div slot="content" let:close>
        <RoleForm {identifier} {close} />
    </div>
</Offcanvas>

{#if roles}
    <Section {title}>
        {#if can.create}
            <div class="flex justify-center gap-5 mb-5">
                <button
                    class="cursor-pointer bg-blue-ocean px-4 py-2 rounded-sm font-noto-sans font-bold italic uppercase text-neutral-aurora"
                    on:click={() => {
                        identifier = null;
                        offCanvasRef.open();
                    }}
                >
                    Cadastrar cargo
                </button>
            </div>
        {/if}
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-4">
            {#if roles.data.length > 0}
                {#each roles.data as item}
                    <div class="w-full h-50 bg-blue-ocean rounded-lg p-4 relative">
                        <div class="font-noto-sans font-black italic uppercase text-lg text-neutral-aurora">
                            {item.label}
                        </div>
                        <div class="font-noto-sans text-sm text-neutral-aurora">
                            <b>Membros nesse cargo:</b>
                            {item.members_total}
                        </div>
                        <div class="flex items-center gap-4 mb-2 mt-2 flex-1 h-px bg-neutral-aurora"></div>
                        <div class="font-noto-sans text-sm line-clamp-3 text-neutral-aurora">
                            {item.description}
                        </div>
                        <div class="absolute bottom-4 right-5 flex gap-3">
                            {#if can.update}
                                <button class="cursor-pointer" aria-label="atualizar cargo" on:click={() => {
                                    identifier = item.uuid;
                                    offCanvasRef.open();
                                }}>
                                    <img
                                        src="/svg/default/edit.svg"
                                        alt=""
                                        aria-hidden="true"
                                        class="w-[1.2rem] filter invert"
                                        loading="lazy"
                                    />
                                </button>
                            {/if}
                            {#if can.remove}
                                <button class="cursor-pointer" aria-label="remover cargo" on:click={() => {
                                    requestRemoveRole(item.uuid);
                                }}>
                                    <img
                                        src="/svg/default/trash.svg"
                                        alt=""
                                        aria-hidden="true"
                                        class="w-[1.2rem] filter invert"
                                        loading="lazy"
                                    />
                                </button>
                            {/if}
                        </div>
                    </div>
                {/each}
            {/if}
        </div>
    </Section>
{/if}
