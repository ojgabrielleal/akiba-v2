<script>
    export let title;

    import { page, Link } from "@inertiajs/svelte";
    import { Section, Pagination } from "@/ui/components/private";

    $: ({ reviews } = $page.props);
</script>

{#if reviews}
    <Section {title}>
        <div class="gap-6 grid grid-cols-1 lg:grid-cols-4 xl:grid-cols-5">
            {#each reviews.data as item}
                <article class="w-full h-56 rounded-lg p-4 relative bg-blue-skywave">
                    <div class="font-noto-sans text-lg text-neutral-aurora line-clamp-5 uppercase">
                        {item.title}
                    </div>
                    <div class="grid grid-cols-2 absolute bottom-2 left-4 w-[calc(100%-2rem)]">
                        <div class="flex items-center gap-2 font-noto-sans font-bold italic uppercase text-lg text-neutral-aurora truncate">
                            <img src="/svg/statistics.svg" alt="" aria-hidden="true" class="w-5 filter invert" loading="lazy" />
                            {item.views ?? 0}
                        </div>
                        <div class="flex gap-3 justify-end mt-1">
                            <a href={`/review/${item.slug}`} target="_blank" aria-label="Visualizar" class="cursor-pointer">
                                <img
                                    src="/svg/eye.svg"
                                    alt=""
                                    aria-hidden="true"
                                    class="w-5 filter invert"
                                    loading="lazy"
                                />
                            </a>
                            <Link href={`/panel/review/${item.uuid}`} aria-label="Editar" class="cursor-pointer">
                                <img
                                    src="/svg/edit.svg"
                                    alt=""
                                    aria-hidden="true"
                                    class="w-4 filter invert"
                                    loading="lazy"
                                />
                            </Link>
                        </div>
                    </div>
                </article>
            {/each}
        </div>
        <Pagination pages={reviews} />
    </Section>
{/if}
