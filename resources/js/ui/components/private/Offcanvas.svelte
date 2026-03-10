<script>
    import { fly } from 'svelte/transition';

    export let title = 'Title';

    let visible = false;

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
        <div on:click={block} class="max-w-sm h-screen float-right bg-neutral-aurora">
            <div class="bg-blue-skywave p-4 text-neutral-aurora font-bold italic uppercase">
                {title}
            </div>
            <div class="h-[calc(100vh-4rem)] p-5 overflow-y-auto">
                <slot name="content" {close}/>
            </div>
        </div>
    </div>
{/if}