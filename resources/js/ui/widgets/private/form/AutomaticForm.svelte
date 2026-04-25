<script>
    export let identifier;
    export let close = () => {};

    import axios from "axios";
    import { useForm, page } from "@inertiajs/svelte";
    import { Preview, Modal } from "@/ui/components/private";
    import { hasPermission } from "@/utils";
    import { locutionIcons } from "@/data";

    $: ({ users } = $page.props);

    let form = useForm({
        _method: "POST",
        image: null,
        user: null,
        name: null,
        is_default: false,
        phrases: Array.from({ length: 7 }, () => ({ image: null, phrase: "" })),
    });

    let modalRef;
    let currentPhraseIndex = null;

    if (identifier) {
        axios
            .get(`/panel/administration/automatic/${identifier}`)
            .then((response) => {
                const data = response.data.data;

                $form._method = "PATCH";
                $form.image = data.image;
                $form.user = data.host.uuid;
                $form.name = data.name;
                $form.is_default = data.is_default;

                if (data.phrases && data.phrases.length > 0) {
                    $form.phrases = data.phrases.map((p) => ({
                        image: p.image || null,
                        phrase: p.phrase || "",
                    }));

                    // Ensure we always have 7 fields
                    while ($form.phrases.length < 7) {
                        $form.phrases.push({ image: null, phrase: "" });
                    }
                }
            })
            .catch(() => {
                console.error("Error when find automatic selected");
                close();
            });
    }

    const submit = () => {
        let url = identifier
            ? `/panel/administration/automatic/${identifier}`
            : "/panel/administration/automatic";

        $form.post(url, {
            preserveScroll: true,
            onFinish: () => close(),
        });
    };
</script>

<Modal bind:this={modalRef} title="Selecione um Ícone">
    <div slot="content">
        <div class="grid grid-cols-3 sm:grid-cols-4 gap-4 overflow-y-auto max-h-[50vh] p-1">
            {#each locutionIcons as icon}
                <button
                    type="button"
                    class="aspect-square rounded-lg border-2 border-transparent hover:border-blue-skywave transition-all bg-gray-100 overflow-hidden group"
                    on:click={() => { $form.phrases[currentPhraseIndex].image = icon.url; modalRef.close(); }}
                >
                    <img
                        src={icon.url}
                        alt={icon.alt}
                        class="w-full h-full object-cover group-hover:scale-110 transition-transform"
                        loading="lazy"
                    />
                </button>
            {/each}
        </div>
    </div>
</Modal>

<form on:submit|preventDefault={submit}>
    <div class="mb-4">
        <Preview
            standard="w-full h-[10rem] rounded-lg"
            name="image"
            src={$form.image}
            oninput={(event) => ($form.image = event.target.files[0])}
            required={!identifier}
        />
    </div>
    <div class="mb-4">
        <label for="user" class="text-md text-gray-700 font-noto-sans block mb-1">
            Locutor responsável
        </label>
        <select
            id="user"
            name="user"
            class="w-full h-10 bg-white font-noto-sans text-md rounded-lg outline-none pl-4 border border-gray-400"
            bind:value={$form.user}
            required
        >
            <option
                value={null}
                disabled
                selected
            >
                Selecione um locutor
            </option>
            {#each users.data as user}
                <option value={user.uuid}>
                    {user.nickname}
                </option>
            {/each}
        </select>
    </div>
    <div class="mb-4">
        <label for="name" class="text-md text-gray-700 font-noto-sans block mb-1">
            Nome
        </label>
        <input
            type="text"
            id="name"
            name="name"
            class="w-full h-10 bg-white font-noto-sans text-md rounded-lg outline-none pl-4 border border-gray-400"
            bind:value={$form.name}
            required
        />
    </div>
    <div class="mb-4">
        <div class="text-md text-gray-700 font-noto-sans mb-2">
            Este AUTO DJ é o padrão para tocar?
        </div>
        <div class="flex items-center gap-2 mb-1">
            <input
                id="is_default_true"
                type="radio"
                name="is_default"
                value={true}
                class="cursor-pointer w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500"
                bind:group={$form.is_default}
            />
            <label for="is_default_true" class="cursor-pointer text-md text-gray-700 font-noto-sans">
                Sim
            </label>
        </div>
        <div class="flex items-center gap-2">
            <input
                id="is_default_false"
                type="radio"
                name="is_default"
                value={false}
                class="cursor-pointer w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500"
                bind:group={$form.is_default}
            />
            <label for="is_default_false" class="cursor-pointer text-md text-gray-700 font-noto-sans">
                Não
            </label>
        </div>
    </div>

    <div class="mt-8 mb-4">
        <div class="flex items-center justify-center w-full mt-8 mb-5">
            <div class="relative w-full">
                <div class="absolute left-0 w-1/4 h-[0.1rem] bg-blue-skywave rounded-full top-1/2 -translate-y-1/2"></div>
                <span class="absolute inset-0 flex items-center justify-center text-blue-skywave font-noto-sans font-bold uppercase italic">
                    Frases e Ícones
                </span>
                <div class="absolute right-0 w-1/4 h-[0.1rem] bg-blue-skywave rounded-full top-1/2 -translate-y-1/2"></div>
            </div>
        </div>
        {#each $form.phrases as item, index}
            <div class="flex items-center gap-4 mb-4 p-3 border border-gray-200 rounded-lg bg-gray-50/50">
                <button
                    type="button"
                    class="w-24 h-24 shrink-0 bg-suspense-aurora border-2 border-dashed border-gray-300 rounded-md overflow-hidden flex items-center justify-center cursor-pointer"
                    on:click={() => { currentPhraseIndex = index; modalRef.open(); }}
                >
                    {#if item.image}
                        <img
                            src={item.image}
                            alt=""
                            aria-hidden="true"
                            class="w-full h-full object-cover"
                        />
                    {:else}
                        <span class="text-blue-skywave text-3xl font-bold"
                            >+</span
                        >
                    {/if}
                </button>
                <div class="flex-1">
                    <label for={`phrase_text_${index}
                        } class="text-sm text-gray-600 font-noto-sans block mb-1">
                        Frase {index + 1}
                    </label>
                    <input
                        type="text"
                        id={`phrase_text_${index}} class="w-full h-10 bg-white font-noto-sans text-sm rounded-lg outline-none px-3 border border-gray-400" bind:value={item.phrase}
                    />
                </div>
            </div>
        {/each}
    </div>

    <div class="mt-6">
        <button
            aria-label=""
            type="submit"
            class="cursor-pointer bg-blue-skywave px-8 py-2 rounded-md text-suspense-aurora font-noto-sans font-bold italic uppercase"
        >
            {identifier ? "Atualizar" : "Cadastrar"}
        </button>
    </div>
</form>
