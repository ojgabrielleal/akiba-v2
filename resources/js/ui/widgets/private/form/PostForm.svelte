<script>
    import { useForm, page, Link } from "@inertiajs/svelte";
    import { Section, Preview, Wysiwyg } from "@/ui/components/private";
    import { hasPermission } from "@/utils";
    import { postTags } from "@/data";

    $: ({ post } = $page.props);

    let can = {
        create: hasPermission("post.create"),
        update:hasPermission("post.update") && hasPermission("post.update.own"),
        review : {
            create: hasPermission("review.create"),
        },
        event : {
            create: hasPermission("event.create"),
        }
    };

    let form = useForm({
        _method: "POST",
        type: null,
        image: null,
        title: null,
        cover: null,
        content: null,
        categories: [{ uuid: null }, { name: null }],
        references: [
            { uuid: null, name: null, url: null },
            { uuid: null, name: null, url: null },
        ],
    });

    $: if (post) {
        const categories = (post.data.categories || []).map(({ uuid, name }) => ({ uuid, name }));
        const references = (post.data.references || []).map(({ uuid, name, url }) => ({ uuid, name, url }));

        while (categories.length < 2) {
            categories.push({ uuid: null, name: null });
        }

        while (references.length < 2) {
            references.push({ uuid: null, name: null, url: null });
        }

        $form._method = "PATCH";
        $form.type = post.data.type;
        $form.image = post.data.image;
        $form.title = post.data.title;
        $form.cover = post.data.cover;
        $form.content = post.data.content;
        $form.categories = categories;
        $form.references = references;
    }

    const submit = (event) => {
        let url = post
            ? `/panel/post/${post.data.uuid}`
            : "/panel/post";

        $form.type = event.submitter.value;

        $form.post(url, {
            onSuccess: () => {
                post ? null : $form.reset();
            },
        });
    };
</script>

