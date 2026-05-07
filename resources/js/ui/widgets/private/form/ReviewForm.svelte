<script>
    import { page, useForm, Link } from "@inertiajs/svelte";
    import { Section, Preview, Wysiwyg } from "@/ui/components/private";
    import { hasPermission } from "@/utils";

    $: ({ user, review } = $page.props);

    let can = {
        create: hasPermission("review.create"),
        update: hasPermission("review.update"),
    };

    let form = useForm({
        _method: "POST",
        image: null,
        title: null,
        sinopse: null,
        cover: null,
        year_of_release: null,
        review: { uuid: null, content: null },
    });

    $: if (review) {
        $form._method = "PATCH";
        $form.image = review.data.image;
        $form.title = review.data.title;
        $form.sinopse = review.data.sinopse;
        $form.cover = review.data.cover;
        $form.year_of_release = review.data.year_of_release;
        $form.review = { uuid: null, content: "" };
    }

    const submit = () => {
        let url = review
            ? `/panel/review/${review?.data.uuid}`
            : `/panel/review`;

        $form.post(url, {
            onSuccess: () => {
                review ? null : $form.reset();
            },
        });
    };

    const reviews = () => {
        let verifyExistReview = review?.data.reviews.some(
            (item) => item.author.uuid === user.uuid,
        );

        if (verifyExistReview) {
            let reviewExisting = review.data.reviews.find(
                (item) => item.author.uuid === user.uuid,
            );
            let reviewRest = review.data.reviews.filter(
                (item) => item.author.uuid !== user.uuid,
            );

            $form.review.uuid = reviewExisting.uuid;
            $form.review.content = reviewExisting.content;
            return [reviewExisting, ...reviewRest];
        }

        let reviewGhost = {
            uuid: null,
            content: "Escreva o seu primeiro review",
            author: {
                uuid: user.uuid,
                name: user.name,
                nickname: user.nickname,
                avatar: user.avatar,
            },
        };

        $form.review.uuid = reviewGhost.uuid;
        $form.review.content = reviewGhost.content;
        return [reviewGhost, ...review?.data.reviews];
    };
</script>

<Section title={review ? "Atualizar review" : "Criar review"}>
    <div class="flex flex-wrap gap-4 justify-center lg:flex-nowrap">
        <Link preserveState={false} href="/panel/post" class="cursor-pointer border-4 border-solid border-blue-skywave rounded-xl text-blue-skywave text-center text-xl uppercase italic font-noto-sans font-bold w-full lg:w-auto py-2 px-6">
            Matérias
        </Link>
        <Link preserveState={false} href="/panel/review" class="cursor-pointer border-4 border-solid border-purple-mystic rounded-xl text-purple-mystic text-xl text-center uppercase italic font-noto-sans font-bold w-full lg:w-auto py-2 px-6">
            Reviews
        </Link>
        <Link preserveState={false} href="/panel/event" class="cursor-pointer border-4 border-solid border-orange-copper rounded-xl text-orange-copper text-xl text-center uppercase italic font-noto-sans font-bold w-full lg:w-auto py-2 px-6">
            Eventos
        </Link>
    </div>
    <form class="mt-10 lg:mt-15" on:submit|preventDefault={submit}>
        <div class="grid grid-cols-1 lg:grid-cols-[20rem_1fr] gap-5">
            <div class="mb-3">
                <div class="text-orange-amber font-bold italic text-lg uppercase font-noto-sans mb-2">
                    Imagem em destaque
                </div>
                <Preview
                    name="image"
                    src={$form.image}
                    oninput={(event) => ($form.image = event.target.files[0])}
                    required={!review}
                />
                <ul class="mt-4 ml-5 list-disc font-noto-sans font-light text-orange-citric">
                    <li>
                        <strong>Tamanho:</strong> 708x827
                    </li>
                    <li>
                        <strong>Fundo:</strong> Transparente
                    </li>
                </ul>
            </div>
            <div>
                <div class="mb-8">
                    <label for="title" class="text-orange-amber font-bold italic text-lg uppercase font-noto-sans block mb-2">
                        Nome do anime
                    </label>
                    <input
                        id="title"
                        type="text"
                        name="title"
                        class="w-full h-12 bg-suspense-aurora font-noto-sans rounded-lg outline-none pl-4"
                        bind:value={$form.title}
                        required
                    />
                </div>
                <div class="mb-8">
                    <label for="year_of_release" class="text-orange-amber font-bold italic text-lg uppercase font-noto-sans block mb-2">
                        Ano de lançamento
                    </label>
                    <input
                        id="year_of_release"
                        type="number"
                        name="year_of_release"
                        class="w-full h-12 bg-suspense-aurora font-noto-sans rounded-lg outline-none pl-4"
                        bind:value={$form.year_of_release}
                        required
                    />
                </div>
                <div class="mb-8">
                    <label for="sinopse" class="text-orange-amber font-bold italic text-lg uppercase font-noto-sans block mb-2">
                        Sinopse do anime
                    </label>
                    <Wysiwyg
                        height="15rem"
                        name="sinopse"
                        bind:value={$form.sinopse}
                        required
                    />
                </div>
                <div class="mb-8">
                    <label for="cover" class="text-orange-amber font-bold italic text-lg uppercase font-noto-sans block mb-2">
                        Capa do anime
                    </label>
                    <Preview
                        name="cover"
                        standard="w-full h-[25rem] rounded-lg"
                        view="w-full max-h-[25rem] object-cover object-center rounded-lg bg-suspense-aurora"
                        src={$form.cover}
                        oninput={(event)
                    >
                            ($form.cover = event.target.files[0])}
                        required={!review}
                    />
                </div>
                <div>
                    <label for="content" class="text-orange-amber font-bold italic text-lg uppercase font-noto-sans block mb-2">
                        Escreva sobre o anime
                    </label>
                    {#if review && reviews()}
                        <div class="flex gap-2 mb-4">
                            {#each reviews() as item}
                                <div class="relative">
                                    <button
                                        type="button"
                                        class={["py-2 px-6 rounded-md uppercase flex justify-center items-center font-noto-sans italic font-bold cursor-pointer", { "bg-orange-amber text-suspense-aurora": item.uuid === $form.review.uuid }, { "bg-suspense-aurora text-orange-amber": item.uuid !== $form.review.uuid }, ]}
                                        on:click={() => { $form.review.uuid = item.uuid; $form.review.content = item.content; }}
                                    >
                                        {item.author.nickname}
                                    </button>
                                </div>
                            {/each}
                        </div>
                    {/if}
                    <Wysiwyg
                        name="content"
                        required
                        bind:value={$form.review.content}
                    />
                </div>
            </div>
        </div>
        <div class="flex flex-wrap gap-4 justify-center lg:flex-nowrap mt-10">
            {#if can.create || can.update}
                <button
                    aria-label=""
                    type="submit"
                    class="cursor-pointer w-full lg:w-auto py-2 px-6 border-4 border-solid border-blue-skywave rounded-xl text-blue-skywave text-xl font-bold font-noto-sans italic uppercase"
                >
                    {$form.review.uuid ? "Atualizar review" : "Publicar review"}
                </button>
            {/if}
        </div>
    </form>
</Section>
