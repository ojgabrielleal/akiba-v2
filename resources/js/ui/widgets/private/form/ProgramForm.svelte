<script>
    export let close = () => {};
    export let programUuid;

    import axios from "axios";
    import { useForm, page } from "@inertiajs/svelte";
    import { Preview } from "@/ui/components/private";
    import { programFormPermissions } from "@/utils";

    $: ({ users } = $page.props);

    let can = programFormPermissions();

    let form = useForm({
        _method: "POST",
        user: null,
        name: null,
        image: null,
        access_type: null,
        execution_mode: "live",
        schedules: [],
    });

    if (programUuid) {
        axios.get(`/panel/radio/program/${programUuid}`)
            .then((response) => {
                const data = response.data.data;

                $form._method = "PATCH";
                $form.user = data.host.uuid;
                $form.name = data.name;
                $form.image = data.image;
                $form.access_type = data.access_type;
                $form.execution_mode = data.execution_mode;
                $form.schedules = data.schedules;
            })
            .catch(() => {
                console.error("Error when find program selected");
                close();
            });
    }

    const submit = () => {
        let url = programUuid
            ? `/panel/radio/program/${programUuid}`
            : "/panel/radio/program";

        $form.post(url, {
            preserveScroll: true,
            onFinish: () => close(),
        });
    };

    const addSchedule = () => {
        $form.schedules = [
            ...$form.schedules,
            { uuid: null, hour: null, day: null },
        ];
    };

    const removeSchedule = (index) => {
        $form.schedules = $form.schedules.filter((_, i) => i !== index);
    };
</script>

<form on:submit|preventDefault={submit}>
    <div class="mb-4">
        <Preview
            size="compact"
            tone="muted"
            color="muted"
            name="image"
            src={$form.image}
            oninput={(event) => ($form.image = event.target.files[0])}
            required={!programUuid}
        />
    </div>
    <div class="mb-4">
        <label for="name" class="text-md text-gray-700 font-noto-sans block mb-1">
            Programa
        </label>
        <input
            id="name"
            type="text"
            name="name"
            class="w-full h-10 bg-white font-noto-sans text-md rounded-md outline-none pl-4 border border-gray-400"
            bind:value={$form.name}
            required
        />
    </div>
    <div class="mb-4">
        <div class="text-md text-gray-700 font-noto-sans mb-2">
            Este programa estará disponível para todos?
        </div>
        <div class="flex items-center gap-2 mb-1">
            <input
                id="open"
                type="radio"
                name="free"
                value="free"
                class="cursor-pointer w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500"
                bind:group={$form.access_type}
            />
            <label for="free" class="cursor-pointer text-md text-gray-700 font-noto-sans">
                Sim
            </label>
        </div>
        <div class="flex items-center gap-2">
            <input
                id="close"
                type="radio"
                name="private"
                value="private"
                class="cursor-pointer w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500"
                bind:group={$form.access_type}
            />
            <label for="private" class="cursor-pointer text-md text-gray-700 font-noto-sans">
                Não
            </label>
        </div>
    </div>
    {#if $form.access_type === "private"}
        <div class="mb-4">
            <label for="user" class="text-md text-gray-700 font-noto-sans block mb-1">
                Locutor
            </label>
            <select
                id="user"
                name="user"
                class="w-full h-10 bg-white font-noto-sans rounded-md outline-none pl-4 border border-gray-400"
                bind:value={$form.user}
                required
            >
                {#each users.data as item}
                    <option value={item.uuid}>
                        {item.nickname}
                    </option>
                {/each}
            </select>
        </div>
        {#if $form.schedules}
            <div class="flex items-center justify-center w-full mt-8 mb-5">
                <div class="relative w-full">
                    <div class="absolute left-0 w-1/3 h-[0.1rem] bg-blue-skywave rounded-full top-1/2 -translate-y-1/2"></div>
                    <span class="absolute inset-0 flex items-center justify-center text-blue-skywave font-noto-sans font-extrabold uppercase italic">
                        Horários
                    </span>
                    <div class="absolute right-0 w-1/3 h-[0.1rem] bg-blue-skywave rounded-full top-1/2 -translate-y-1/2"></div>
                </div>
            </div>
            <button
                type="button"
                class="cursor-pointer mb-2 flex items-center gap-[0.2rem] text-blue-skywave text-md font-noto-sans"
                on:click={() => addSchedule()}
            >
                <img
                    src="/svg/plus.svg"
                    alt=""
                    aria-hidden="true"
                    class="w-5 filter-blue-skywave"
                    loading="lazy"
                />
                Adicionar horário
            </button>
            {#each $form.schedules as schedule, index}
                <div class="mb-4 border border-gray-400 p-4 rounded-md">
                    <div class="mb-2">
                        <label for="day" class="text-md text-gray-700 font-noto-sans block mb-1">
                            Dia da semana
                        </label>
                        <select
                            id="day"
                            name="day"
                            class="w-full h-10 bg-white font-noto-sans text-md rounded-md outline-none pl-4 border border-gray-400"
                            bind:value={schedule.day}
                        >
                            <option value={0}>
                                Domingo
                            </option>
                            <option value={1}>
                                Segunda
                            </option>
                            <option value={2}>
                                Terça
                            </option>
                            <option value={3}>
                                Quarta
                            </option>
                            <option value={4}>
                                Quinta
                            </option>
                            <option value={5}>
                                Sexta
                            </option>
                            <option value={6}>
                                Sábado
                            </option>
                        </select>
                    </div>
                    <div class="mb-2">
                        <label for="hour" class="text-md text-gray-700 font-noto-sans block mb-1">
                            Horário
                        </label>
                        <input
                            id="hour"
                            type="time"
                            name="hour"
                            class="w-full h-10 bg-white font-noto-sans text-md rounded-md outline-none pl-4 border border-gray-400"
                            bind:value={schedule.hour}
                        />
                    </div>
                    <button
                        type="button"
                        class="cursor-pointer mt-4 flex items-center gap-[0.2rem] text-blue-skywave text-md font-noto-sans"
                        on:click={() => removeSchedule(index)}
                    >
                        <img
                            src="/svg/close.svg"
                            alt=""
                            aria-hidden="true"
                            class="w-5 filter-blue-skywave"
                            loading="lazy"
                        />
                        Remover
                    </button>
                </div>
            {/each}
        {/if}
    {/if}
    {#if can.create || can.update}
        <button
            aria-label=""
            type="submit"
            class="cursor-pointer bg-blue-skywave px-8 py-2 rounded-md text-suspense-aurora font-noto-sans font-extrabold italic uppercase"
        >
            {programUuid ? "Atualizar" : "Cadastrar"}
        </button>
    {/if}
</form>
