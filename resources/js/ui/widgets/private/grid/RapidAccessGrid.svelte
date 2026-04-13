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
    <div class="flex flex-wrap justify-center gap-5">
        {#if can.post.create}
            <a href="/materias" class="flex items-center gap-2 font-noto-sans font-bold italic uppercase text-blue-skywave text-lg pr-5 lg:first:pl-0 lg:border-r-2 lg:border-neutral-aurora/10 lg:last:border-0">
                <img 
                    src="/svg/materials.svg" 
                    alt="" 
                    aria-hidden="true" 
                    class="w-6 filter-blue-skywave" 
                />
                Nova matéria
            </a>
        {/if}
        <!--
        <a href="/adms" class="flex items-center gap-2 font-noto-sans font-bold italic uppercase text-blue-skywave text-lg pr-5 lg:first:pl-0 lg:border-r-2 lg:border-neutral-aurora/10 lg:last:border-0">
            <img src="/svg/alerts.svg" alt="" aria-hidden="true" class="w-6 filter-blue-skywave" />
            Novo aviso
        </a>
        -->
        {#if can.repository.create}
            <a href="/marketing" class="flex items-center gap-2 font-noto-sans font-bold italic uppercase text-blue-skywave text-lg pr-5 lg:first:pl-0 lg:border-r-2 lg:border-neutral-aurora/10 lg:last:border-0">
                <img 
                    src="/svg/download.svg" 
                    alt="" 
                    aria-hidden="true" 
                    class="w-6 filter-blue-skywave" 
                />
                Upar arquivo
            </a>
        {/if}
        {#if can.locution.start}
            <a href="/locucao" class="flex items-center gap-2 font-noto-sans font-bold italic uppercase text-blue-skywave text-lg pr-5 lg:first:pl-0 lg:border-r-2 lg:border-neutral-aurora/10 lg:last:border-0">
                <img 
                    src="/svg/locution.svg" 
                    alt="" 
                    aria-hidden="true" 
                    class="w-6 filter-blue-skywave" 
                />
                Iniciar programa
            </a>
        {/if}
        {#if can.event.create}
            <a href="/eventos" class="flex items-center gap-2 font-noto-sans font-bold italic uppercase text-blue-skywave text-lg pr-5 lg:first:pl-0 lg:border-r-2 lg:border-neutral-aurora/10 lg:last:border-0">
                <img 
                    src="/svg/event.svg" 
                    alt="" 
                    aria-hidden="true" 
                    class="w-6 filter-blue-skywave" 
                />
                Adicionar evento
            </a>
        {/if}
    </div>
</div>
