<script>
    import { fade, scale } from 'svelte/transition';
    import { quintOut } from 'svelte/easing';

    let visible = false;

    export const show = () => {
        visible = true;
    };

    export const close = () => {
        visible = false;
    };

    const block = (event) => {
        event.stopPropagation();
    };
</script>

<button type="button" on:click={show} aria-label="Abrir Modal">
    <slot name="action" />
</button>

{#if visible}
    <!-- Overlay -->
    <!-- svelte-ignore a11y_click_events_have_key_events -->
    <!-- svelte-ignore a11y_no_static_element_interactions -->
    <!-- svelte-ignore a11y_interactive_supports_focus -->
    <section class="fixed inset-0 z-50 flex items-center justify-center bg-black/60" on:click={close} transition:fade={{ duration: 200 }}>
        <div on:click={block} transition:scale={{ start: 0.95, duration: 250, easing: quintOut }} class="bg-neutral-aurora w-full max-w-sm mx-4 rounded-t-xl rounded-b-lg flex flex-col" role="dialog" aria-modal="true">
            <div class="bg-blue-skywave px-5 py-4 rounded-t-lg relative">
                <div class="text-center text-neutral-aurora font-noto-sans font-bold italic uppercase">
                    <slot name="title" />
                </div>
                <button type="button" on:click={close} aria-label="Fechar Modal" class="p-1 bg-neutral-aurora rounded-full absolute -right-6 -top-6">
                    <img src="/svg/default/close.svg" alt="" aria-hidden="true" class="w-3" loading="lazy"/>
                </button>
            </div>
            <div class="p-5 overflow-y-auto max-h-[70vh]">
                <slot name="content" {close} />
            </div>
        </div>
    </section>
{/if}