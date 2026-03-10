<script>
    export let close = () => {};
    export let identifier;

    import axios from "axios";
    import { useForm, page, router } from "@inertiajs/svelte";
    import { Preview } from "@/ui/components/private";

    $: ({ streamers } = $page.props);

    let form = useForm({
        _method: "POST",
        user: null,
        name: null,
        image: null,
        type: null,
        schedules: [],
    });
    
    $: if(identifier){
        axios.get(`/painel/radio/program/${identifier}`)
        .then((response)=>{
            const data = response.data.data;

            $form._method = "PATCH";
            $form.user = data.host.uuid;
            $form.name = data.name;
            $form.image = data.image;
            $form.type = data.type;
            $form.schedules = data.schedules;
        })
    }

    const submit = () => {   
        let url = identifier ? 
            `/painel/radio/program/${identifier}` : 
            '/painel/radio/program'

        $form.post(url, {
            onFinish: () => close(),
        });
    }

    const addSchedule = () => {
        $form.schedules = [
            ...$form.schedules,
            { hour: null, day: null }
        ]
    }

    const removeSchedule = (index) => {
        $form.schedules = $form.schedules.filter((_, i) => i !== index);
    };
</script>

<form on:submit|preventDefault={submit}>
    <div class="mb-4">
        <Preview
            standard="w-full h-[10rem] rounded-lg"
            name="image"
            src={$form.image}
            oninput={(event) => ($form.image = event.target.files[0])}
            required={identifier}
        />
    </div>
    <div class="mb-4">
        <label class="text-md text-gray-700 font-noto-sans block mb-1" for="name">
            Programa
        </label>
        <input
            id="name"
            type="text"
            name="name"
            class="w-full h-10 bg-white font-noto-sans text-md rounded-lg outline-none pl-4 border border-gray-400"
            bind:value={$form.name}
            required
        />
    </div>
    <div class="mb-4">
        <div class="text-md text-gray-700 font-noto-sans mb-2">
            Este programa estará disponível para todos os locutores?
        </div>
        <div class="flex items-center gap-2 mb-1">
            <input
                id="open"
                type="radio"
                name="free"
                value="free"
                class="cursor-pointer w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500"
                bind:group={$form.type}
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
                bind:group={$form.type}
            />
            <label for="private" class="cursor-pointer text-md text-gray-700 font-noto-sans">
                Não
            </label>
        </div>
    </div>
    {#if $form.type === 'private'}
        <div class="mb-4">
            <label class="text-md text-gray-700 font-noto-sans block mb-1" for="user">
                Locutor
            </label>
            <select
                id="user"
                name="user"
                class="w-full h-10 bg-white font-noto-sans rounded-lg outline-none pl-4 border border-gray-400"
                bind:value={$form.user}
                required
            >
                {#each streamers.data as item}
                    <option value={item.uuid}>{item.nickname}</option>
                {/each}
            </select>
        </div>
        <div class="flex items-center justify-center w-full mt-8 mb-5">
            <div class="relative w-full">
                <div class="absolute left-0 w-1/3 h-[0.1rem] bg-blue-skywave rounded-full top-1/2 -translate-y-1/2"></div>
                <span class="absolute inset-0 flex items-center justify-center text-blue-skywave font-noto-sans font-bold uppercase italic">
                    Horários
                </span>
                <div class="absolute right-0 w-1/3 h-[0.1rem] bg-blue-skywave rounded-full top-1/2 -translate-y-1/2"></div>
            </div>
        </div>
        <button on:click={()=>addSchedule()} type="button" class="cursor-pointer mb-2 flex items-center gap-[0.2rem] text-blue-skywave text-md font-noto-sans">
            <img src="/svg/default/plus.svg" alt="" aria-hidden="true" class="w-5 filter-blue-skywave" loading="lazy"/>
            Adicionar horário
        </button>
        {#each $form.schedules as schedule, index}
            <div class="mb-4 border border-gray-400 p-4 rounded-lg">
                <div class="mb-2">
                    <label class="text-md text-gray-700 font-noto-sans block mb-1" for="day">
                        Dia da semana
                    </label>
                    <select
                        id="day"
                        name="day"
                        class="w-full h-10 bg-white font-noto-sans text-md rounded-lg outline-none pl-4 border border-gray-400"
                        bind:value={schedule.day}
                    >
                        <option value={0}>Domingo</option>
                        <option value={1}>Segunda</option>
                        <option value={2}>Terça</option>
                        <option value={3}>Quarta</option>
                        <option value={4}>Quinta</option>
                        <option value={5}>Sexta</option>
                        <option value={6}>Sábado</option>
                    </select>
                </div>
                <div class="mb-2">
                    <label class="text-md text-gray-700 font-noto-sans block mb-1" for="hour">
                        Horário
                    </label>
                    <input
                        id="hour"
                        type="time"
                        name="hour"
                        class="w-full h-10 bg-white font-noto-sans text-md rounded-lg outline-none pl-4 border border-gray-400"
                        bind:value={schedule.hour}
                    />
                </div>
                <button on:click={() => removeSchedule(index)} type="button" class="cursor-pointer mt-4 flex items-center gap-[0.2rem] text-blue-skywave text-md font-noto-sans">
                    <img src="/svg/default/close.svg" alt="" aria-hidden="true" class="w-5 filter-blue-skywave" loading="lazy"/>
                    Remover
                </button>
            </div>
        {/each}
    {/if}
    <button type="submit" class="cursor-pointer bg-blue-skywave px-8 py-2 rounded-md text-neutral-aurora font-noto-sans font-bold italic uppercase">
        {#if identifier}
            Atualizar
        {:else}
            Cadastrar
        {/if}
    </button>
</form>
