<script>
    export let title; 

    import { page, router } from "@inertiajs/svelte";
    import { Section, Offcanvas } from "@/ui/components/private/";   
    import { UserForm, UserAccessForm } from "@/ui/widgets/private/form"
    import { hasPermission } from "@/utils";

    $: ({ users } = $page.props);

    let permissions ={
        create: hasPermission('user.create'),
        deactivate: hasPermission('user.deactivate'),
        authority : {
            update: hasPermission('user.update.authority')
        }
    }
 
    let offCanvasUserRef;
    let offCanvasUserAccessRef;
    let identifier;

    const requestDeactivateUser = (user) => {
        router.delete(`/painel/adms/user/${user}`);
    }
</script>

<Offcanvas bind:this={offCanvasUserRef} title="Cadastrar membro">
    <div slot="content" let:close>
        <UserForm {close}/>
    </div>
</Offcanvas>
<Offcanvas bind:this={offCanvasUserAccessRef} title="Configurações administrativas">
    <div slot="content" let:close>
        <UserAccessForm {identifier} {close}/>
    </div>
</Offcanvas>

{#if users && users.data.length > 0}
    <div class="flex justify-center gap-5 mb-5">
        {#if permissions.create}
            <button class="text-blue-skywave text-xl font-noto-sans font-bold italic uppercase cursor-pointer" on:click={()=> { 
                offCanvasUserRef.open()
            }}>
                Cadastrar membro
            </button>
            <span class="border-l border-neutral-aurora/30"></span>
        {/if}
        <button class="text-blue-skywave text-xl font-noto-sans font-bold italic uppercase">
            Agendar Atividade
        </button>
    </div>

    <Section {title}>
        <div class="mt-18 grid grid-cols-1 lg:grid-cols-4 gap-15 lg:gap-x-5 lg:gap-y-18">
            {#each users.data as item}
                {@const highestRole = item.roles.reduce((prev, current) => { return prev.weight > current.weight ? prev : current })}
                <article class="h-35 px-3 py-1 bg-blue-skywave rounded-sm relative">
                    <dl>
                        <dt class="text-neutral-aurora text-xl lg:text-2xl font-noto-sans font-bold italic uppercase">
                            {item.nickname}
                        </dt>
                        <dd class="text-neutral-aurora text-xs font-noto-sans font-semibold italic uppercase">
                            {item.name}
                        </dd>
                    </dl>
                    <img class="w-35 absolute right-0 bottom-0" src={item.avatar} alt="" aria-hidden="true"/>
                    <dl class="w-full flex justify-between items-end px-3 absolute left-0 bottom-2">
                        <dt class="rounded-full p-2 bg-neutral-aurora text-xs text-blue-indigo font-noto-sans font-bold uppercase italic">
                            {highestRole.label}
                        </dt>
                        <dd class="flex flex-wrap lg:flex-nowrap gap-2">
                            {#if permissions.authority.update}
                                <button aria-label="Definir permissões" class="w-8 h-8 bg-neutral-aurora rounded-md flex justify-center items-center font-noto-sans italic font-bold cursor-pointer"  on:click={()=> { 
                                    identifier = item.uuid;
                                    offCanvasUserAccessRef.open()
                                }}>
                                    <img src="/svg/default/crown.svg" alt="" aria-hidden="true" class="w-4 filter-blue-indigo" loading="lazy"/>
                                </button>
                            {/if}
                            <a href={`/painel/profile/${item.uuid}`} aria-label="Editar perfil" class="w-8 h-8 bg-neutral-aurora rounded-md flex justify-center items-center font-noto-sans italic font-bold cursor-pointer">
                                <img src="/svg/default/edit.svg" alt="" aria-hidden="true" class="w-4 filter-blue-indigo" loading="lazy"/>
                            </a>
                            {#if permissions.deactivate}
                                <button on:click={() => requestDeactivateUser(item.uuid)} aria-label="Desativar perfil" class="w-8 h-8 bg-neutral-aurora rounded-md flex justify-center items-center font-noto-sans italic font-bold cursor-pointer">
                                    <img src="/svg/default/trash.svg" alt="" aria-hidden="true" class="w-4 filter-red-crimson" loading="lazy"/>
                                </button>
                            {/if}
                        </dd>
                    </dl>
                </article>
            {/each}
        </div>
    </Section>
{/if}