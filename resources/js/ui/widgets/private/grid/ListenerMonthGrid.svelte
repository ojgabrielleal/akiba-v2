<script>
    export let title;

    import { page } from "@inertiajs/svelte";
    import { Section } from "@/ui/components/private/";
    import { Offcanvas } from "@/ui/components/private";
    import { ListenerMonthForm } from "@/ui/widgets/private/form";
    import { hasPermission } from "@/utils";

    $: ({ listenermonth } = $page.props);

    let can = {
        set: hasPermission("listener.month.set"),
    };

    let offcanvasRef;
</script>

<Offcanvas bind:this={offcanvasRef} title="Atualizar ouvinte do mês">
    <div slot="content" let:close>
        <ListenerMonthForm {close} />
    </div>
</Offcanvas>

{#if listenermonth}
    <Section {title}>
        <article class="grid grid-cols-1 lg:grid-cols-2">
            <div class="grid grid-cols-2">
                <dl class="mb-8">
                    <dt class="text-orange-amber font-bold italic text-lg uppercase font-noto-sans">
                        Nome:
                    </dt>
                    <dd class="block text-neutral-aurora font-noto-sans uppercase">
                        {listenermonth.data.name || "Aurora"}
                    </dd>
                </dl>
                <dl class="mb-8">
                    <dt class="text-orange-amber font-bold italic text-lg uppercase font-noto-sans block">
                        Mora em:
                    </dt>
                    <dd class="block text-neutral-aurora font-noto-sans uppercase">
                        {listenermonth.data.address || "São Paulo - SP"}
                    </dd>
                </dl>
                <dl class="mb-8">
                    <dt class="text-orange-amber font-bold italic text-lg uppercase font-noto-sans block">
                        Número de pedidos feitos:
                    </dt>
                    <dd class="block text-neutral-aurora font-noto-sans uppercase">
                        {listenermonth.data.requests_total || "+500"}
                    </dd>
                </dl>
                <dl class="mb-8">
                    <dt class="text-orange-amber font-bold italic text-lg uppercase font-noto-sans block">
                        Programa preferido
                    </dt>
                    <dd class="block text-neutral-aurora font-noto-sans uppercase">
                        {listenermonth.data.favorite_show || "Akiba Art Online"}
                    </dd>
                </dl>
            </div>
            <div class="flex gap-5 items-center justify-end">
                <div>
                    <div class="text-orange-amber font-bold italic text-sm uppercase font-noto-sans block">
                        Imagem do ouvinte
                    </div>
                    <img
                        src={listenermonth.data.avatar || "https://placehold.co/500x500?text=Rede+Akiba"}
                        alt="Imagem do ouvinte"
                        class="w-36 h-36 bg-gray-600 rounded-lg"
                    />
                </div>
                {#if can.set}
                    <button class="cursor-pointer bg-blue-skywave px-4 py-2 rounded-md text-neutral-aurora font-noto-sans font-bold uppercase italic" on:click={() => { 
                        offcanvasRef.open();
                    }}>
                        Atualizar ouvinte
                    </button>
                {/if}
            </div>
        </article>
    </Section>
{/if}
