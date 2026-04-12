<script>
    export let title;
    export let variant;

    import { page, router } from "@inertiajs/svelte";
    import { Offcanvas, Section } from "@/ui/components/private/";
    import { ActivityForm } from "@/ui/widgets/private";
    import { scrollx, hasPermission } from "@/utils";

    $: ({ user, activities } = $page.props);

    let can = {
        participate: hasPermission("activity.participate"),
        update: hasPermission("activity.update"),
    };

    let offcanvasRef;
    let identifier;

    const requestConfirmActivityParticipant = (activity) => {
        router.post(
            `/painel/dashboard/activity/${activity}/confirm`,
            {},
            { preserveScroll: true },
        );
    };
</script>

<Offcanvas bind:this={offcanvasRef} title="Atualizar atividade/aviso">
    <div slot="content" let:close>
        <ActivityForm {identifier} {close} />
    </div>
</Offcanvas>

{#if activities}
    <Section {title}>
        <div
            class="scroll-x overflow-x-auto flex gap-5 flex-nowrap"
            on:wheel|nonpassive={scrollx}
            role="group"
        >
            {#if activities.data.length > 0}
                {#each activities.data as item}
                    {@const canParticipate =
                        can.participate &&
                        !item.confirmations.some(
                            (conf) => conf.uuid === user.uuid,
                        )}
                    <article
                        class={[
                            "w-100 h-50 lg:w-116 shrink-0 rounded-lg p-4 relative",
                            {
                                "bg-neutral-honeycream":
                                    item.allows_confirmations,
                            },
                            { "bg-blue-skywave": !item.allows_confirmations },
                        ]}
                    >
                        <div
                            class={[
                                "font-noto-sans font-black italic uppercase text-xl",
                                {
                                    "text-blue-midnight":
                                        item.allows_confirmations,
                                },
                                {
                                    "text-neutral-aurora":
                                        !item.allows_confirmations,
                                },
                            ]}
                        >
                            {item.author.nickname}
                        </div>
                        <div
                            class={[
                                "font-noto-sans text-sm line-clamp-5 mt-1",
                                {
                                    "text-blue-midnight":
                                        item.allows_confirmations,
                                },
                                {
                                    "text-neutral-aurora":
                                        !item.allows_confirmations,
                                },
                            ]}
                        >
                            {item.content}
                        </div>
                        {#if item.allows_confirmations}
                            <div class="flex gap-2 absolute bottom-3 left-4">
                                {#each item.confirmations.slice(0, 5) as conf}
                                    <div class="relative group/avatar">
                                        <img
                                            src={conf.avatar}
                                            alt={conf.nickname}
                                            class="w-10 h-10 rounded-full bg-neutral-aurora border-2 border-white/10 shadow-sm object-cover object-top hover:scale-105 transition-transform duration-300"
                                            loading="lazy"
                                        />
                                        <div
                                            class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 px-2 py-1 bg-neutral-900/90 backdrop-blur-sm text-white text-[10px] font-medium rounded-lg invisible group-hover/avatar:visible opacity-0 group-hover/avatar:opacity-100 transition-all duration-200 whitespace-nowrap z-50 pointer-events-none border border-white/10 shadow-xl"
                                        >
                                            {conf.nickname}
                                            <div
                                                class="absolute top-full left-1/2 -translate-x-1/2 border-4 border-transparent border-t-neutral-900/90"
                                            ></div>
                                        </div>
                                    </div>
                                {/each}
                            </div>
                        {/if}
                        <div class="flex gap-2 absolute bottom-3 right-4">
                            {#if can.update && variant === "administration"}
                                <button
                                    type="button"
                                    aria-label="Atualizar"
                                    class="w-8 h-8 bg-neutral-aurora rounded-md flex justify-center items-center font-noto-sans italic font-bold cursor-pointer"
                                    on:click={() => {
                                        identifier = item.uuid;
                                        offcanvasRef.open();
                                    }}
                                >
                                    <img
                                        src="/svg/edit.svg"
                                        alt=""
                                        aria-hidden="true"
                                        class="w-4"
                                        loading="lazy"
                                    />
                                </button>
                            {/if}
                            {#if canParticipate && item.allows_confirmations}
                                <button
                                    type="button"
                                    aria-label="Confirmar"
                                    class="w-8 h-8 bg-neutral-aurora rounded-md flex justify-center items-center font-noto-sans italic font-bold cursor-pointer"
                                    on:click={() =>
                                        requestConfirmActivityParticipant(
                                            item.uuid,
                                        )}
                                >
                                    <img
                                        src="/svg/verify.svg"
                                        alt=""
                                        aria-hidden="true"
                                        class="w-5"
                                        loading="lazy"
                                    />
                                </button>
                            {/if}
                        </div>
                    </article>
                {/each}
            {/if}
        </div>
    </Section>
{/if}
