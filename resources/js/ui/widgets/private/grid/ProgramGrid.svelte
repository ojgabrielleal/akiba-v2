<script>
    export let title;

    import { router, page } from "@inertiajs/svelte";
    import { Offcanvas, Section } from "@/ui/components/private/";
    import { ProgramForm } from "@/ui/widgets/private";
    import { hasPermission } from "@/utils";

    $: ({ programs } = $page.props);

    $:console.log(programs)

    let can = {
        create: hasPermission("program.create"),
        update: hasPermission("program.update"),
        deactivate: hasPermission("program.deactivate"),
    };

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
    <Section {title}>
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
                            <div class="w-full h-15 flex items-center rounded-md px-4 bg-suspense-aurora relative mb-2">
                                <div class="text-blue-ocean text-sm font-noto-sans font-extrabold italic uppercase">
                                    <strong class="font-semibold">
                                        Com:
                                    </strong>
                                    {program.host.nickname}
                                </div>
                                <img
                                    class="w-36 aspect-square absolute right-0 bottom-0 object-cover object-top"
                                    src={program.host.avatar}
                                    alt={program.host.nickname}
                                    loading="lazy"
                                />
                            </div>
                            {#each program.schedules as schedule}
                                <dl class="w-full rounded-md py-2 px-4 bg-suspense-aurora flex justify-between mb-2">
                                    <dt class="block text-black text-md font-noto-sans italic uppercase font-bold">
                                        {schedule.day}
                                    </dt>
                                    <dd class="block text-black font-noto-sans uppercase">
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