<Section title={post ? `Atualizar matéria` : "Criar matéria"}>
    <div class="flex flex-wrap gap-4 justify-center lg:flex-nowrap">
        {#if can.create}
            <Link preserveState={false} href="/panel/post" class="cursor-pointer border-4 border-solid border-blue-skywave rounded-xl text-blue-skywave text-center text-xl uppercase italic font-noto-sans font-bold w-full lg:w-auto py-2 px-6">
                Matérias
            </Link>
        {/if}
        {#if can.review.create}
            <Link preserveState={false} href="/panel/review" class="cursor-pointer border-4 border-solid border-purple-mystic rounded-xl text-purple-mystic text-xl text-center uppercase italic font-noto-sans font-bold w-full lg:w-auto py-2 px-6">
                Reviews
            </Link>
        {/if}
        {#if can.event.create}
            <Link preserveState={false} href="/panel/event" class="cursor-pointer border-4 border-solid border-orange-copper rounded-xl text-orange-copper text-xl text-center uppercase italic font-noto-sans font-bold w-full lg:w-auto py-2 px-6">
                Eventos
            </Link>
        {/if}
    </div>
    <form on:submit|preventDefault={submit} class="mt-10 xl:mt-15">
        <div class="grid grid-cols-1 xl:grid-cols-[20rem_1fr] gap-5">
            <div class="mb-3">
                <div class="text-orange-amber font-bold italic text-lg uppercase font-noto-sans block mb-1">
                    Imagem em destaque
                </div>
                <Preview
                    name="image"
                    src={$form.image}
                    oninput={(event) => ($form.image = event.target.files[0])}
                    required={!post}
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
                        Título
                    </label>
                    <input
                        id="title"
                        type="text"
                        name="title"
                        class="w-full h-12 bg-neutral-aurora font-noto-sans rounded-lg outline-none pl-4"
                        bind:value={$form.title}
                    />
                </div>
                <div class="mb-8">
                    <label class="text-orange-amber font-bold italic text-lg uppercase font-noto-sans block mb-1" for="cover">
                        Capa da matéria
                    </label>
                    <Preview
                        name="cover"
                        standard="w-full h-[30rem] rounded-lg"
                        view="w-full max-h-[30rem] object-cover object-center rounded-lg bg-neutral-aurora"
                        src={$form.cover}
                        oninput={(event) => ($form.cover = event.target.files[0])}
                        required={!post}
                    />
                </div>
                <div class="mb-8">
                    <label class="text-orange-amber font-bold italic text-lg uppercase font-noto-sans block mb-1" for="content">
                        Escreva sua matéria
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
            <div class="gap-2 grid grid-cols-1 md:grid-cols-2 md:gap-10">
                <div class="mb-8">
                    <label class="text-blue-skywave font-bold italic text-lg text-center uppercase font-noto-sans block mb-1" for="categories">
                        Primeira Tag
                    </label>
                    <select
                        id="categories"
                        name="categories"
                        class="w-full h-12 bg-neutral-aurora font-noto-sans rounded-lg pl-4"
                        bind:value={$form.categories[0].name}
                    >
                        {#each Object.values(postTags) as item}
                            <option value={item.value}>{item.label}</option>
                        {/each}
                    </select>
                </div>
                <div class="mb-8">
                    <label class="text-blue-skywave font-bold italic text-lg text-center uppercase font-noto-sans block mb-1" for="categories">
                        Segunda Tag
                    </label>
                    <select
                        id="categories"
                        name="categories"
                        class="w-full h-12 bg-neutral-aurora font-noto-sans rounded-lg pl-4"
                        bind:value={$form.categories[1].name}
                    >
                        {#each Object.values(postTags) as item}
                            <option value={item.value}>{item.label}</option>
                        {/each}
                    </select>
                </div>
            </div>
            <div class="gap-5 grid grid-cols-1 lg:grid-cols-2 lg:gap-10">
                <div>
                    <div class="text-center text-orange-amber font-bold italic text-lg uppercase font-noto-sans mb-1">
                        Primeira fonte de pesquisa
                    </div>
                    <div class="grid grid-cols-1 xl:grid-cols-[5rem_1fr] items-center mb-4">
                        <label class="text-orange-amber font-light text-xl uppercase font-noto-sans block mb-1" for="references">
                            Nome:
                        </label>
                        <input
                            id="references"
                            type="text"
                            name="references"
                            class="w-full h-12 bg-neutral-aurora font-noto-sans rounded-lg outline-none pl-4"
                            bind:value={$form.references[0].name}
                        />
                    </div>
                    <div class="grid grid-cols-1 xl:grid-cols-[5rem_1fr] items-center">
                        <label class="text-orange-amber font-light text-xl uppercase font-noto-sans block mb-1" for="references">
                            Link:
                        </label>
                        <input
                            id="references"
                            type="text"
                            name="references"
                            class="w-full h-12 bg-neutral-aurora font-noto-sans rounded-lg outline-none pl-4"
                            bind:value={$form.references[0].url}
                        />
                    </div>
                </div>
                <div>
                    <div class="text-center text-orange-amber font-bold italic text-lg uppercase font-noto-sans mb-1">
                        Segunda fonte de pesquisa
                    </div>
                    <div class="grid grid-cols-1 xl:grid-cols-[5rem_1fr] items-center mb-4">
                        <label class="text-orange-amber font-light text-xl uppercase font-noto-sans block mb-1" for="references">
                            Nome:
                        </label>
                        <input
                            id="references"
                            type="text"
                            name="references"
                            class="w-full h-12 bg-neutral-aurora font-noto-sans rounded-lg outline-none pl-4"
                            bind:value={$form.references[1].name}
                        />
                    </div>
                    <div class="grid grid-cols-1 xl:grid-cols-[5rem_1fr] items-center">
                        <label class="text-orange-amber font-light text-xl uppercase font-noto-sans block mb-1" for="references">
                            Link:
                        </label>
                        <input
                            id="references"
                            type="text"
                            name="references"
                            class="w-full h-12 bg-neutral-aurora font-noto-sans rounded-lg outline-none pl-4"
                            bind:value={$form.references[1].url}
                        />
                    </div>
                </div>
            </div>
        </div>
        {#if can.create || can.update}
            <div class="flex flex-wrap gap-4 justify-center lg:flex-nowrap mt-15">
                <button type="submit" value="draft" class="cursor-pointer w-full lg:w-auto py-2 px-6 border-4 border-solid border-green-forest rounded-xl text-green-forest text-xl font-bold font-noto-sans italic uppercase">
                    {#if post?.data.type === "draft"}
                        Atualizar rascunho
                    {:else if post?.data.type === "revision" || post?.data.type === "published"}
                        Converter para rascunho
                    {:else}
                        Salvar como rascunho
                    {/if}
                </button>
                {#if post?.data.type !== "revision" && post?.data.type !== "published"}
                    <button type="submit" value="revision" class="cursor-pointer w-full lg:w-auto py-2 px-6 border-4 border-solid border-orange-amber rounded-xl text-orange-amber text-xl font-bold font-noto-sans italic uppercase">
                        Mandar pra revisão
                    </button>
                {/if}
                <button type="submit" value="published" class="cursor-pointer w-full lg:w-auto py-2 px-6 border-4 border-solid border-blue-skywave rounded-xl text-blue-skywave text-xl font-bold font-noto-sans italic uppercase">
                    {post?.data.type === "published" ? "Atualizar matéria" : "Publicar matéria"}
                </button>
            </div>
        {/if}
    </form>
</Section>
