<script>
    export let title;

    import { page } from "@inertiajs/svelte";
    import { Offcanvas, Section } from "@/ui/components/private/";
    import { CalendarForm } from "@/ui/widgets/private/form";
    import { hasPermission } from "@/utils";
    import tag from "@/data/calendar/tag.json";

    $: ({ calendar } = $page.props);

    let can = {
        create: hasPermission("calendar.create"),
        update: hasPermission("calendar.update"),
    };

    let week = [];

    $: if (calendar) {
        const days = ["dom", "seg", "ter", "qua", "qui", "sex", "sáb"];

        week = []; 

        for (let i = 0; i < 7; i++) {
            week.push({
                day: days[i],
                events: calendar.data.filter(
                    (item) => item.day_of_week === i,
                ),
            });
        }
    }

    let offcanvasRef;
    let identifier;
</script>


<Offcanvas bind:this={offcanvasRef} title="Atualizar atividade">
    <div slot="content" let:close>
        <CalendarForm {identifier} {close} />
    </div>
</Offcanvas>

<Section {title}>
    {#if can.create}
        <div class="flex justify-center gap-5 mb-8">
            <button class="cursor-pointer bg-blue-skywave px-4 py-2 rounded-lg font-noto-sans font-bold italic uppercase text-neutral-aurora" on:click={()=>{
                identifier = null;
                offcanvasRef.open()
            }}>
                Cadastrar evento
            </button>
        </div>
    {/if}
    <div class="w-full grid gap-5 grid-cols-1 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 2xl:grid-cols-7">
        {#each tag as item}
            <span class={`h-10 text-lg font-noto-sans font-bold uppercase italic rounded-lg flex justify-center items-center ${item.color} ${item.textcolor}`}>
                {item.label}
            </span>
        {/each}
    </div>
    <div class="w-full grid gap-5 mt-5 grid-cols-1 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 2xl:grid-cols-7">
        {#each week as day}
            <div class="flex flex-col gap-2 w-full">
                <div class="text-neutral-aurora text-lg font-noto-sans text-center font-bold uppercase italic">
                    {day.day}
                </div>
                {#each day.events as item}
                    <div class={["w-full 2xl:w-[12.7rem] bg-blue-skywave rounded-lg pt-4 pl-4 pr-4 pb-3 mt-5",
                        { "bg-blue-skywave": item.type === "show" },
                        { "bg-purple-mystic": item.type === "live" },
                        { "bg-red-crimson": item.type === "video" },
                        { "bg-green-forest": item.type === "podcast" },
                        { "bg-neutral-honeycream": item.has_activity },
                    ]}>
                        <div class="flex events-center">
                            <div class={["w-full font-noto-sans text-2xl text-center uppercase",
                                { "text-blue-midnight": item.has_activity },
                                { "text-neutral-aurora": !item.has_activity },
                            ]}>
                                {item.formated_hour}
                            </div>
                        </div>
                        <div class={["w-full font-noto-sans font-bold text-2xl text-center italic mt-6 mb-6",
                            { "text-blue-midnight": item.has_activity },
                            { "text-neutral-aurora": !item.has_activity },
                        ]}>
                            {item.has_activity ? item.activity.title : item.content}
                        </div>
                        <div class="flex justify-between items-center">
                            {#if can.update}
                                <button class={["w-full cursor-pointer ",
                                    { "filter invert": !item.has_activity },
                                    { "filter invert-0": item.has_activity },
                                ]} on:click={()=>{identifier = item.uuid; offcanvasRef.open()}}>
                                    <img src="/svg/default/edit.svg" alt="Editar" class="w-4" />
                                </button>
                            {/if}
                            <div class={["w-full font-noto-sans text-md text-end ",
                                { "text-blue-midnight": item.has_activity },
                                { "text-neutral-aurora": !item.has_activity },
                            ]}>
                                {item.responsible.nickname}
                            </div>
                        </div>
                    </div>
                {/each}
            </div>
        {/each}
    </div>
</Section>
