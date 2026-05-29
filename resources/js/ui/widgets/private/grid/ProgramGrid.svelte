<script>
    export let title;

    import { router, page } from "@inertiajs/svelte";
    import { Offcanvas, Section, Tooltip } from "@/ui/components/private/";
    import { ProgramForm } from "@/ui/widgets/private";
    import { hasPermission } from "@/utils";

    $: ({ programs } = $page.props);

    let can = {
        create: hasPermission("program.create"),
        update: hasPermission("program.update"),
        deactivate: hasPermission("program.deactivate"),
    };

    let actions = [
        {
            title: "Cadastrar",
            icon: "/svg/plus.svg",
            onClick: () => null
        },
    ];

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
            <div class="cursor-pointer flex items-center gap-1 text-neutral-gray text-lg font-noto-sans font-extrabold italic uppercase hover:text-blue-skywave group/item">
                <img 
                    src="/svg/onair.svg"
                    alt=""
                    class="w-5 filter-neutral-gray group-hover/item:filter-blue-skywave"
                    loading="lazy"
                />
                Ao vivo
            </div>
            <div class="cursor-pointer flex items-center gap-1 text-neutral-gray text-lg font-noto-sans font-extrabold italic uppercase hover:text-blue-skywave group/item">
                <img 
                    src="/svg/bestAvaliable.svg"
                    alt=""
                    class="w-5 filter-neutral-gray group-hover/item:filter-blue-skywave"
                    loading="lazy"
                />
                Gravados
            </div>
            <div class="cursor-pointer flex items-center gap-1 text-neutral-gray text-lg font-noto-sans font-extrabold italic uppercase hover:text-blue-skywave group/item">
                <img 
                    src="/svg/disc.svg"
                    alt=""
                    class="w-5 filter-neutral-gray group-hover/item:filter-blue-skywave"
                    loading="lazy"
                />
                Automáticos
            </div>
        </div>
        <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-4 gap-5 mt-10">
            {#each programs.data as program}
                {#if program.type === "private"}
                    <article class="w-full">
                        <div>
                            <img
                                class="w-40 mb-3"
                                src={program.image}
                                alt={program.name}
                                loading="lazy"
                            />
                            <div class="w-full h-13 flex items-center rounded-md px-3 bg-suspense-aurora relative mb-2">
                                <div class="flex items-center gap-1 text-blue-ocean text-sm font-noto-sans font-extrabold italic uppercase">
                                    <strong class="not-italic font-normal text-[0.7rem]">
                                        Com:
                                    </strong>
                                    {program.host.nickname}
                                </div>
                                <div class="z-10 absolute bottom-2 right-22  bg-green-mint px-2 rounded-xl float-end text-center text-[0.6rem] text-suspense-aurora font-noto-sans font-extrabold italic uppercase">
                                    Humano
                                </div>
                                <div class="flex gap-1 absolute bottom-3 right-4 z-10">
                                <Tooltip>
                                    <button
                                        type="button"
                                        aria-label="Confirmar"
                                        class="w-7 h-7 bg-blue-marinho rounded-md flex justify-center items-center font-noto-sans italic font-extrabold cursor-pointer"
                                        on:click={() => requestDeactivateProgram(program.uuid)}
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
                                            identifier = program.id;
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
                                    class="w-36 aspect-square absolute right-0 bottom-0 object-cover object-top "
                                    src={program.host.avatar}
                                    alt={program.host.nickname}
                                    loading="lazy"
                                />
                            </div>
                            {#each program.schedules as schedule}
                                <dl class="w-full rounded-md py-2 px-4 bg-suspense-aurora flex justify-between mb-2">
                                    <dt class="block text-blue-marinho text-md font-noto-sans italic uppercase font-extrabold">
                                        {schedule.day}
                                    </dt>
                                    <dd class="block text-blue-marinho text-md font-noto-sans italic uppercase font-extrabold">
                                        {schedule.hour}
                                    </dd>
                                </dl>
                            {/each}
                        </div>
                    </article>
                {/if}
            {/each}
        </div>
    </Section>
{/if}
