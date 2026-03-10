<script>
    export let title; 

    import { page } from "@inertiajs/svelte";
    import { Section } from "@/ui/components/private/";    

    $: ({ programs } = $page.props);

    $: console.log(programs);

    let days = {
        0: "Domingo",
        1: "Segunda",
        2: "Terça",
        3: "Quarta",
        4: "Quinta",
        5: "Sexta",
        6: "Sábado"
    }
</script>

<Section {title}>
    <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-4 gap-15 mt-10">
        {#each programs.data as program}
            <article class="w-full">
                <div>
                    <img class="w-40 mb-3" src={program.image} alt={program.name} loading="lazy"/>
                    <div class="w-full rounded-md py-3 px-4 bg-neutral-aurora relative mb-2">
                        <div class="text-blue-skywave text-md font-noto-sans uppercase">
                            <strong class="font-bold">Com:</strong>
                            {program.host.nickname}
                        </div>
                        <img class="w-36 aspect-square absolute right-0 bottom-0 object-cover object-top" src={program.host.avatar} alt={program.host.nickname}  loading="lazy">
                    </div>
                    {#each program.schedules as schedule}
                        <dl class="w-full rounded-md py-2 px-4 bg-neutral-aurora flex justify-between mb-2">
                            <dt class={['block text-black font-noto-san', 
                                {'text-md font-medium normal-case not-italic': !isPrivate}, 
                                {'text-md font-bold uppercase italic': isPrivate}
                            ]}>
                                {days[schedule.day]}
                            </dt>
                            <dd class="block text-black font-noto-sans uppercase">
                                {schedule.hour}
                            </dd>
                        </dl>
                    {/each}
                </div>
            </article>
        {/each}
    </div>
</Section>
