<script>
    export let title;

    import { page, Link } from "@inertiajs/svelte";
    import { Section, PageControls } from "@/ui/components/private";
    import { hasPermission } from "@/utils";

    $: ({ user, posts } = $page.props);

    let can = {
        update: hasPermission("post.update"),
        own: {
            update: hasPermission("post.update.own"),
        },
    };
</script>

{#if posts}
    <Section {title}>
        <div class="gap-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5">
            {#each posts.data as item}
                {@const canUpdate = can.update || (can.own.update && item.author.uuid === user.uuid)}
                <article class={["w-full h-56 rounded-lg p-4 relative",
                    { "bg-blue-skywave": item.type === "published" },
                    { "bg-orange-amber": item.type === "revision" },
                    { "bg-green-mint": item.type === "draft" },
                ]}>
                    <div class="font-noto-sans text-lg text-suspense-aurora line-clamp-5 uppercase">
                        {item.title}
                    </div>
                    <div class={["grid absolute bottom-2 left-4 w-[calc(100%-2rem)]",
                        { "grid-cols-3": item.type === "published" || item.type === "revision" },
                        { "grid-cols-2": item.type === "draft" },
                    ]}>
                        <div class="flex items-center gap-2 font-noto-sans font-bold italic uppercase text-lg text-suspense-aurora truncate">
                            <img
                                src="/svg/statistics.svg"
                                alt=""
                                aria-hidden="true"
                                class="w-5 filter invert"
                                loading="lazy"
                            />
                            {item.views ?? 0}
                        </div>
                        <div class="font-noto-sans font-bold italic uppercase text-lg text-suspense-aurora text-center truncate">
                            {item.author.nickname}
                        </div>
                        <div class="flex gap-3 justify-end mt-1">
                            <a
                                title=""
                                href={`/materia/${item.slug}`}
                                target="_blank"
                                aria-label="Visualizar"
                                class="cursor-pointer"
                            >
                                <img
                                    src="/svg/eye.svg"
                                    alt=""
                                    aria-hidden="true"
                                    class="w-5 filter invert"
                                    loading="lazy"
                                />
                            </a>
                            {#if canUpdate}
                                <Link
                                    title=""
                                    href={`/panel/post/${item.uuid}`}
                                    aria-label="Editar"
                                    class="cursor-pointer"
                                >
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
        <PageControls pages={posts} />
    </Section>
{/if}
