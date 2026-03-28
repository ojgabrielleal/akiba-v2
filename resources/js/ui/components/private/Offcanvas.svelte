<script>
    import { fly } from 'svelte/transition';
    import { onDestroy } from 'svelte';

    export let title = 'Title';

    let visible = false;

    $: if (typeof document !== 'undefined') {
        document.body.style.overflow = visible ? 'hidden' : 'auto';
    }

    onDestroy(() => {
        if (typeof document !== 'undefined') {
            document.body.style.overflow = 'auto';
        }
    });

    export const open = () => {
        visible = true;
    }

    export const close = () => {
        visible = false;
    }

    const block = (event) => {
        event.stopPropagation();
    }
</script>

{#if visible}
    <!-- svelte-ignore a11y_click_events_have_key_events -->
    <!-- svelte-ignore a11y_no_static_element_interactions -->
    <div on:click={close} transition:fly={{ x: 400, duration: 300 }} class="w-screen h-screen fixed inset-0 bg-black/1 backdrop-blur-xs z-50">
        <div on:click={block} class="max-w-sm min-w-sm h-screen float-right bg-neutral-aurora">
            <div class="bg-blue-skywave p-4 text-neutral-aurora font-bold italic uppercase">
                {title}
            </div>
            <div class="pl-5 pr-8 pt-8 h-[calc(100vh-6rem)] overflow-y-auto">
                <slot name="content" {close}/>
            </div>
        </div>
    </div>
{/if}