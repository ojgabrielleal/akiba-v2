<script>
    import { fly } from 'svelte/transition';

    let visible = false;

    export const open = () => {
        visible = true;
    }

    export const close = () => {
        visible = false;
    }
</script>

{#if visible}
    <!-- svelte-ignore a11y_click_events_have_key_events -->
    <!-- svelte-ignore a11y_no_static_element_interactions -->
    <div on:click={close} transition:fly={{ x: 400, duration: 300 }} class="w-screen h-screen fixed inset-0 bg-black/1 backdrop-blur-xs z-50">
        <div class="max-w-sm h-screen float-right bg-neutral-aurora p-5">
            <slot name="content"/>
        </div>
    </div>
{/if}