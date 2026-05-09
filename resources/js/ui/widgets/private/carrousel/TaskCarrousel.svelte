<script>
    export let title;

    import { page, router } from "@inertiajs/svelte";
    import { Section } from "@/ui/components/private/";
    import { hasPermission } from "@/utils";

    $: ({ tasks } = $page.props);

    let can = {
        completed: hasPermission("task.complete"),
    };

    const requestmarkTaskToReview = (task) => {
        router.post(`/panel/dashboard/task/${task}/complete`, {}, {
            preserveScroll: true,
            preserveState: true,
        });
    };

</script>

{#if tasks}
    <Section {title}>
        <div class="flex flex-col gap-4">
            {#each tasks.data as task}
                <article class={["w-full rounded-lg px-4 py-3", 
                    { "bg-gradient-blue-secondary": task.status === 'pending' },
                    { "bg-gradient-green-primary": task.status === 'in_review' },
                    { "bg-gradient-red-primary": task.is_overdue && task.status === 'pending' },
                ]}>
                    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                        <div class="block min-w-0">
                            <div class="truncate text-2xl font-bold uppercase italic text-neutral-white">
                                {task.title}
                            </div>
                            <div class="line-clamp-2 text-md text-neutral-white">
                                {task.description}
                            </div>
                        </div>
                        {#if task.status === 'pending'}
                            <div class={["grid w-full h-15 shrink-0 grid-cols-[1fr_1fr] overflow-hidden rounded-2xl bg-blue-night",
                                {"md:w-52": task.is_overdue},
                                {"md:w-35": !task.is_overdue},
                            ]}>
                                <div class="flex flex-col gap-1 justify-center bg-suspense-aurora px-4 font-noto-sans text-blue-night">
                                    <span class="text-sm text-center font-bold uppercase leading-none">
                                        Faltam
                                    </span>
                                    <div class="flex justify-center items-center gap-1">
                                        <span class="text-4xl font-black leading-[0.85] text-blue-skywave">
                                            {task.is_overdue ? '0' : task.days_remaining}
                                        </span>
                                        <span class="pb-1 text-sm font-medium uppercase leading-none">
                                            {task.days_remaining === 1 ? "dia" : "dias"}
                                        </span>
                                    </div>
                                </div>
                                {#if task.is_overdue}
                                    <div class="bg-blue-night px-3 flex items-center font-noto-sans font-bold italic uppercase text-orange-amber text-center leading-5">
                                        Você tem 1 strike
                                    </div>
                                {:else}
                                    <div class="flex items-center justify-center bg-blue-night px-3">
                                        {#if can.completed}
                                            <button
                                                type="button"
                                                aria-label="Marcar tarefa como concluida"
                                                class="group flex h-full w-full cursor-pointer items-center justify-center"
                                                on:click={() => requestmarkTaskToReview(task.uuid)}
                                            >
                                                <img
                                                    src="/svg/verify.svg"
                                                    alt=""
                                                    aria-hidden="true"
                                                    class="w-5 filter-orange-citric"
                                                    loading="lazy"
                                                />
                                            </button>
                                        {/if}
                                    </div>
                                {/if}
                            </div>
                        {:else if task.status === 'in_review'}
                            <div class="flex w-full md:w-35 h-15 shrink-0 items-center justify-center rounded-2xl bg-blue-marinho px-4 font-noto-sans font-bold italic uppercase text-center text-neutral-white">
                                Em avaliação
                            </div>
                        {/if}
                    </div>
                </article>
            {/each}
        </div>
    </Section>
{/if}
