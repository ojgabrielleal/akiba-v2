<script>
    import { page, router } from "@inertiajs/svelte";
    import { Meta } from "@/config/meta";
    import { Layout } from "@/layouts/private";
    import { BroadcastForm } from "@/ui/widgets/private/form";
    import { SongRequestGrid } from "@/ui/widgets/private/grid";

    $: ({ user, onair } = $page.props);

    const redirectToDashboard = () => {
        router.get("/painel/dashboard/");
    }
</script>

<Meta meta={{ title: "Locução" }} />
<Layout>
    <div class={[
        {'opacity-50 pointer-events-none': onair.data.type !== 'automatic'},
        {'opacity-none pointer-events-auto': onair.data.type === 'automatic'}
    ]}>
        <BroadcastForm/>
    </div>
    {#if onair.data.type === 'live'}
        <SongRequestGrid/>
    {/if}
</Layout>

{#if onair.data.type === 'live' && onair.data.program.host.uuid !== user.uuid}
    <section transition:fade={{duration: 500}} class="fixed inset-0 flex items-center justify-center p-2 lg:p-0 z-50 bg-black/20 backdrop-blur-lg">
        <div class="w-sm p-6 rounded-xl bg-neutral-aurora">
            <div class="flex justify-center">
                <img src="/img/broadcast/default/blocked.gif" alt="Bloqueador de tela" class="w-50 h-50 object-cover rounded-full" loading="lazy"/>
            </div>
            <div class="mt-6 mb-4 bg-red-crimson p-3 rounded-xl text-center text-neutral-aurora font-noto-sans font-bold uppercase">
                PARE! Tem gente ao vivo!
            </div>
            <div class="font-noto-sans mb-3">
                Opa! quer tirar {onair.data.program.host.gender === 'male' ? 'o' : 'a'} {onair.data.program.host.nickname} do ar? Segura ai! 
                Antes deixa {onair.data.program.host.gender === 'male' ? 'ele' : 'ela'} terminar o programa. Aqui ninguém sabe uma mágica milagrosa de 
                passagem de microfone, então respeite o horário!
            </div>
            <button on:click={()=>redirectToDashboard()} type="button" class="mt-5 flex gap-2 justify-center items-center cursor-pointer w-full py-2 px-6 border-2 border-blue-ocean rounded-xl text-md text-blue-ocean font-bold font-noto-sans italic uppercase">
                <img src="/svg/default/return.svg" alt="" aria-hidden="true" class="w-5 filter-blue-ocean" loading="lazy"/>
                Dashboard
            </button>
        </div>
    </section>    
{/if}

{#if onair.data.type === 'scheduled'}
    <section transition:fade={{duration: 500}} class="fixed inset-0 flex items-center justify-center p-2 lg:p-0 z-50 bg-black/20 backdrop-blur-lg">
        <div class="w-sm p-6 rounded-xl bg-neutral-aurora">
            <div class="flex justify-center">
                <img src="https://i2.wp.com/drunkenanimeblog.com/wp-content/uploads/2019/05/cute-girl-anime-headphones.gif?fit=500%2C287" alt="Bloqueador de tela" class="w-50 h-50 object-cover rounded-full" loading="lazy"/>
            </div>
            <div class="mt-6 mb-4 bg-neutral-gray p-3 rounded-xl text-center text-neutral-aurora font-noto-sans font-bold uppercase">
                Programa agendado no ar!
            </div>
            <div class="font-noto-sans mb-3">
                Opa! Um programa agendado por um dos admininistradores já está no ar!  
                Não tem como adiantar, pular ou cancelar na marra aqui ninguém sabe como mudar o tempo! Respeite o horário e espere ele terminar para poder entrar ao vivo!
            </div>
            <button on:click={()=>redirectToDashboard()} type="button" class="mt-5 flex gap-2 justify-center items-center cursor-pointer w-full py-2 px-6 border-2 border-blue-ocean rounded-xl text-md text-blue-ocean font-bold font-noto-sans italic uppercase">
                <img src="/svg/default/return.svg" alt="" aria-hidden="true" class="w-5 filter-blue-ocean" loading="lazy"/>
                Dashboard
            </button>
        </div>
    </section>    
{/if}