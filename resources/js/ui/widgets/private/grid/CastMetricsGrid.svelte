<script>
    import { page } from "@inertiajs/svelte";

    $: ({ streaming } = $page.props);
</script>

<section class="container-page bg-blue-marinho">
    <div class="border-t border-orange-amber py-4">
        <div class="flex">
            <div class="hidden gap-2 items-end font-noto-sans text-orange-amber text-xl uppercase pr-6 border-r border-r-[rgba(229,231,235,0.3)] lg:flex">
                <img
                    src="/svg/kbps.svg"
                    alt=""
                    aria-hidden="true"
                    class="w-8 filter-blue-skywave"
                    loading="lazy"
                />
                {streaming.bitrate || "N/A"}
            </div>
            <div class="hidden gap-2 items-end font-noto-sans text-orange-amber text-xl uppercase pl-6 pr-6 border-r border-r-[rgba(229,231,235,0.3)] lg:flex">
                <img
                    src="/svg/satelite.svg"
                    alt=""
                    aria-hidden="true"
                    class="w-8 filter-blue-skywave"
                    loading="lazy"
                />
                {streaming.status || "N/A"}
            </div>
            <div class="flex gap-2 items-end font-noto-sans text-orange-amber text-xl uppercase lg:pl-6 lg:pr-6">
                <img
                    src="/svg/listeners.svg"
                    alt=""
                    aria-hidden="true"
                    class="w-8 filter-blue-skywave"
                    loading="lazy"
                />
                {streaming.listeners || "N/A"} Ouvintes
            </div>
        </div>
    </div>
</section>
