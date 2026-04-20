<script>
    export let title;

    import { page, Link } from "@inertiajs/svelte";
    import { Section, Pagination } from "@/ui/components/private";
    import { hasPermission } from "@/utils";

    $: ({ user, posts } = $page.props);

    $:console.log(posts);

    let can = {
        update: hasPermission("post.update"),
        own: {
            update: hasPermission("post.update.own"),
        },
    };
</script>

{#if posts}
    <Section {title}>
        <div class="gap-6 grid grid-cols-1 lg:grid-cols-4 xl:grid-cols-5">
            {#each posts.data as item}
                {@const canUpdate = can.update || (can.own.update && item.author.uuid === user.uuid)}
                <article class={["w-full h-56 rounded-lg p-4 relative",
                    { "bg-blue-skywave": item.type === "published" },
                    { "bg-orange-amber": item.type === "revision" },
                    { "bg-green-forest": item.type === "draft" },
                ]}>
                    <div class="font-noto-sans text-lg text-neutral-aurora line-clamp-5 uppercase">
                        {item.title}
                    </div>
                    <div class="grid grid-cols-3 absolute bottom-2 left-4 w-[calc(100%-2rem)]">
                        <div class="flex items-center gap-2 font-noto-sans font-bold italic uppercase text-lg text-neutral-aurora truncate">
                            <img src="/svg/statistics.svg" alt="" aria-hidden="true" class="w-5 filter invert" loading="lazy" />
                            {item.views}
                        </div>
                        <div class="font-noto-sans font-bold italic uppercase text-lg text-neutral-aurora truncate">
                            {item.author.nickname}
                        </div>
                        <div class="flex gap-3 justify-end mt-1">
                            <a href={`/materia/${item.slug}`} target="_blank" aria-label="Visualizar" class="cursor-pointer">
                                <img
                                    src="/svg/eye.svg"
                                    alt=""
                                    aria-hidden="true"
                                    class="w-5 filter invert"
                                    loading="lazy"
                                />
                            </a>
                            {#if canUpdate}
                                <Link href={`/panel/post/${item.uuid}`} aria-label="Editar" class="cursor-pointer">
                                    <img
                                        src="/svg/edit.svg"
                                        alt=""
                                        aria-hidden="true"
                                        class="w-4 filter invert"
                                        loading="lazy"
                                    />
                                </Link>
                            {/if}
                        </div>
                    </div>
                </article>
            {/each}
        </div>
        <Pagination pages={posts} />
    </Section>
{/if}
