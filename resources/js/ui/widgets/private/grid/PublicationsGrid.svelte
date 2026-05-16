<script>
    export let title;
    export let show;
    export let model;

    import { page, router, Link } from "@inertiajs/svelte";
    import { Section, ButtonPagination } from "@/ui/components/private";
    import { hasPermission } from "@/utils";

    $: ({ publications } = $page.props);

    let can = {
        update: hasPermission("publication.update"),
        deactivate: hasPermission("publication.deactivate"),
    };

    const requestDeactivatePublication = (publication) => {
        router.delete(`/panel/publication/`, {
            data: {
                model: publication.publication_type ?? "post",
                uuid: publication.uuid,
            },
            preserveScroll: true,
        });
    };
</script>

{#if publications}
    <Section {title}>
        <div class="gap-5 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5">
            {#each publications.data as item}
                <article class="w-full h-53 bg-blue-ocean rounded-lg overflow-hidden relative ">
                    <div class="p-4">
                          <div class="font-noto-sans text-lg text-suspense-aurora line-clamp-4 uppercase">
                            {item.title}
                        </div>
                    </div>
                    <div class={["grid grid-cols-[0.4fr_1fr_0.6fr] items-center absolute bottom-0 w-full py-1 px-4",
                        { "bg-orange-amber": item.type === "draft" },
                        { "bg-blue-cerulean": item.type === "published" },
                        { "bg-green-mint": item.type === "revision" },
                    ]}>
                        <div class="flex items-center gap-2 font-noto-sans font-bold italic uppercase text-md text-suspense-aurora truncate">
                            <img
                                src="/svg/eye.svg"
                                alt=""
                                aria-hidden="true"
                                class="w-4 filter invert"
                                loading="lazy"
                            />
                            {item.views ?? 0}
                        </div>
                        <div class="mt-[0.1rem] w-full font-noto-sans font-bold italic uppercase text-sm text-suspense-aurora text-center truncate">
                            {item.author.nickname}
                        </div>
                        <div class="flex gap-1 justify-end mt-1">
                            {#if can.deactivate}
                                <button
                                    type="button"
                                    aria-label="Remover"
                                    class="w-7 h-7 bg-blue-night rounded-lg flex items-center justify-center cursor-pointer"
                                    on:click={() => requestDeactivatePublication(item)}
                                >
                                    <img
                                        src="/svg/trash.svg"
                                        alt=""
                                        aria-hidden="true"
                                        class="w-4 filter-red-crimson"
                                        loading="lazy"
                                    />
                                </button>
                            {/if}
                            {#if can.update}
                                <button
                                    title=""
                                    aria-label="Editar"
                                    class="w-7 h-7 bg-blue-night rounded-lg flex items-center justify-center cursor-pointer"
                                    on:click={() => {
                                        show = true;
                                        model = item.publication_type;
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
                            {/if}
                        </div>
                    </div>
                </article>
            {/each}
        </div>
        <ButtonPagination pages={publications} only={["publications"]} />
    </Section>
{/if}
