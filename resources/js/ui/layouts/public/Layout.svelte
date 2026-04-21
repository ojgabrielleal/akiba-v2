<script>
    import { usePoll } from "@inertiajs/svelte";
    import { Navbar } from "@/ui/widgets/public";

    usePoll(30 * 1000, {
        only: ["onair"]
    });
</script>

<header>
    <Navbar />
</header>

<main>
    <slot />
</main>

<footer>
    
</footer>