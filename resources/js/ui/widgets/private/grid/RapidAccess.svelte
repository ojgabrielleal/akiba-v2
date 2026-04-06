<script>
    import { hasPermission } from "@/utils";

    let can = {
        post: {
            create: hasPermission("post.create"),
        },
        repository: {
            create: hasPermission("repository.create"),
        },
        locution: {
            start: hasPermission("locution.start"),
        },
        event: {
            create: hasPermission("event.create"),
        },
    };
</script>

<div class="flex justify-center mb-10">
    <div class="flex gap-5">
        {#if can.post.create}
            <a href="/painel/materias" class="flex items-center gap-2 font-noto-sans font-bold italic uppercase text-blue-skywave text-lg pr-5 lg:first:pl-0 lg:border-r-2 lg:border-neutral-aurora/10 lg:last:border-0">
                <img src="/svg/default/materials.svg" alt="" aria-hidden="true" class="w-6 filter-blue-skywave" />
                Nova matéria
            </a>
        {/if}
        <!--
        <a href="/painel/adms" class="flex items-center gap-2 font-noto-sans font-bold italic uppercase text-blue-skywave text-lg pr-5 lg:first:pl-0 lg:border-r-2 lg:border-neutral-aurora/10 lg:last:border-0">
            <img src="/svg/default/alerts.svg" alt="" aria-hidden="true" class="w-6 filter-blue-skywave" />
            Novo aviso
        </a>
        -->
        {#if can.repository.create}
            <a href="/painel/marketing" class="flex items-center gap-2 font-noto-sans font-bold italic uppercase text-blue-skywave text-lg pr-5 lg:first:pl-0 lg:border-r-2 lg:border-neutral-aurora/10 lg:last:border-0">
                <img src="/svg/default/download.svg" alt="" aria-hidden="true" class="w-6 filter-blue-skywave" />
                Upar arquivo
            </a>
        {/if}
        {#if can.locution.start}
            <a href="/painel/locucao" class="flex items-center gap-2 font-noto-sans font-bold italic uppercase text-blue-skywave text-lg pr-5 lg:first:pl-0 lg:border-r-2 lg:border-neutral-aurora/10 lg:last:border-0">
                <img src="/svg/default/locution.svg" alt="" aria-hidden="true" class="w-6 filter-blue-skywave" />
                Iniciar programa
            </a>
        {/if}
        {#if can.event.create}
            <a href="/painel/eventos" class="flex items-center gap-2 font-noto-sans font-bold italic uppercase text-blue-skywave text-lg pr-5 lg:first:pl-0 lg:border-r-2 lg:border-neutral-aurora/10 lg:last:border-0">
                <img src="/svg/default/event.svg" alt="" aria-hidden="true" class="w-6 filter-blue-skywave" />
                Adicionar evento
            </a>
        {/if}
    </div>
</div>