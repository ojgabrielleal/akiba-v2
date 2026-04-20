<script>
    export let title;
    export let variant = "default";

    import { page, Link } from "@inertiajs/svelte";
    import { Section } from "@/ui/components/public";

    $: ({ posts } = $page.props);
</script>

{#if variant === "featured" && posts.data.length > 0}
    <Section {title}>
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-5 lg:mt-17">
            {#each posts.data as post}
                <Link href={`materia/${post.slug}`} class="h-60 lg:h-50 lg:p-4 bg-blue-skywave rounded-md relative overflow-hidden lg:overflow-visible flex flex-col lg:flex-row">
                    <img 
                        src={post.cover}
                        alt={post.title}
                        class="absolute inset-0 w-full h-full object-cover lg:static lg:w-auto lg:h-auto lg:hidden" 
                        loading="lazy"
                    />
                    <div class="absolute inset-0 bg-linear-to-t from-black to-transparent lg:hidden"></div>
                    <div class="relative z-10 p-3 mt-auto lg:mt-0 lg:p-0">
                        <h1 class="w-full lg:w-1/2 font-noto-sans font-bold text-white lg:text-neutral-aurora text-md lg:text-lg uppercase italic line-clamp-4 lg:line-clamp-5">
                            {post.title}
                        </h1>
                    </div>
                    <img 
                        src={post.image}
                        alt={post.title}
                        class="hidden lg:block absolute bottom-0 right-0 lg:w-55"
                        loading="lazy"
                    />
                </Link>
            {/each}
        </div>
    </Section>
{/if}