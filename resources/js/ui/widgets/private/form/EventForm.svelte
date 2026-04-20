<script>
    import { useForm, page, Link } from "@inertiajs/svelte";
    import { Section, Preview, Wysiwyg } from "@/ui/components/private";
    import { hasPermission } from "@/utils";

    $: ({ event } = $page.props);

    let can = {
        create: hasPermission("event.create"),
        update: hasPermission("event.update"),
    };

    let form = useForm({
        _method: null,
        image: null,
        title: null,
        cover: null,
        content: null,
        dates: null,
        address: null,
    });

    $: if (event) {
        ($form._method = "PATCH"),
            ($form.image = event.data.image),
            ($form.title = event.data.title),
            ($form.cover = event.data.cover),
            ($form.content = event.data.content),
            ($form.dates = event.data.dates),
            ($form.address = event.data.address);
    }

    const submit = () => {
        let url = event
            ? `/panel/event/${event.data.uuid}`
            : "/panel/event";

        $form.post(url, {
            onSuccess: () => {
                event ? null : $form.reset();
            },
        });
    };
</script>

<Section title={event ? "Atualizar evento" : "Criar evento"}>
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
    <form on:submit|preventDefault={submit} class="mt-10 xl:mt-25">
        <div class="grid grid-cols-1 xl:grid-cols-[20rem_1fr]gap-5">
            <div class="mb-3">
                <div class="text-orange-amber font-bold italic text-lg uppercase font-noto-sans mb-1">
                    Imagem em destaque
                </div>
                <Preview
                    name="image"
                    src={$form.image}
                    oninput={(event) => ($form.image = event.target.files[0])}
                    required={!event}
                />
                <ul class="mt-4 ml-5 list-disc font-noto-sans font-light text-orange-sunset">
                    <li>
                       <strong>Tamanho:</strong> 708x827
                    </li>
                    <li>
                        <strong>Fundo:</strong> Transparente
                    </li>
                </ul>
            </div>
            <div class="mb-3">
                <div class="mb-8">
                    <label class="text-orange-amber font-bold italic text-lg uppercase font-noto-sans block mb-1" for="title">
                        Nome do evento
                    </label>
                    <input
                        id="title"
                        type="text"
                        name="title"
                        class="w-full h-12 bg-neutral-aurora font-noto-sans rounded-lg outline-none pl-4"
                        bind:value={$form.title}
                        required
                    />
                </div>
                <div class="mb-8">
                    <label class="text-orange-amber font-bold italic text-lg uppercase font-noto-sans block mb-1" for="cover">
                        Capa do evento
                    </label>
                    <Preview
                        name="cover"
                        standard="w-full h-[30rem] rounded-lg"
                        view="w-full max-h-[30rem] object-cover object-center rounded-lg bg-neutral-aurora"
                        src={$form.cover}
                        oninput={(event) =>
                            ($form.cover = event.target.files[0])}
                        required={!event}
                    />
                </div>
                <div class="mb-8">
                    <label class="text-orange-amber font-bold italic text-lg uppercase font-noto-sans block mb-1" for="content">
                        Escreva sobre o evento
                    </label>
                    <Wysiwyg
                        name="content"
                        bind:value={$form.content}
                        required
                    />
                </div>
            </div>
        </div>
        <div class="w-full xl:w-7xl 2xl:w-340 ml-auto">
            <div class="gap-3 grid grid-cols-1 xl:grid-cols-2 xl:gap-10">
                <div>
                    <div class="grid grid-cols-1 xl:grid-cols-[5rem_1fr] items-center">
                        <label class="text-orange-amber font-light text-xl uppercase font-noto-sans block mb-1" for="local">
                            Local:
                        </label>
                        <input
                            id="local"
                            type="text"
                            name="local"
                            class="w-full h-12 bg-neutral-aurora font-noto-sans rounded-lg outline-none pl-4"
                            bind:value={$form.address}
                            required
                        />
                    </div>
                </div>
                <div>
                    <div class="grid grid-cols-1 xl:grid-cols-[5rem_1fr] items-center">
                        <label class="text-orange-amber font-light text-xl uppercase font-noto-sans block mb-1" for="datas">
                            Datas:
                        </label>
                        <input
                            id="datas"
                            type="text"
                            name="datas"
                            class="w-full h-12 bg-neutral-aurora font-noto-sans rounded-lg outline-none pl-4"
                            bind:value={$form.dates}
                            required
                        />
                    </div>
                </div>
            </div>
        </div>
        <div class="flex flex-wrap gap-4 justify-center lg:flex-nowrap mt-10">
            {#if can.create || can.update}
                <button type="submit" value="published" class="cursor-pointer w-full lg:w-auto py-2 px-6 border-4 border-solid border-blue-skywave rounded-xl text-blue-skywave text-xl font-bold font-noto-sans italic uppercase">
                    {event ? "Atualizar evento" : "Publicar evento"}
                </button>
            {/if}
        </div>
    </form>
</Section>
