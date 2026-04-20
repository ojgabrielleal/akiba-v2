<script>
    export let title;
    export let variant = "default";

    import { page, Link } from "@inertiajs/svelte";
    import { Section } from "@/ui/components/public";

    $: ({ reviews } = $page.props);
</script>

{#if variant === "latest"}
    <Section {title}>
        <div class="grid grid-cols-1 lg:grid-cols-5 gap-5">
            {#each reviews.data as review}
                <Link href={`review/${review.slug}`} class="h-60 bg-orange-sunset rounded-t-xl rounded-b-md relative">
                    <img 
                        src={review.cover} 
                        alt={review.title} 
                        class="w-full h-50 object-cover rounded-t-md" 
                    />
                    <div class="p-2">
                        <h1 class="text-lg text-center text-blue-night font-noto-sans font-extrabold italic uppercase line-clamp-1">
                            {review.title}
                        </h1>
                    </div>
                </Link>
            {/each}
        </div>
    </Section>
{/if}