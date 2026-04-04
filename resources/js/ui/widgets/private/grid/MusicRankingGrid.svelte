<script>
    export let title;

    import { page, router } from "@inertiajs/svelte";
    import { Section } from "@/ui/components/private/";
    import { Preview } from "@/ui/components/private";
    import { hasPermission } from "@/utils";

    $: ({ musicranking } = $page.props);

    let can = {
        update: hasPermission("music.ranking.update"),
        set: hasPermission("music.set.ranking"),
    };

    const submit = (event, uuid) => {
        const formData = new FormData();
        formData.append("_method", "PATCH");
        formData.append("image_ranking", event.target.files[0]);

        router.post(`/painel/radio/music-ranking/${uuid}`, formData, {
            preserveScroll: true,
            forceFormData: true,
        });
    };

    const setRanking = () => {
        router.post(
            "/painel/radio/music-ranking",
            {},
            {
                preserveScroll: true,
            },
        );
    };
</script>

{#if musicranking}
    <Section {title}>
        <div class="flex flex-col gap-5">
            {#if musicranking.data.length >= 3}
                {#each musicranking.data as item, index}
                    <article
                        class="flex flex-wrap lg:flex-nowrap items-center gap-5"
                    >
                        <div class="flex items-center gap-5">
                            {#if can.update}
                                <Preview
                                    standard="w-24 h-24 rounded-lg"
                                    view="w-24 h-24"
                                    src={item.ranking.image ?? "https://placehold.co/500x500?text=Rede+Akiba"}
                                    oninput={(event) =>
                                        submit(event, item.uuid)}
                                />
                            {:else}
                                      <img
                                    class="w-24 h-24 rounded-lg"
                                    src={item.ranking.image ?? "https://placehold.co/500x500?text=Rede+Akiba"}
                                    alt={item.name}
                                />
                            {/if}
                            <strong
                                class="text-neutral-aurora text-6xl font-noto-sans font-bold uppercase italic"
                            >
                                #{index + 1}
                            </strong>
                        </div>
                        <div
                            class="text-neutral-aurora font-noto-sans uppercase"
                        >
                            {item.name} - {item.type} - {item.production} - {item.artist}
                        </div>
                    </article>
                {/each}
            {:else}
                <article
                    class="flex flex-wrap lg:flex-nowrap items-center gap-5 opacity-50 pointer-events-none"
                >
                    <Preview
                        standard="w-[6rem] h-[6rem] rounded-lg"
                        view="w-[6rem] h-[6rem]"
                    />
                    <div class="flex items-center gap-5">
                        <strong
                            class="text-neutral-aurora text-6xl font-noto-sans font-bold uppercase italic"
                        >
                            #1
                        </strong>
                    </div>
                    <div class="text-neutral-aurora font-noto-sans uppercase">
                        Guren no Yumiya - OP - Attack on Titan - Linked Horizon
                    </div>
                </article>
                <article
                    class="flex flex-wrap lg:flex-nowrap items-center gap-5 opacity-50 pointer-events-none"
                >
                    <Preview
                        standard="w-[6rem] h-[6rem] rounded-lg"
                        view="w-[6rem] h-[6rem]"
                    />
                    <div class="flex items-center gap-5">
                        <strong
                            class="text-neutral-aurora text-6xl font-noto-sans font-bold uppercase italic"
                        >
                            #2
                        </strong>
                    </div>
                    <div class="text-neutral-aurora font-noto-sans uppercase">
                        Blue Bird - OP - Naruto Shippuden - Ikimono Gakari
                    </div>
                </article>
                <article
                    class="flex flex-wrap lg:flex-nowrap items-center gap-5 opacity-50 pointer-events-none"
                >
                    <Preview
                        standard="w-[6rem] h-[6rem] rounded-lg"
                        view="w-[6rem] h-[6rem]"
                    />
                    <div class="flex items-center gap-5">
                        <strong
                            class="text-neutral-aurora text-6xl font-noto-sans font-bold uppercase italic"
                        >
                            #3
                        </strong>
                    </div>
                    <div class="text-neutral-aurora font-noto-sans uppercase">
                        My Dearest - OP - Guilty Crown - Supercell
                    </div>
                </article>
            {/if}
        </div>
        {#if musicranking.data.length >= 3 && can.set}
            <div class="flex justify-end mt-5">
                <button
                    on:click={() => setRanking()}
                    class="cursor-pointer bg-blue-skywave px-4 py-2 rounded-md text-neutral-aurora font-noto-sans font-bold uppercase italic disabled:opacity-50 disabled:pointer-events-none"
                >
                    Atualizar ranking
                </button>
            </div>
        {/if}
    </Section>
{/if}
