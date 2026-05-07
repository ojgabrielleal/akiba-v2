<script>
    export let title;
    export let variant;

    import { page } from "@inertiajs/svelte";
    import { Offcanvas, Section } from "@/ui/components/private/";
    import { CalendarForm } from "@/ui/widgets/private";
    import { hasPermission } from "@/utils";
    import { calendarTags } from "@/data";

    $: ({ calendar } = $page.props);

    let can = {
        create: hasPermission("calendar.create"),
        update: hasPermission("calendar.update"),
    };

    let offcanvasRef;
    let identifier;

    let week = [];

    $: if (calendar) {
        const days = ["dom", "seg", "ter", "qua", "qui", "sex", "sáb"];

        week = [];

        for (let i = 0; i < 7; i++) {
            week.push({
                day: days[i],
                events: calendar.data.filter((item) => item.day_of_week === i),
            });
        }
    }
</script>

<Offcanvas bind:this={offcanvasRef} title={identifier ? "Atualizar evento" : "Cadastrar evento"}>
    <div slot="content" let:close>
        <CalendarForm {identifier} {close} />
    </div>
</Offcanvas>

<Section {title}>
    {#if can.create && variant === "administration"}
        <div class="flex justify-center gap-5 mb-8">
            <button type="button" class="cursor-pointer bg-blue-skywave px-4 py-2 rounded-lg font-noto-sans font-bold italic uppercase text-suspense-aurora" on:click={() => { identifier = null; offcanvasRef.open(); }}>
                Cadastrar evento
            </button>
        </div>
    {/if}
    <div class="w-full overflow-x-auto pb-4">
        <div class="w-full min-w-[1280px] grid gap-2 grid-cols-7 overflow-auto">
            {#each calendarTags as item}
                <span class={`h-10 text-lg font-noto-sans font-bold uppercase italic rounded-lg flex justify-center items-center ${item.color} ${item.textcolor}`}>
                    {item.label}
                </span>
            {/each}
        </div>
        <div class="w-full min-w-[1280px] grid gap-2 mt-5 grid-cols-7 overflow-auto">
            {#each week as day}
                <div class="flex flex-col gap-2 w-full">
                    <div class="text-suspense-aurora text-lg font-noto-sans text-center font-bold uppercase italic">
                        {day.day}
                    </div>
                    {#each day.events as item}
                        <div class={["w-full rounded-lg pt-4 pl-4 pr-4 pb-3 mt-5",
                            { "bg-blue-skywave": item.type === "show" },
                            { "bg-purple-mystic": item.type === "live" },
                            { "bg-red-crimson": item.type === "video" },
                            { "bg-green-mint": item.type === "podcast" },
                            { "bg-suspense-honeycream": item.has_activity },
                        ]}>
                            <div class="flex events-center">
                                <div class={["w-full font-noto-sans text-2xl text-center uppercase",
                                    { "text-blue-night": item.has_activity },
                                    { "text-suspense-aurora": !item.has_activity },
                                ]}>
                                    {item.formated_hour}
                                </div>
                            </div>
                            <div class={["w-full font-noto-sans font-bold text-2xl text-center italic mt-6 mb-6",
                                { "text-blue-night": item.has_activity },
                                { "text-suspense-aurora": !item.has_activity },
                            ]}>
                                {item.has_activity
                                    ? item.activity.title
                                    : item.content}
                            </div>
                            <div class="flex justify-between items-center">
                                {#if can.update && variant === "administration"}
                                    <button
                                        type="button"
                                        aria-label=""
                                        class={["w-full cursor-pointer ",
                                        { "filter invert": !item.has_activity },
                                        { "filter invert-0": item.has_activity },
                                    ]}
                                    >
                                        <img
                                            src="/svg/edit.svg"
                                            alt="Editar"
                                            class="w-4"
                                        />
                                    </button>
                                {/if}
                                <button 
                                    type="button"
                                    aria-label=""
                                    class={["w-full font-noto-sans text-md text-end",
                                        { "text-blue-night": item.has_activity },
                                        { "text-suspense-aurora": !item.has_activity },
                                    ]}
                                    on:click={() => { 
                                        identifier = item.uuid; 
                                        offcanvasRef.open(); 
                                    }}
                                >
                                        
                                    {item.responsible.nickname}
                                </button>
                            </div>
                        </div>
                    {/each}
                </div>
            {/each}
        </div>
    </div>
</Section>
