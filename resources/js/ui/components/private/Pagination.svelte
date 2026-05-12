<script>
    export let pages;
    export let mode = "infinite";
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
    let loadingAction = null;
    let pageHistory = [];
    const resetDelay = 900;

    $: nextUrl = pages?.links?.next ?? pages?.next_page_url ?? null;
    $: hasNextPage = Boolean(nextUrl) || (
        pages?.meta?.current_page &&
        pages?.meta?.last_page &&
        pages.meta.current_page < pages.meta.last_page
    );

    $: if ((mode === "button" || mode === "infinite") && pages?.meta?.current_page === 1) {
        pageHistory = [pages];
    }

    const visit = (url, data = {}, action = "next") => {
        if (isLoading) return;

        const previousData = pages?.data ?? [];

        isLoading = true;
        loadingAction = action;

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
                loadingAction = null;
            },
        });
    };

    const loadNextPage = () => {
        if (nextUrl) {
            visit(nextUrl, {}, "next");
            return;
        }

        if (pages?.meta?.current_page && pages?.meta?.current_page < pages?.meta?.last_page) {
            visit("", { [pageName]: pages.meta.current_page + 1 }, "next");
        }
    };

    const resetPages = () => {
        if (isLoading || only.length !== 1 || pageHistory.length <= 1) return;

        isLoading = true;
        loadingAction = "previous";

        setTimeout(() => {
            pageHistory = pageHistory.slice(0, -1);

            router.replaceProp(only[0], {
                ...pageHistory.at(-1),
                data: pageHistory.flatMap((page) => page?.data ?? []),
            });

            isLoading = false;
            loadingAction = null;
        }, resetDelay);
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
        <div class="flex items-center justify-center gap-4 min-h-12">
            {#if pageHistory.length > 1}
                {#if isLoading && loadingAction === "previous"}
                    <span class="pagination-spinner" aria-label={loadingLabel}></span>
                {:else}
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
                                class="w-10 filter-orange-citric pagination-less-arrow"
                                loading="lazy"
                            />
                        </button>
                        <span slot="content">
                            Mostrar menos
                        </span>
                    </Tooltip>
                {/if}
            {/if}
            {#if hasNextPage}
                {#if isLoading && loadingAction === "next"}
                    <span class="pagination-spinner" aria-label={loadingLabel}></span>
                {:else}
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
                                class="w-10 filter-orange-citric pagination-more-arrow"
                                loading="lazy"
                            />
                        </button>
                        <span slot="content">
                            Mostrar mais
                        </span>
                    </Tooltip>
                {/if}
            {/if}
        </div>
    </div>
{:else if mode === "infinite" && hasNextPage}
    <div bind:this={sentinel} class="flex justify-center mt-10 min-h-12">
        {#if isLoading}
            <span class="pagination-spinner" aria-label={loadingLabel}></span>
        {/if}
    </div>
{/if}

<style>
    .pagination-more-arrow {
        animation: pagination-more-arrow-bounce 1.8s ease-in-out infinite;
    }

    .pagination-less-arrow {
        animation: pagination-less-arrow-bounce 1.8s ease-in-out infinite;
    }

    .pagination-spinner {
        width: 1.5rem;
        height: 1.5rem;
        border: 0.2rem solid rgb(255 143 0 / 0.25);
        border-top-color: rgb(255 143 0);
        border-radius: 9999px;
        animation: pagination-spinner-spin 0.75s linear infinite;
    }

    @keyframes pagination-more-arrow-bounce {
        0%,
        100% {
            transform: translateY(0);
        }

        50% {
            transform: translateY(0.2rem);
        }
    }

    @keyframes pagination-less-arrow-bounce {
        0%,
        100% {
            transform: translateY(0);
        }

        50% {
            transform: translateY(-0.15rem);
        }
    }

    @keyframes pagination-spinner-spin {
        to {
            transform: rotate(360deg);
        }
    }
</style>
