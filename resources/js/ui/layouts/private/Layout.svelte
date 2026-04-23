<script>
    import { onMount } from "svelte";
    import { page, usePoll } from "@inertiajs/svelte";
    import toast, { Toaster } from "svelte-hot-french-toast";
    import { Navbar, CastMetricsGrid } from "@/ui/widgets/private";

    $: ({ flash } = $page.props);

    $: if (flash?.message) {
        toast(flash.message, {
            icon: flash.icon,
        });
    }

    usePoll(60 * 1000, {
        only: ["songRequests", "audience", "streaming"],
    });

    onMount(() => {
        document.body.style.backgroundColor = "var(--color-blue-marinho)";
    });
</script>

<Toaster />
<header class="mb-15 lg:pt-10">
    <Navbar />
</header>
<main class="cont">
    <slot />
</main>
<footer>
    <div class="h-20"></div>
    <div class="w-full fixed bottom-0 z-50">
        <CastMetricsGrid />
    </div>
</footer>
