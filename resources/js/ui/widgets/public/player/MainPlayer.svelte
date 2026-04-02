<section class="w-full bg-blue-ocean mb-10">
    <div class="cont-player-main py-4 relative">
        <div class="hidden lg:block absolute -top-7 -left-10 z-10">
            <img src="/img/player/default/rains.webp" alt="" aria-hidden="true" class="w-20 transform -scale-x-100 -scale-y-100" loading="lazy"/>
        </div>
        <!-- svelte-ignore a11y_distracting_elements -->
        <marquee class="w-5xl flex overflow-x-hidden relative marquee-container">
            <div class="whitespace-nowrap w-full md:w-auto text-neutral-aurora text-3xl font-noto-sans font-bold uppercase italic">
                <span class="mx-4">
                    Olá hoje é festa
                </span>
            </div>
        </marquee>
        <div class="hidden lg:block absolute bottom-0 -right-4 z-10">
            <img src="/img/locution/icons/animeGirl.webp" alt="" aria-hidden="true" class="w-35" loading="lazy"/>
        </div>
        <div class="hidden lg:block absolute -top-8 -right-10 z-10">
            <img src="/img/player/default/rains.webp" alt="" aria-hidden="true" class="w-20" loading="lazy"/>
        </div>
    </div>
</section>

<section class="cont-player-main grid grid-cols-[2fr_1fr_0.8fr] items-center gap-5">
    <div class="block">
        <div class="flex items-center gap-5 mb-15">
            <div class="w-52">
                <img src="/img/locution/default/program.webp" alt="Programa" loading="lazy"/>
            </div>
            <div class="text-gray-500">
                <img src="/svg/default/arrowRightTwo.svg" alt="" aria-hidden="true" class="w-8 filter-neutral-gray" loading="lazy"/>
            </div>
            <div>
                <div class="text-orange-amber font-noto-sans uppercase">
                    Com o locutor
                </div>
                <div class="w-full text-neutral-aurora text-3xl font-noto-sans font-bold uppercase italic line-clamp-1">
                    Neko Kirame
                </div>
                <div class="bg-green-forest mt-[0.4rem] w-24 rounded-xl text-center text-sm text-neutral-aurora font-noto-sans font-bold italic uppercase">
                    Humano
                </div>
            </div>
            <div class="text-gray-500">
                <img src="/svg/default/arrowRightTwo.svg" alt="" aria-hidden="true" class="w-8 filter-neutral-gray" loading="lazy"/>
            </div>
        </div>
        <div class="flex gap-3 items-end">
            <div class="w-20">
                <img src="https://www.clubotaku.org/nijiwp/wp-content/uploads/613.jpg" alt="" aria-hidden="true" class="rounded-lg" loading="lazy"/>
            </div>
            <div>
                <div class="text-orange-amber font-noto-sans uppercase italic">
                    Tocando agora:
                </div>
                <div class="text-neutral-aurora text-xl font-noto-sans font-bold uppercase italic line-clamp-2">
                    Takanori Nishikawa - Bright Burning Shout
                </div>
            </div>
        </div>
    </div>
    <div class="block">
        <div class="w-[19.9rem]">
            <img src="/img/player/default/akchan.webp" alt="" aria-label="hidden" class="w-full h-full" loading="lazy"/>
        </div>
    </div>
    <div class="flex flex-col">
        <div class="px-3 mb-10">
            <div class="bg-purple-mystic p-3 flex gap-2 justify-center items-center rounded-md">
                <div>
                    <img src="/svg/default/robot.svg" alt="" aria-hidden="true" class="w-15" loading="lazy"/>
                </div>
                <div class="font-noto-sans font-medium italic uppercase text-center leading-4">
                    Programação automática
                </div>
            </div>
        </div>
        <div class="w-full flex flex-col gap-2 mb-7 px-3">
            <div class="flex justify-center mb-1">
                <div>
                    <div class="ml-3 text-neutral-aurora text-xl font-noto-sans font-bold uppercase italic">
                        Dê o
                    </div>
                    <div class="font-noto-sans font-extrabold uppercase italic text-6xl text-blue-skywave">
                        Play
                    </div>
                </div>
                <button on:click={togglePlayPause} class="bg-blue-skywave cursor-pointer w-14 h-14 rounded-full flex justify-center items-center">
                    <img src="/svg/default/play.svg" alt="" aria-hidden="true" class="w-5" loading="lazy"/>                        
                </button>
            </div>
            <input   
                type="range" 
                name="volume" 
                id="volume" 
                class="w-full accent-orange-amber"
                min="0" 
                max="1" 
                step="0.01"
            />
        </div>
        <div class="cursor-pointer w-full py-2 px-1 border-1 border-neutral-aurora rounded-full text-blue-skywave text-xl text-center font-noto-sans font-bold italic uppercase">
            & Faça seu <strong class="text-orange-amber">Pedido</strong>
        </div>
    </div>
</section>

<section class="cont-player-main">
    <div class="mb-10 flex flex-wrap lg:flex-nowrap gap-5 justify-between">
        <div class="w-full h-[8rem] bg-neutral-aurora">
        </div>
        <div class="w-full h-[8rem] bg-neutral-aurora hidden lg:block">
        </div>
    </div>
</section>


