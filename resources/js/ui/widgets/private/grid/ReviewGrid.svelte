<script>
    export let title;

    import { page } from "@inertiajs/svelte";
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
                    <div class="flex justify-end gap-5 absolute bottom-2 left-4 w-[calc(100%-2rem)]">
                        <div class="flex gap-3">
                            <a href={`/review/${item.slug}`} target="_blank" aria-label="Visualizar" class="cursor-pointer">
                                <img 
                                    src="/svg/eye.svg" 
                                    alt="" 
                                    aria-hidden="true" 
                                    class="w-5 filter-neutral-aurora" 
                                    loading="lazy" 
                                />
                            </a>
                            <a href={`/review/${item.uuid}`} aria-label="Editar" class="cursor-pointer disabled:opacity-50">
                                <img 
                                    src="/svg/edit.svg" 
                                    alt="" 
                                    aria-hidden="true" 
                                    class="w-4 filter-neutral-aurora" 
                                    loading="lazy" 
                                />
                            </a>
                        </div>
                    </div>
                </article>
            {/each}
        </div>
        <Pagination pages={reviews} />
    </Section>
{/if}
