<script>
    export let title;

    import { page } from "@inertiajs/svelte";
    import { Section } from "@/ui/components/public";

    $: ({ posts } = $page.props);
</script>

<Section {title}>
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5 lg:mt-15">
        {#each posts.data as post}
            <div class="h-40 p-4 bg-blue-skywave rounded-sm relative">
                <h1 class="w-3/5 font-noto-sans font-bold text-neutral-aurora text-md lg:text-xl uppercase italic line-clamp-5 lg:line-clamp-4">
                    {post.title}
                </h1>
                <img 
                    src={post.image}
                    alt=""
                    aria-hidden="true"
                    class="absolute bottom-0 right-1 w-40 lg:w-50"
                    loading="lazy"
                />
            </div>
        {/each}
    </div>
</Section>