<script>
    export let title;
    export let variant = "default";

    import { router, page } from "@inertiajs/svelte";
    import { Section, Pagination } from "@/ui/components/private";
    import { hasPermission } from "@/utils";

    $: ({ events } = $page.props);

    let can = {
        deactivate: hasPermission("event.deactivate"),
    };

    const requestDeactivateEvent = (event) => {
        router.delete(`/panel/media/event/${event}`, {}, {
            preserveScroll: true
        });
    };
</script>

{#if events && variant === "default"}
    <Section {title}>
        <div class="gap-6 grid grid-cols-1 lg:grid-cols-4 xl:grid-cols-5">
            {#if events.data.length > 0}
                {#each events.data as item}
                    <article class="w-full h-56 rounded-lg p-4 relative bg-blue-skywave">
                        <div class="font-noto-sans text-lg text-neutral-aurora line-clamp-5 uppercase">
                            {item.title}
                        </div>
                        <dl class="grid grid-cols-2 absolute bottom-2 left-4 w-[calc(100%-2rem)]">
                            <dt class="font-noto-sans font-bold italic uppercase text-lg text-neutral-aurora truncate">
                                {item.author.nickname}
                            </dt>
                            <dd class="flex gap-3 justify-end mt-1">
                                <a href={`/event/${item.slug}`} target="_blank" aria-label="Visualizar" class="cursor-pointer">
                                    <img
                                        src="/svg/eye.svg"
                                        alt=""
                                        aria-hidden="true"
                                        class="w-5 filter-neutral-aurora"
                                        loading="lazy"
                                    />
                                </a>
                                <a href={`/event/${item.uuid}`} aria-label="Editar" class="cursor-pointer disabled:opacity-50">
                                    <img
                                        src="/svg/edit.svg"
                                        alt=""
                                        aria-hidden="true"
                                        class="w-4 filter-neutral-aurora"
                                        loading="lazy"
                                    />
                                </a>
                            </dd>
                        </dl>
                    </article>
                {/each}
            {:else}
                <article class="w-full h-56 rounded-lg p-4 relative bg-blue-cerulean opacity-50">
                    <div class="font-noto-sans text-lg text-neutral-aurora line-clamp-5 uppercase">
                        Meu bem esse pessoal da akiba são um bando de
                        preguiçosos! Cade os eventos?
                    </div>
                    <div class="flex justify-between gap-5 absolute bottom-2 left-4 w-[calc(100%-2rem)]">
                        <div class="font-noto-sans font-bold italic uppercase text-lg text-neutral-aurora">
                            Aki-chan
                        </div>
                    </div>
                </article>
            {/if}
        </div>
    </Section>
    <Pagination pages={events} />
{/if}

{#if events && variant === "detailed"}
    <Section title="Eventos">
        <div class="grid grid-cols-1 lg:grid-cols-5 gap-5">
            {#if events.data.length > 0}
                {#each events.data as item}
                    <article class="flex flex-col gap-2">
                        <div class="h-65 bg-blue-skywave rounded-sm relative overflow-hidden">
                            <img
                                class="w-full h-65 object-cover aspect-square brightness-50"
                                src={item.cover}
                                alt={`Evento ${item.title}`}
                            />
                            <div class="flex gap-4 absolute bottom-3 right-3">
                                <a href={`/event/${item.uuid}`} type="button" class="cursor-pointer" aria-label="Editar">
                                    <img
                                        src="/svg/edit.svg"
                                        alt=""
                                        aria-hidden="true"
                                        class="w-5 filter-neutral-aurora"
                                        loading="lazy"
                                    />
                                </a>
                                {#if can.deactivate}
                                    <button type="button" class="cursor-pointer" aria-label="Desativar" on:click={() => requestDeactivateEvent(item.uuid)}>
                                        <img
                                            src="/svg/trash.svg"
                                            alt=""
                                            aria-hidden="true"
                                            class="w-5 filter-neutral-aurora"
                                            loading="lazy"
                                        />
                                    </button>
                                {/if}
                            </div>
                        </div>
                        <div class="rounded-sm bg-orange-amber py-1 px-5 text-neutral-aurora text-center font-noto-sans font-semibold line-clamp-2">
                            {item.address}
                        </div>
                        <div class="rounded-sm bg-orange-amber py-1 px-5 text-neutral-aurora text-center font-noto-sans font-semibold">
                            {item.dates}
                        </div>
                    </article>
                {/each}
            {:else}
                <article class="bg-blue-cerulean opacity-50 flex flex-col gap-2">
                    <div class="h-65 bg-blue-skywave rounded-sm relative overflow-hidden">
                        <img
                            class="w-full h-65 object-cover aspect-square brightness-50"
                            src="https://placehold.co/500x500?text=Rede+Akiba"
                            alt=""
                            aria-hidden="true"
                        />
                    </div>
                    <div class="rounded-sm bg-orange-amber py-2 text-neutral-aurora text-center font-noto-sans font-semibold">
                        Shinjuku - Tokyo
                    </div>
                    <div class="rounded-sm bg-orange-amber py-2 text-neutral-aurora text-center font-noto-sans font-semibold">
                        Amanhã
                    </div>
                </article>
            {/if}
        </div>
    </Section>
    <Pagination pages={events} />
{/if}
