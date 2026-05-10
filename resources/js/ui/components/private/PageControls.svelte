<script>
    export let pages;
    export let mode = "pagination";
    export let loadingLabel = "Carregando...";
    export let rootMargin = "240px";
    export let only = [];
    export let pageName = "page";
    export let preserveUrl = false;

    import { afterUpdate, onDestroy } from "svelte";
    import { router } from "@inertiajs/svelte";
    import Tooltip from "./Tooltip.svelte";

    let sentinel;
    let observer;
    let isLoading = false;
    let pageHistory = [];

    $: nextUrl = pages?.links?.next ?? pages?.next_page_url ?? null;
    $: previousUrl = pages?.links?.prev ?? pages?.prev_page_url ?? null;
    $: hasNextPage = Boolean(nextUrl) || (
        pages?.meta?.current_page &&
        pages?.meta?.last_page &&
        pages.meta.current_page < pages.meta.last_page
    );

    $: if ((mode === "button" || mode === "infinite") && pages?.meta?.current_page === 1) {
        pageHistory = [pages];
    }

    const visit = (url, data = {}) => {
        if (isLoading) return;

        const previousData = pages?.data ?? [];

        isLoading = true;

        router.visit(url, {
            data,
            preserveScroll: true,
            preserveState: true,
            preserveUrl,
            only,
            onSuccess: (page) => {
                if ((mode === "button" || mode === "infinite") && only.length === 1) {
                    const appendProp = only[0];
                    const nextPage = page.props[appendProp];
                    const nextHistory = [...pageHistory, nextPage];

                    router.replaceProp(appendProp, {
                        ...nextPage,
                        data: [...previousData, ...(nextPage?.data ?? [])],
                    });

                    pageHistory = nextHistory;
                }
            },
            onFinish: () => {
                isLoading = false;
            },
        });
    };

    const loadNextPage = () => {
        if (nextUrl) {
            visit(nextUrl);
            return;
        }

        if (pages?.meta?.current_page && pages?.meta?.current_page < pages?.meta?.last_page) {
            visit("", { [pageName]: pages.meta.current_page + 1 });
        }
    };

    const resetPages = () => {
        if (only.length !== 1 || pageHistory.length <= 1) return;

        pageHistory = pageHistory.slice(0, -1);

        router.replaceProp(only[0], {
            ...pageHistory.at(-1),
            data: pageHistory.flatMap((page) => page?.data ?? []),
        });
    };

    const observeSentinel = () => {
        observer?.disconnect();

        if (mode !== "infinite" || !hasNextPage || !sentinel) return;

        observer = new IntersectionObserver((entries) => {
            if (entries.some((entry) => entry.isIntersecting)) {
                loadNextPage();
            }
        }, { rootMargin });

        observer.observe(sentinel);
    };

    afterUpdate(observeSentinel);

    onDestroy(() => {
        observer?.disconnect();
    });
</script>

{#if mode === "button" && (hasNextPage || pageHistory.length > 1)}
    <div class="flex justify-center mt-2">
        <div class="flex items-center justify-center gap-4">
            {#if pageHistory.length > 1}
                <Tooltip>
                    <button
                        aria-label="Mostrar menos"
                        type="button"
                        class="cursor-pointer flex items-center justify-center disabled:cursor-not-allowed disabled:opacity-50"
                        disabled={isLoading}
                        on:click={resetPages}
                    >
                        <img
                            src="/svg/chevron-up.svg"
                            alt=""
                            aria-hidden="true"
                            class="w-15 filter-orange-citric"
                            loading="lazy"
                        />
                    </button>
                    <span slot="content">
                        Mostrar menos
                    </span>
                </Tooltip>
            {/if}
            {#if hasNextPage}
                <Tooltip>
                    <button
                        aria-label="Mostrar mais"
                        type="button"
                        class="cursor-pointer flex items-center justify-center disabled:cursor-not-allowed disabled:opacity-50"
                        disabled={isLoading}
                        on:click={loadNextPage}
                    >
                        <img
                            src="/svg/chevron-down.svg"
                            alt=""
                            aria-hidden="true"
                            class="w-15 filter-orange-citric"
                            loading="lazy"
                        />
                    </button>
                    <span slot="content">
                        Mostrar mais
                    </span>
                </Tooltip>
            {/if}
        </div>
    </div>
{:else if mode === "infinite" && hasNextPage}
    <div bind:this={sentinel} class="flex justify-center mt-10 min-h-12">
        {#if isLoading}
            <span class="font-noto-sans text-orange-citric text-xl italic uppercase font-bold">
                {loadingLabel}
            </span>
        {/if}
    </div>
{:else if mode === "pagination" && pages?.meta?.last_page > 1}
    <div class="flex justify-center mt-5">
        <div class="flex gap-5">
            {#if previousUrl || pages.meta.current_page > 1}
                <button
                    type="button"
                    class="cursor-pointer w-full lg:w-auto py-2 px-6 border-4 border-solid border-orange-citric rounded-xl text-orange-citric text-xl italic uppercase font-noto-sans font-bold"
                    on:click={() => { previousUrl ? visit(previousUrl) : visit("", { [pageName]: pages.meta.current_page - 1 }); }}
                >
                    <span class="flex items-center justify-center gap-2">
                        <img
                            src="/svg/chevron-left.svg"
                            alt=""
                            aria-hidden="true"
                            class="w-5 filter-orange-citric"
                            loading="lazy"
                        />
                        Voltar uma pagina
                    </span>
                </button>
            {/if}
            {#if nextUrl || pages.meta.current_page < pages.meta.last_page}
                <button
                    type="button"
                    class="cursor-pointer w-full lg:w-auto py-2 px-6 border-4 border-solid border-orange-citric/90 rounded-xl text-orange-citric/90 text-xl italic uppercase font-noto-sans font-bold hover:border-orange-citric hover:text-orange-citric"
                    on:click={() => { nextUrl ? visit(nextUrl) : visit("", { [pageName]: pages.meta.current_page + 1 }); }}
                >
                    <span class="flex items-center justify-center gap-2">
                        Proxima pagina
                        <img
                            src="/svg/chevron-right.svg"
                            alt=""
                            aria-hidden="true"
                            class="w-5 filter-orange-citric"
                            loading="lazy"
                        />
                    </span>
                </button>
            {/if}
        </div>
    </div>
{/if}
