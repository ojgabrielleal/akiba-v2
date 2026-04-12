<script>
    export let title;

    import { router, page } from "@inertiajs/svelte";
    import { Section, Offcanvas } from "@/ui/components/private";
    import { RoleForm } from "@/ui/widgets/private";
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

<Offcanvas bind:this={offCanvasRef} title={identifier ? "Atualizar cargo" : "Cadastrar cargo"}>
    <div slot="content" let:close>
        <RoleForm {identifier} {close} />
    </div>
</Offcanvas>

<Section {title}>
    {#if can.create}
        <div class="flex justify-center gap-5 mb-5">
            <button class="cursor-pointer bg-blue-ocean px-4 py-2 rounded-sm font-noto-sans font-bold italic uppercase text-neutral-aurora" on:click={() => {
                identifier = null;
                offCanvasRef.open();
            }}>
                Cadastrar cargo
            </button>
        </div>
    {/if}
    {#if roles && roles.data.length > 0}
        <div class="overflow-x-auto w-full">
            <table class="min-w-[900px] w-full border-collapse table-auto">
                <thead>
                    <tr class="text-neutral-aurora uppercase text-sm font-bold italic whitespace-nowrap">
                        <th class="p-4 text-start min-w-[180px]">Cargo</th>
                        <th class="p-4 text-start min-w-[180px]">Membros relacionados</th>
                        <th class="p-4 text-start min-w-[300px]">Descrição</th>
                        <th class="p-4 text-start min-w-[140px]">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    {#each roles.data as item}
                        <tr class="border-t border-neutral-aurora/20 text-neutral-aurora whitespace-nowrap">
                            <td class="p-4 align-top min-w-[180px]">
                                {item.label}
                            </td>
                            <td class="p-4 align-top min-w-[180px]">
                                {item.members_total} membros
                            </td>
                            <td class="p-4 min-w-[300px] max-w-[400px] whitespace-normal wrap-break-words">
                                {item.description}
                            </td>
                            <td class="p-4 min-w-[140px]">
                                <div class="flex justify-start gap-3">
                                    {#if can.update}
                                        <button class="bg-blue-ocean rounded-md p-3 cursor-pointer shrink-0" aria-label="atualizar cargo" on:click={() => {
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
                                        <button class="bg-red-crimson p-3 rounded-md cursor-pointer shrink-0" aria-label="remover cargo" on:click={() => {
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
                            </td>
                        </tr>
                    {/each}
                </tbody>
            </table>
        </div>
    {/if}
</Section>
