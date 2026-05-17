<script>
    import { useForm, page } from "@inertiajs/svelte";
    import { Preview, Wysiwyg } from "@/ui/components/private";
    import { hasPermission } from "@/utils";
    import { postTags } from "@/data";

    $: ({ post } = $page.props);

    let can = {
        create: hasPermission("post.create"),
        update: hasPermission("post.update") || hasPermission("post.update.own"),
    };

    let form = useForm({
        _method: "POST",
        type: null,
        image: null,
        title: null,
        cover: null,
        content: null,
        tags: [{ uuid: null }, { name: null }],
        references: [
            { uuid: null, name: null, url: null },
            { uuid: null, name: null, url: null },
        ],
    });

    $: if (post) {
        const tags = post.data.tags.map(
            ({ uuid, name }) => ({ uuid, name }),
        );
        const references = post.data.references.map(
            ({ uuid, name, url }) => ({ uuid, name, url }),
        );

        $form._method = "PATCH";
        $form.type = post.data.type;
        $form.image = post.data.image;
        $form.title = post.data.title;
        $form.cover = post.data.cover;
        $form.content = post.data.content;
        $form.tags = tags;
        $form.references = references;
    }

    const submit = (event) => {
        let url = post ? `/panel/post/${post.data.uuid}` : "/panel/post";

        $form.type = event.submitter.value;
        $form.post(url, {
            onSuccess: () => {
                post ? null : $form.reset();
            },
        });
    };
</script>

