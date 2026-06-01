<script>
    export let title;

    import { router, page } from "@inertiajs/svelte";
    import { Offcanvas, Section, Tooltip } from "@/ui/components/private/";
    import { ProgramForm } from "@/ui/widgets/private";
    import { programPermissions } from "@/utils";

    $: ({ programs, programmed } = $page.props);

    let can = programPermissions();

    let actions = [
        {
            title: "Cadastrar",
            icon: "/svg/plus.svg",
            onClick: () => null
        },
    ];

    $: filters = [
        {
            title: "Ao vivo",
            type: "live",
            icon: "/svg/onair.svg",
            object: programs.data,
        },
        {
            title: "Gravados",
            type: "scheduled",
            icon: "/svg/bestAvaliable.svg",
            object: programmed.data.scheduled
        },
        {
            title: "Playlist",
            type: "playlist",
            icon: "/svg/disc.svg",
            object: programmed.data.playlist
        },
    ];

    $: show = {
        type: 'live',
        object: programs?.data ?? []
    };

    const resolveProgram = (item) => item.program ?? item ?? {};
    const resolveHost = (item) => resolveProgram(item).host ?? {};
    const resolveSchedules = (item) => resolveProgram(item).schedules ?? [];
    const isProgrammed = (item) => item?.start_at || item?.finish_at;

    let offcanvasRef;
    let identifier;

    const requestDeactivateProgram = (program) => {
        router.delete(`/panel/radio/program/${program}`, {}, {
            preserveScroll: true,
            preserveState: true,
        });
    };
</script>

<Offcanvas bind:this={offcanvasRef} title={identifier ? "Atualizar programa" : "Cadastrar programa"}>
    <div slot="content" let:close>
        <ProgramForm {identifier} {close} />
    </div>
</Offcanvas>

{#if programs}
    <Section {title} {actions}>
        <div class="flex justify-center gap-8 mt-5">
            {#each filters as item}
                <button
                    type="button"
                    class={["cursor-pointer flex items-center gap-1 text-lg font-noto-sans font-extrabold italic uppercase hover:text-blue-skywave group/item", 
                        {"text-blue-skywave": show.type === item.type},
                        {"text-neutral-gray": show.type !== item.type}
                    ]}
                    on:click={() => {
                        show.type = item.type; 
                        show.object = item.object
                    }}
                >
                    <img
                        src={item.icon}
                        alt=""
                        class={["w-5 group-hover/item:filter-blue-skywave", 
                            {"filter-blue-skywave": show.type === item.type},
                            {"filter-neutral-gray": show.type !== item.type}
                        ]}
                        loading="lazy"
                    />
                    {item.title}
                </button>
            {/each}
        </div>
        <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-4 gap-5 mt-10">
            {#each show.object ?? [] as item}
                <article class="w-full">
                    <div>
                        <img
                            class="w-40 mb-3"
                            src={resolveProgram(item).image}
                            alt={resolveProgram(item).name}
                            loading="lazy"
                        />
                        <div class="w-full h-13 flex items-center rounded-md px-3 bg-suspense-aurora relative mb-2">
                            <div class="w-36 min-w-0 flex items-center gap-1 text-blue-ocean text-sm font-noto-sans font-extrabold italic uppercase">
                                <span class="shrink-0 not-italic font-normal text-[0.7rem]">
                                    Com:
                                </span>
                                <span class="block min-w-0 flex-1 truncate">
                                    {resolveHost(item).nickname}
                                </span>
                            </div>
                            <div class={["z-10 absolute bottom-2 right-22 px-2 rounded-xl float-end text-center text-[0.6rem] text-suspense-aurora font-noto-sans font-extrabold italic uppercase",
                                {'bg-neutral-gray': resolveHost(item).is_virtual},
                                {'bg-green-mint': !resolveHost(item).is_virtual}
                            ]}>
                                {resolveHost(item).is_virtual ? "Robô" : 'Humano'}
                            </div>
                            <div class="flex gap-1 absolute bottom-3 right-4 z-10">
                                <Tooltip>
                                    <button
                                        type="button"
                                        aria-label="Remover"
                                        class="w-7 h-7 bg-blue-marinho rounded-md flex justify-center items-center font-noto-sans italic font-extrabold cursor-pointer"
                                        on:click={() => requestDeactivateProgram(item.uuid)}
                                    >
                                        <img
                                            src="/svg/trash.svg"
                                            alt=""
                                            aria-hidden="true"
                                            class="w-4 filter-red-crimson"
                                            loading="lazy"
                                        />
                                    </button>
                                    <div slot="content">
                                        Desativar
                                    </div>
                                </Tooltip>
                                <Tooltip>
                                    <button
                                        type="button"
                                        aria-label="Atualizar"
                                        class="w-7 h-7 bg-blue-marinho rounded-md flex justify-center items-center font-noto-sans italic font-extrabold cursor-pointer"
                                        on:click={() => {
                                            identifier = item.id;
                                            offcanvasRef.open();
                                        }}
                                    >
                                        <img
                                            src="/svg/edit.svg"
                                            alt=""
                                            aria-hidden="true"
                                            class="w-4 filter-orange-citric"
                                            loading="lazy"
                                        />
                                    </button>
                                    <div slot="content">
                                        Atualizar
                                    </div>
                                </Tooltip>
                            </div>
                            <img
                                class="w-36 aspect-square absolute right-0 bottom-0 object-cover object-top"
                                src={resolveHost(item).avatar}
                                alt={resolveHost(item).nickname}
                                loading="lazy"
                            />
                        </div>
                        {#if isProgrammed(item)}
                            <dl class="w-full rounded-md py-2 px-4 bg-suspense-aurora flex justify-between mb-2">
                                <dt class="block text-blue-marinho text-sm font-noto-sans italic uppercase font-extrabold">
                                    Começa em:
                                </dt>
                                <dd class="block text-blue-marinho text-sm font-noto-sans italic uppercase font-extrabold">
                                    {item.start_at}
                                </dd>
                            </dl>
                            <dl class="w-full rounded-md py-2 px-4 bg-suspense-aurora flex justify-between mb-2">
                                <dt class="block text-blue-marinho text-sm font-noto-sans italic uppercase font-extrabold">
                                    Termina em:
                                </dt>
                                <dd class="block text-blue-marinho text-sm font-noto-sans italic uppercase font-extrabold">
                                    {item.finish_at}
                                </dd>
                            </dl>
                        {:else}
                            {#each resolveSchedules(item) as schedule}
                                <dl class="w-full rounded-md py-2 px-4 bg-suspense-aurora flex justify-between mb-2">
                                    <dt class="block text-blue-marinho text-sm font-noto-sans italic uppercase font-extrabold">
                                        {schedule.day}
                                    </dt>
                                    <dd class="block text-blue-marinho text-sm font-noto-sans italic uppercase font-extrabold">
                                        {schedule.hour}
                                    </dd>
                                </dl>
                            {/each}
                        {/if}
                    </div>
                </article>
            {/each}
        </div>
    </Section>
{/if}
