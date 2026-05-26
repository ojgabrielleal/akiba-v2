<script>
    import { page, router } from "@inertiajs/svelte";
    import { Meta } from "@/config";
    import { Layout } from "@/ui/layouts/private";
    import { LocutionForm, SongRequestGrid } from "@/ui/widgets/private";

    $: ({ user, onair } = $page.props);

    const redirectToDashboard = () => {
        router.get("/panel/dashboard/", {}, { preserveScroll: true });
    };
</script>

<Meta meta={{ title: "Locução" }} />
<Layout>
    <div 
        class:opacity-50={onair.data.type === "automatic" && onair.data.type === "scheduled"} 
        class:pointer-events-none={onair.data.type === "automatic" && onair.data.type === "scheduled"} 
    >
        <LocutionForm />
    </div>
    {#if onair.data.type === "live"}
        <SongRequestGrid title="Pedidos musicais" />
    {/if}
</Layout>

{#if onair.data.type === "live" && onair.data.program.host.uuid !== user.uuid}
    <section transition:fade={{ duration: 300 }} class="fixed inset-0 flex items-center justify-center z-50 bg-black/40 backdrop-blur-lg font-noto-sans">
        <div class="w-full max-w-sm px-6 py-7 rounded-2xl bg-suspense-aurora shadow-[0_20px_60px_rgba(0,0,0,0.25)]">
            <div class="flex justify-center">
                <div class="relative">
                    <div class="w-28 h-28 rounded-full overflow-hidden shadow-lg">
                        <img
                            src={onair.data.program.host.avatar}
                            alt=""
                            class="w-28 h-28 object-cover object-top scale-200"
                        />
                    </div>

                    <!-- Badge -->
                    <div class="absolute bottom-0 right-0 bg-red-500 text-white text-[11px] px-2 py-0.5 rounded-full font-bold shadow">
                        ● AO VIVO
                    </div>
                </div>
            </div>
            <h2 class="mt-5 text-center text-[20px] font-noto-sans font-bold text-[#2B2B2B] leading-tight">
            Programa ao vivo<br />em andamento
            </h2>
            <p class="mt-4 text-center text-[14px] text-[#5A5A5A] leading-relaxed">
                Não é possível iniciar um novo programa enquanto
                {onair.data.program.host.gender === "male" ? "o" : "a"}
                <span class="font-bold text-[#2B2B2B]">
                    {onair.data.program.host.nickname}
                </span>
                    está ao vivo.
                <br /><br />
                Aguarde o término do programa para iniciar um novo programa ao vivo.
            </p>
            <div class="mt-4 flex items-center justify-between bg-[#E9E6E1] px-3 py-3 rounded-lg text-[13px] text-[#5A5A5A]">
                <span>
                    💡 Qualquer problema, contate a administração
                </span>
            </div>
            <div class="mt-6 flex gap-3">
                <button
                    class="cursor-pointer w-full py-2.5 rounded-xl bg-[#2F5BFF] text-white font-semibold flex items-center justify-center gap-2 hover:brightness-110 transition"
                    on:click={() => redirectToDashboard()}
                >
                    <img
                        src="/svg/return.svg"
                        class="w-4 brightness-0 invert"
                        alt=""
                    />
                    Dashboard
                </button>
            </div>
            <p class="mt-4 text-center text-[12px] text-[#8A8A8A]">
                🔒 Ação bloqueada para proteger a transmissão
            </p>
        </div>
    </section>
{/if}