<form class="container-page mb-20" on:submit|preventDefault={submit}>
    <div class="px-40">
        <div class="mb-3">
            <div class="mb-8">
                <label for="title" class="text-orange-amber font-bold italic text-lg uppercase font-noto-sans block mb-1">
                    Título
                </label>
                <input
                    id="title"
                    type="text"
                    name="title"
                    class="w-full h-12 bg-blue-ocean border border-blue-skywave font-noto-sans text-neutral-white rounded-lg outline-none pl-4"
                    bind:value={$form.title}
                />
            </div>
            <div class="mb-8">
                <label for="cover" class="text-orange-amber font-bold italic text-lg uppercase font-noto-sans block mb-1">
                    Capa da matéria
                </label>
                <Preview
                    name="cover"
                    src={$form.cover}
                    oninput={(event)=>($form.cover = event.target.files[0])}
                    required={!post}
                />
            </div>
            <div class="mb-8">
                <label for="content" class="text-orange-amber font-bold italic text-lg uppercase font-noto-sans block mb-1">
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
    <div class="grid grid-cols-1 lg:grid-cols-[18rem_1fr] gap-5">
        <div class="block">
            <div class="text-orange-amber font-bold italic text-lg uppercase font-noto-sans block mb-1">
                Imagem em destaque
            </div>
            <Preview
                name="image"
                view="h-[18rem] rounded-lg"
                standard="h-[18rem] rounded-lg"
                src={$form.image}
                oninput={(event) => ($form.image = event.target.files[0])}
                required={!post}
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
        <div class="block">
            <div class="grid grid-cols-[0.4fr_1fr] gap-5 mb-15">
                <div>
                    <div class="text-center text-orange-amber font-bold italic text-lg uppercase font-noto-sans mb-5">
                        Tags
                    </div>
                    <div class="mb-6">
                        <label for="tags" class="text-blue-skywave font-bold italic text-md uppercase font-noto-sans block mb-1">
                            Primeira Tag
                        </label>
                        <select
                            id="tags"
                            name="tags"
                            class="w-full h-12 bg-neutral-white font-noto-sans rounded-full pl-4"
                            bind:value={$form.tags[0].name}
                        >
                            {#each Object.values(postTags) as item}
                                <option value={item.value}>
                                    {item.label}
                                </option>
                            {/each}
                        </select>
                    </div>
                    <div>
                        <label for="tags" class="text-blue-skywave font-bold italic text-md uppercase font-noto-sans block mb-1">
                            Segunda Tag
                        </label>
                        <select
                            id="tags"
                            name="tags"
                            class="w-full h-12 bg-neutral-white font-noto-sans rounded-full pl-4"
                            bind:value={$form.tags[1].name}
                        >
                            {#each Object.values(postTags) as item}
                                <option value={item.value}>
                                    {item.label}
                                </option>
                            {/each}
                        </select>
                    </div>
                    <div class="text-center text-neutral-gray font-light italic text-md uppercase font-noto-sans mt-5">
                        Escolha até 2 tags para a sua matéria
                    </div>
                </div>
                <div>
                    <div class="text-center text-orange-amber font-bold italic text-lg uppercase font-noto-sans mb-5">
                        Fontes
                    </div>
                    <div class="w-full flex mb-6">
                        <div class="flex-1">
                            <label for="references" class="text-blue-skywave font-bold italic text-md uppercase font-noto-sans block mb-1">
                                Nome:
                            </label>
                            <input
                                id="references"
                                type="text"
                                name="references"
                                class="w-full h-12 bg-neutral-white border-r border-blue-marinho font-noto-sans rounded-l-full pl-4"
                                bind:value={$form.references[0].name}
                            />
                        </div>
                        <div class="flex-1">
                            <label for="references" class="text-blue-skywave font-bold italic text-md uppercase font-noto-sans block mb-1">
                                Link:
                            </label>
                            <input
                                id="references"
                                type="text"
                                name="references"
                                class="w-full h-12 bg-neutral-white font-noto-sans rounded-r-full pl-4"
                                bind:value={$form.references[0].url}
                            />
                        </div>
                    </div>
                    <div class="w-full flex">
                        <div class="flex-1">
                            <label for="references" class="text-blue-skywave font-bold italic text-md uppercase font-noto-sans block mb-1">
                                Nome:
                            </label>
                            <input
                                id="references"
                                type="text"
                                name="references"
                                class="w-full h-12 bg-neutral-white border-r border-blue-marinho font-noto-sans rounded-l-full pl-4"
                                bind:value={$form.references[1].name}
                            />
                        </div>
                        <div class="flex-1">
                            <label for="references" class="text-blue-skywave font-bold italic text-md uppercase font-noto-sans block mb-1">
                                Link:
                            </label>
                            <input
                                id="references"
                                type="text"
                                name="references"
                                class="w-full h-12 bg-neutral-white font-noto-sans rounded-r-full pl-4"
                                bind:value={$form.references[1].url}
                            />
                        </div>
                    </div>
                    <div class="text-center text-neutral-gray font-light italic text-md uppercase font-noto-sans mt-5">
                        Preencha até duas fontes de pesquisa usadas para montar a matéria
                    </div>
                </div>
            </div>
            {#if can.create || can.update}
                <div class="w-full flex flex-wrap gap-4 justify-start">
                    <button
                        type="submit"
                        value="draft"
                        class="cursor-pointer font-noto-sans font-extrabold italic uppercase text-blue-marinho py-2 px-6 rounded-full bg-green-forest"
                    >
                        {#if post?.data.type === "draft"}
                            Atualizar rascunho
                        {:else if post?.data.type === "revision" || post?.data.type === "published"}
                            Converter para rascunho
                        {:else}
                            Salvar como rascunho
                        {/if}
                    </button>
                    {#if post?.data.type !== "revision" && post?.data.type !== "published"}
                        <button
                            type="submit"
                            value="revision"
                            class="cursor-pointer font-noto-sans font-extrabold italic uppercase text-blue-marinho py-2 px-6 rounded-full bg-orange-citric"
                        >
                            Mandar pra revisão
                        </button>
                    {/if}
                    <button aria-label=""
                        type="submit"
                        value="published"
                        class="cursor-pointer font-noto-sans font-extrabold italic uppercase text-neutral-white py-2 px-6 rounded-full bg-blue-ocean"
                    >
                        {post?.data.type === "published" ? "Atualizar matéria" : "Publicar matéria"}
                    </button>
                </div>
            {/if}
        </div>
    </div>
</form>
