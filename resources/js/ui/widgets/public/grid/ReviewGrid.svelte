<script>
    export let title;
    export let variant = "home";

    import { page, Link } from "@inertiajs/svelte";
    import { Section } from "@/ui/components/public";

    $: ({ reviews } = $page.props);
</script>

{#if variant === "home" && reviews.data.length > 0}
    <Section {title}>
        <div class="grid grid-cols-1 lg:grid-cols-5 gap-5">
            {#each reviews.data as item}
                <Link href={`review/${item.slug}`} class="h-60 bg-orange-sunset rounded-t-xl rounded-b-md relative">
                    <img 
                        src={item.cover} 
                        alt={item.title} 
                        class="w-full h-50 object-cover rounded-t-md" 
                    />
                    <div class="p-2">
                        <h1 class="text-lg text-center text-blue-night font-noto-sans font-extrabold italic uppercase line-clamp-1">
                            {item.title}
                        </h1>
                    </div>
                </Link>
            {/each}
        </div>
    </Section>
{/if}