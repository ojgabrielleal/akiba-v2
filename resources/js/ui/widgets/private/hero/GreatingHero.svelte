<script>
    import { page, Link } from "@inertiajs/svelte";

    let chosenPhrase;
    const generatePhrases = () => {
        let phrases = [
            `Okaeri.`,
            `Yokoso.`,
            `Konnichiwa.`,
            `Itadakimasu.`,
            `Oi oi oi...`,
            `Gankin desu ka?`,
            `Moshi moshi.`,
            `Ogenki desu ka?`,
            `Yoroshiku onegaishimasu.`,
            `Moshi moshi, konnichiwa!`,
            `Yare Yare...`,

        ];

        let index = Math.floor(Math.random() * phrases.length);
        return phrases[index];
    };

    chosenPhrase = generatePhrases();
</script>

<section class="w-full bg-gradient-with-texture">
    <div class="h-30 container-page flex items-center gap-5 relative">
        <img
            src="/img/default/avatar.webp"
            alt="Avatar"
            class="w-40 h-40 absolute bottom-0"
        />
        <div class="font-noto-sans font-bold uppercase italic text-3xl text-neutral-white ml-50">
            {chosenPhrase}
        </div>
        <div class="flex gap-2 absolute right-0">
            <Link class="w-30 bg-blue-marinho p-2 rounded-lg flex justify-center items-center flex-col gap-2 font-noto-sans font-bold text-[0.7rem] text-orange-citric text-center uppercase italic" href="/post">
                <img
                    src="/svg/events.svg"
                    alt=""
                    aria-hidden="true"
                    class="w-6 filter-orange-citric"
                />
                Criar evento
            </Link>
            <Link class="w-30 bg-blue-marinho p-2 rounded-lg flex justify-center items-center flex-col gap-2 font-noto-sans font-bold text-[0.7rem] text-orange-citric text-center uppercase italic" href="/post">
                <img
                    src="/svg/alerts.svg"
                    alt=""
                    aria-hidden="true"
                    class="w-6 filter-orange-citric"
                />
                Adicionar avisos
            </Link>
            <Link class="w-30 bg-blue-marinho p-2 rounded-lg flex justify-center items-center flex-col gap-2 font-noto-sans font-bold text-[0.7rem] text-orange-citric text-center uppercase italic" href="/post">
                <img
                    src="/svg/download.svg"
                    alt=""
                    aria-hidden="true"
                    class="w-6 filter-orange-citric"
                />
                Upar arquivos
            </Link>
            <Link class="w-30 bg-blue-marinho p-2 rounded-lg flex justify-center items-center flex-col gap-2 font-noto-sans font-bold text-[0.7rem] text-orange-citric text-center uppercase italic" href="/post">
                <img
                    src="/svg/locution.svg"
                    alt=""
                    aria-hidden="true"
                    class="w-6 filter-orange-citric"
                />
                Locutar
            </Link>
            <Link class="w-30 bg-blue-marinho p-2 rounded-lg flex justify-center items-center flex-col gap-2 font-noto-sans font-bold text-[0.7rem] text-orange-citric text-center uppercase italic" href="/post">
                <img
                    src="/svg/materials.svg"
                    alt=""
                    aria-hidden="true"
                    class="w-6 filter-orange-citric"
                />
                Criar matéria
            </Link>
        </div>
    </div>
</section>