<script>
    import { useForm, page } from "@inertiajs/svelte";
    import { Section } from "@/ui/components/private/";
    import { hasPermission } from "@/utils";
    import iconsJson from "@/data/locution/icons.json";

    $: ({ programs } = $page.props);

    let can = {
        start: hasPermission("locution.start"),
        programs: {
            list: hasPermission("program.list"),
        },
    };

    let form = useForm({
        program: null,
        phrase: null,
        icon: null,
    });

    const submit = () => {
        $form.post(`/painel/locucao/locution/start/${$form.program}`, {
            preserveScroll: true,
        });
    };
</script>

<Section title="Meus Programas">
    <form on:submit|preventDefault={submit}>
        {#if can.programs.list && programs.data.length > 0}
            <div class="flex flex-wrap justify-center gap-15 lg:gap-x-0 lg:gap-y-15 0 mt-10 mb-20">
                {#each programs.data as item}
                    <button type="button" aria-label={item.name} class="flex-none cursor-pointer lg:px-10 lg:border-r-2 lg:border-neutral-aurora/10 lg:last:border-0" on:click={() => {
                        $form.program = item.uuid;
                    }}>
                        <img src={item.image} alt="" aria-hidden="true" loading="lazy" class={["w-60 transition duration-300 ease-in-out",
                            {"opacity-50 scale-90": $form.program === item.uuid},
                            {"opacity-100": $form.program !== item.uuid},
                        ]}/>
                    </button>
                {/each}
            </div>
        {/if}
        <div class="mb-8">
            <label class="text-orange-amber font-bold italic text-lg uppercase font-noto-sans block mb-1" for="phrase">
                Qual é a frase para esse programa?
            </label>
            <input
                id="phrase"
                type="text"
                name="phrase"
                class="w-full h-12 bg-neutral-aurora font-noto-sans rounded-lg outline-none pl-4"
                bind:value={$form.phrase}
            />
        </div>
        <div class="mb-15">
            <div class="text-orange-amber font-bold italic text-lg uppercase font-noto-sans block">
                Escolha um icone
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-9 gap-30 lg:gap-y-30 lg:gap-x-5 mt-28">
                {#each iconsJson as item, index}
                    <button type="button" aria-label={`Icon ${index}`} on:click={() => { $form.icon = item.url; }} class={["cursor-pointer w-[9.55rem] h-12 flex justify-end items-end rounded-lg bg-neutral-aurora transition duration-300 ease-in-out",
                        { "opacity-50 scale-90": $form.icon === item.url },
                        { "opacity-100": $form.icon !== item.url },
                    ]}>
                        <img
                            src={item.url}
                            alt=""
                            aria-hidden="true"
                            class="w-34 aspect-square"
                            loading="lazy"
                        />
                    </button>
                {/each}
            </div>
        </div>
        {#if can.start}
            <div class="flex justify-end">
                <button type="submit" class="cursor-pointer w-full lg:w-auto py-2 px-6 border-4 border-solid border-green-forest rounded-xl text-green-forest text-xl font-bold font-noto-sans italic uppercase">
                    Iniciar
                </button>
            </div>
        {/if}
    </form>
</Section>
