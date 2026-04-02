<script>
    import { Meta } from "@/config/meta";
    import { MainPlayer } from "@/ui/widgets/public/player";

    document.body.style.backgroundColor = "var(--color-blue-midnight)";
</script>

<Meta />
<header>
    <div class="w-full flex overflow-hidden fixed top-0 z-10">
        <div class="flex shrink-0">
            <div class="bg-blue-ocean py-1 px-10 [clip-path:polygon(0_0,100%_0,calc(100%-1.25rem)_100%,0_100%)] text-neutral-aurora font-noto-sans font-bold italic uppercase">
                Em Reforma
            </div>
            <div class="w-40 bg-orange-amber py-1 px-4 -ml-5 [clip-path:polygon(1.25rem_0,100%_0,calc(100%-1.25rem)_100%,0_100%)]"></div>
        </div>
        {#each Array(15) as _, index}
            <div class="flex -ml-5 shrink-0">
                <div class="bg-blue-ocean py-1 px-10 [clip-path:polygon(1.25rem_0,100%_0,calc(100%-1.25rem)_100%,0_100%)] text-neutral-aurora font-noto-sans font-bold italic uppercase">
                    Em Reforma
                </div>
                <div class="w-40 bg-orange-amber py-1 px-4 -ml-5 [clip-path:polygon(1.25rem_0,100%_0,calc(100%-1.25rem)_100%,0_100%)]"></div>
            </div>
        {/each}
    </div>
</header>

<main class="flex flex-col mt-10 justify-center h-screen">
    <div class="cont mb-15">
        <div class="w-full flex justify-center">
            <img
                src="/img/default/logoProvisory.webp"
                alt="Logo"
                class="w-120"
                loading="lazy"
            />
        </div>
    </div>
    <MainPlayer />
</main>

<footer>
    <div class="w-full flex overflow-hidden fixed bottom-0 z-10">
        <div class="flex shrink-0">
            <div class="bg-blue-ocean py-1 px-10 [clip-path:polygon(0_0,100%_0,calc(100%-1.25rem)_100%,0_100%)] text-neutral-aurora font-noto-sans font-bold italic uppercase">
                Em Reforma
            </div>
            <div class="w-40 bg-orange-amber py-1 px-4 -ml-5 [clip-path:polygon(1.25rem_0,100%_0,calc(100%-1.25rem)_100%,0_100%)]"></div>
        </div>
        {#each Array(15) as _, index}
            <div class="flex -ml-5 shrink-0">
                <div class="bg-blue-ocean py-1 px-10 [clip-path:polygon(1.25rem_0,100%_0,calc(100%-1.25rem)_100%,0_100%)] text-neutral-aurora font-noto-sans font-bold italic uppercase">
                    Em Reforma
                </div>
                <div class="w-40 bg-orange-amber py-1 px-4 -ml-5 [clip-path:polygon(1.25rem_0,100%_0,calc(100%-1.25rem)_100%,0_100%)]"></div>
            </div>
        {/each}
    </div>
</footer>
