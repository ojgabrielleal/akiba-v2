<script>
    export let close = () => {};
    export let identifier;

    import axios from "axios";
    import { useForm, page } from "@inertiajs/svelte";
    import { hasPermission } from "@/utils";

    $: ({ users } = $page.props);

    let can = {
        create: hasPermission("task.create"),
        update: hasPermission("task.update"),
    };

    let form = useForm({
        user: null,
        title: null,
        dead_line: null,
        content: null,
    });

    if (identifier) {
        axios.get(`/panel/administration/task/${identifier}`)
            .then((response) => {
                const data = response.data.data;

                $form.user = data.responsible.uuid;
                $form.title = data.title;
                $form.dead_line = data.dead_line;
                $form.content = data.content;
            })
            .catch((err) => {
                console.error("Error when find task selected", err);
                close();
            });
    }

    const submit = () => {
        const method = identifier ? "patch" : "post";
        let url = identifier
            ? `/panel/administration/task/${identifier}`
            : "/panel/administration/task";

        $form[method](url, {
            preserveScroll: true,
            onFinish: () => close(),
        });
    };
</script>

<form on:submit|preventDefault={submit}>
    <div class="mb-4">
        <label class="text-md text-gray-700 font-noto-sans block mb-1" for="user">
            Membro responsável
        </label>
        <select
            id="user"
            name="user"
            class="w-full h-10 bg-white font-noto-sans text-md rounded-lg outline-none pl-4 border border-gray-400"
            bind:value={$form.user}
            required
        >
            <option value="">Selecione um membro</option>
            {#each users.data as user}
                <option value={user.uuid}>
                    {user.nickname}
                </option>
            {/each}
        </select>
    </div>
    <div class="mb-4">
        <label class="text-md text-gray-700 font-noto-sans block mb-1" for="title">
            Título
        </label>
        <input
            id="title"
            type="text"
            name="title"
            class="w-full h-10 bg-white font-noto-sans text-md rounded-lg outline-none pl-4 border border-gray-400"
            bind:value={$form.title}
            required
        />
    </div>
    <div class="mb-4">
        <label class="text-md text-gray-700 font-noto-sans block mb-1" for="dead_line">
            Data de vencimento
        </label>
        <input
            id="dead_line"
            type="date"
            name="dead_line"
            class="w-full h-10 bg-white font-noto-sans text-md rounded-lg outline-none pl-4 border border-gray-400"
            bind:value={$form.dead_line}
            required
        />
    </div>
    <div class="mb-4">
        <label class="text-md text-gray-700 font-noto-sans block mb-1" for="content">
            Descrição
        </label>
        <textarea
            id="content"
            name="content"
            rows="5"
            class="w-full bg-white font-noto-sans text-md rounded-lg outline-none py-2 px-4 border border-gray-400"
            bind:value={$form.content}
            required
        ></textarea>
    </div>
    {#if can.create || can.update}
        <button type="submit" class="cursor-pointer bg-blue-skywave px-8 py-2 rounded-md text-neutral-aurora font-noto-sans font-bold italic uppercase">
            {identifier ? "Atualizar" : "Cadastrar"}
        </button>
    {/if}
</form>