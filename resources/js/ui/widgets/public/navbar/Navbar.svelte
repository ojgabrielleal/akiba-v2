<script>
    import { Link } from "@inertiajs/svelte";
    import { navbar } from "@/data";

    let theme = "night";
    let mobilenavbar = false;
</script>

<nav class="w-full relative">
    <div class="w-full xl:w-[88%] xl:h-[2.57rem] px-5 py-2 xl:px-0 xl:py-0 relative xl:top-15 bg-neutral-aurora xl:float-end flex items-center">
        <button on:click={() => (mobilenavbar = !mobilenavbar)} aria-label="Abrir menu" class="xl:hidden p-1">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                <path d="M4 6h16M4 12h16M4 18h16" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </button>

        <div class="mx-auto xl:mx-0 xl:absolute xl:-bottom-3 xl:-left-23 xl:z-50">
            <img src="/img/default/logo.webp" alt="Logo" class="w-30 xl:w-40" />
        </div>

        <ul class="hidden xl:flex gap-5 ml-20">
            {#each navbar.public as item}
                <li class="border-l first:border-none pl-5 border-blue-midnight h-6 flex items-center text-blue-midnight">
                    <Link href={item.address} aria-label={item.name} class="flex items-center gap-1 text-lg font-noto-sans font-extrabold italic uppercase">
                        <img src={item.icon} alt="" aria-hidden="true" class="w-5 h-5 filter-blue-midnight" loading="lazy" />
                        {item.name}
                    </Link>
                </li>
            {/each}
        </ul>

        <div class="hidden xl:flex justify-center items-center w-25 h-8 gap-1 bg-blue-skywave rounded-full absolute right-5">
            <button aria-label="Modo Claro" on:click={() => theme = 'light'} class={["cursor-pointer shrink-0 p-1", 
                {'bg-orange-morning rounded-full': theme === 'light'}
            ]}>
                <img src="/svg/dawn.svg" alt="" aria-hidden="true" class={["w-4 h-4", 
                    { 'filter-orange-amber' : theme === 'light' }, 
                    { 'filter invert' : theme !== 'light' }]
                } />
            </button>
            <button aria-label="Modo Akiba" on:click={() => theme = 'akiba'} class={["cursor-pointer shrink-0 p-1", 
                {'bg-blue-midnight rounded-full': theme === 'akiba'}
            ]}>
                <img src="/svg/akiba.svg" alt="" aria-hidden="true" class={["w-4 h-4", 
                    { 'filter-orange-amber' : theme === 'akiba' }, 
                    { 'filter invert' : theme !== 'akiba' }]
                }/>
            </button>
            <button aria-label="Modo Ecuro" on:click={() => theme = 'night'} class={["cursor-pointer shrink-0 p-1", 
                {'bg-blue-midnight rounded-full': theme === 'night'}
            ]}>
                <img src="/svg/night.svg" alt="" aria-hidden="true" class={["w-4 h-4", 
                    { 'filter-orange-morning' : theme === 'night' }, 
                    { 'filter invert' : theme !== 'night' }]
                }/>
            </button>
        </div>
    </div>

    <!-- Mobile Navbar -->
    <div class={["fixed inset-0 z-150 transition-opacity duration-300 xl:hidden", 
        { "opacity-100 pointer-events-auto": mobilenavbar }, 
        { "opacity-0 pointer-events-none": !mobilenavbar }
    ]}>
        <button type="button" aria-hidden="true" class="absolute inset-0 bg-blue-midnight/40 backdrop-blur-sm" on:click={() => (mobilenavbar = false)}></button>

        <!-- Sidebar        -->
        <div class={["absolute left-0 top-0 h-screen w-72 bg-neutral-aurora shadow-2xl transition-transform duration-300 ease-out", 
            { "translate-x-0": mobilenavbar }, 
            { "-translate-x-full": !mobilenavbar }
        ]}>
            <div class="p-6 border-b border-blue-midnight/10 flex items-center justify-between">
                <img src="/img/default/logo.webp" alt="Logo" class="w-30" />
                <button on:click={() => (mobilenavbar = false)} aria-label="Fechar menu" class="text-blue-midnight">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M6 18L18 6M6 6l12 12" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>
            </div>

            <nav class="p-6 overflow-y-auto h-[calc(100%-12rem)]">
                <ul class="space-y-5">
                    {#each navbar.public as item}
                        <li>
                            <Link href={item.address} on:click={() => (mobilenavbar = false)} class="flex items-center gap-2 text-md font-noto-sans font-extrabold italic uppercase text-blue-midnight">
                                <img src={item.icon} alt="" class="w-5 h-5 filter-blue-midnight" />
                                {item.name}
                            </Link>
                        </li>
                    {/each}
                </ul>
            </nav>

            <div class="absolute bottom-0 left-0 w-full p-6 border-t border-blue-midnight/10 bg-neutral-aurora z-10">
                <span class="w-full block text-[0.6rem] font-bold uppercase tracking-widest text-blue-midnight text-center opacity-40 mb-3">
                    Temas da Akiba
                </span>
                <div class="w-25 h-8 mx-auto flex justify-center items-center gap-1 bg-blue-skywave p-1 rounded-full">
                    <button on:click={() => theme = 'light'} class={["flex-1 flex justify-center items-center transition-all h-full", 
                        {'bg-orange-morning rounded-full': theme === 'light'}
                    ]}>
                        <img src="/svg/dawn.svg" alt="Claro" aria-hidden="true" class={["w-4 h-4", 
                            { 'filter-orange-amber' : theme === 'light' }, 
                            { 'filter invert' : theme !== 'light' }
                        ]} />
                    </button>
                    <button on:click={() => theme = 'akiba'} class={["flex-1 flex justify-center items-center transition-all h-full", 
                        {'bg-blue-midnight rounded-full': theme === 'akiba'}
                    ]}>
                        <img src="/svg/akiba.svg" alt="Akiba" aria-hidden="true" class={["w-4 h-4", 
                            { 'filter-orange-amber' : theme === 'akiba' }, 
                            { 'filter invert' : theme !== 'akiba' }
                        ]}/>
                    </button>
                    <button on:click={() => theme = 'night'} class={["flex-1 flex justify-center items-center transition-all h-full", 
                        {'bg-blue-midnight rounded-full': theme === 'night'}
                    ]}>
                        <img src="/svg/night.svg" alt="Escuro" aria-hidden="true" class={["w-4 h-4", 
                            { 'filter-orange-morning' : theme === 'night' }, 
                            { 'filter invert' : theme !== 'night' }
                        ]}/>
                    </button>
               </div>
            </div>
        </div>
    </div>
</nav>
