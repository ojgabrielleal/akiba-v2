<script>
    export let title; 

    import { page, router } from "@inertiajs/svelte";
    import { Section } from "@/ui/components/private/";

    $: ({ activities } = $page.props);
</script>

<Section {title}>
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-4 ">
        {#each activities.data as item}  
            <article class='h-50 w-full shrink-0 rounded-lg p-4 relative bg-blue-skywave'>
                <div class='font-noto-sans font-black italic uppercase text-xl text-neutral-aurora'>
                    {item.author.nickname}
                </div>
                <div class="font-noto-sans text-sm text-neutral-aurora line-clamp-5 mt-1">
                    {item.content}
                </div>        
                <button
                    type="button"
                    aria-label="Editar alerta"
                    class="w-8 h-8 absolute bottom-3 right-4 flex justify-center items-center font-noto-sans italic font-bold cursor-pointer"
                >
                    <img src="/svg/default/edit.svg" alt="" aria-hidden="true" class="w-5 filter invert" loading="lazy"/>
                </button>
            </article>
        {/each}
    </div>
</Section>
