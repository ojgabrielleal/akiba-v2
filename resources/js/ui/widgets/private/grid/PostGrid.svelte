<script>
    export let title;

    import { page, router, Link } from "@inertiajs/svelte";
    import { Section, Pagination } from "@/ui/components/private";
    import { hasPermission } from "@/utils";

    $: ({ user, posts } = $page.props);

    let can = {
        update: hasPermission("post.update"),
        deactivate: hasPermission("post.deactivate"),
        own: {
            update: hasPermission("post.update.own"),
        },
    };

    const requestDeactivatePost = (post) => {
        router.delete(`/panel/dashboard/post/${post}`, {}, {
            preserveScroll: true,
        });
    };
</script>

{#if posts}
    <Section {title}>
        <div class="gap-5 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5">
            {#each posts.data as item}
                {@const canUpdate = can.update || (can.own.update && item.author?.uuid === user?.uuid)}
                <article class="w-full h-55 bg-blue-ocean rounded-lg overflow-hidden relative">
                    <div class="p-2">
                          <div class="font-noto-sans text-lg text-suspense-aurora line-clamp-5 uppercase">
                            {item.title}
                        </div>
                    </div>
                    <div class={["grid grid-cols-[0.4fr_1fr_0.6fr] items-center absolute bottom-0 w-full py-1 px-3",
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
                        <div class="mt-[0.3rem] w-full font-noto-sans font-bold italic uppercase text-sm text-suspense-aurora text-center truncate">
                            {item.author.nickname}
                        </div>
                        <div class="flex gap-1 justify-end mt-1">
                            {#if can.deactivate}
                                <button
                                    type="button"
                                    aria-label="Remover"
                                    class="w-7 h-7 bg-blue-night rounded-lg flex items-center justify-center cursor-pointer"
                                    on:click={() => requestDeactivatePost(item.uuid)}
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
                            {#if canUpdate}
                                <Link
                                    title=""
                                    href={`/panel/post/${item.uuid}`}
                                    aria-label="Editar"
                                    class="w-7 h-7 bg-blue-night rounded-lg flex items-center justify-center cursor-pointer"
                                >
                                    <img
                                        src="/svg/edit.svg"
                                        alt=""
                                        aria-hidden="true"
                                        class="w-4 filter-orange-citric"
                                        loading="lazy"
                                    />
                                </Link>
                            {/if}
                        </div>
                    </div>
                </article>
            {/each}
        </div>
        <Pagination pages={posts} only={["posts"]} />
    </Section>
{/if}
