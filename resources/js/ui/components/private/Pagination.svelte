<script>
    export let pages;

    import { router } from "@inertiajs/svelte";

    const pagination = (page) => {
        router.get("", { page: page }, {
            preserveScroll: true,
            preserveState: true,
        });
    };
</script>

{#if pages?.meta && pages.meta.last_page > 1}
    <div class="flex justify-center mt-10">
        <div class="flex gap-5">
            {#if pages.meta.current_page > 1}
                <button class="cursor-pointer w-full lg:w-auto py-2 px-6 border-4 border-solid border-orange-amber rounded-xl text-orange-amber text-xl italic uppercase font-noto-sans font-bold" on:click={() => {
                    pagination(pages.meta.current_page - 1)
                }}>
                    Voltar uma página
                </button>
            {/if}
            {#if pages.meta.current_page < pages.meta.last_page}
                <button class="cursor-pointer w-full lg:w-auto py-2 px-6 border-4 border-solid border-blue-skywave rounded-xl text-blue-skywave text-xl italic uppercase font-noto-sans font-bold" on:click={() => {
                    pagination(pages.meta.current_page + 1)
                }}>
                    Próxima página
                </button>
            {/if}
        </div>
    </div>
{/if}
