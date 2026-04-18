<script>
    import { Link } from "@inertiajs/svelte";
    import { navbar } from "@/data";
</script>

<nav class="w-full">
    <div class="w-[85%] h-[3.2rem] relative top-15 bg-neutral-aurora float-end flex items-center">
        <div class="absolute -bottom-[0.95rem] -left-27 z-50">
            <img src="/img/default/logo.webp" alt="Logo" class="w-50" />
        </div>
        <ul class="mx-auto flex gap-5">
            {#each navbar.public as item}
                <li class="border-l first:border-none pl-5 border-blue-midnight h-6 flex items-center">
                    <Link href={item.address} aria-label={item.name} class="flex items-center gap-1 text-xl text-blue-midnight font-noto-sans font-extrabold italic uppercase">
                        <img 
                            src={item.icon} 
                            alt="" 
                            aria-hidden="true" 
                            class="w-5 h-5 filter-blue-midnight" 
                            loading="lazy"
                        />
                        {item.name}
                    </Link>
                </li>
            {/each}
        </ul>

        <!-- UI do Seletor de Temas (Apenas Visual) -->
        <div class="flex items-center gap-3 px-6 border-l border-blue-midnight h-6">
            <button class="text-blue-midnight hover:text-orange-amber transition-colors" title="Modo Claro">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="5"/><line x1="12" y1="1" x2="12" y2="3"/><line x1="12" y1="21" x2="12" y2="23"/><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"/><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"/><line x1="1" y1="12" x2="3" y2="12"/><line x1="21" y1="12" x2="23" y2="12"/><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"/><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"/></svg>
            </button>
            <button class="text-blue-midnight hover:text-orange-amber transition-colors opacity-50" title="Modo Escuro">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/></svg>
            </button>
            <button class="text-blue-midnight hover:text-orange-amber transition-colors opacity-50" title="Padrão do Sistema">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>
            </button>
        </div>
    </div>
</nav>

