<script>
    export let close = () => {};
    export let identifier;

    import { useForm } from "@inertiajs/svelte";
    import axios from "axios";
    import { hasPermission } from "@/utils";

    let form = useForm({
        title: null,
        limit: null,
        hour: null,
        date: null,
        content: null,
    });

    const submit = () => {
        const method = identifier ? 
            'patch' : 
            'post';
        const url = identifier ? 
            `/painel/adms/activity/${identifier}` : 
            '/painel/adms/activity';
            
        $form[method](url, {
            onSuccess: () => close(),
        });
    }
</script>

<form on:submit|preventDefault={submit}>
    <div class="mb-4">
        <label for="title" class="text-md text-gray-700 font-noto-sans block mb-1">
            Título
        </label>
        <input 
            type="text" 
            id="title" 
            name="title" 
            class="w-full h-10 bg-white font-noto-sans text-md rounded-lg outline-none pl-4 border border-gray-400"
            bind:value={$form.title}
            required
        />
    </div>
    <div class="mb-4">
        <label for="limit" class="text-md text-gray-700 font-noto-sans block mb-1">
            Limite
        </label>
        <input 
            type="date" 
            id="limit" 
            name="limit" 
            class="w-full h-10 bg-white font-noto-sans text-md rounded-lg outline-none pl-4 border border-gray-400"
            bind:value={$form.limit}
            required
        />
        <div class="text-sm font-noto-sans text-gray-400 mt-1">
            Data limite para confirmação da atividade
        </div>
    </div>
    <div class="grid grid-cols-2 gap-3">
        <div class="mb-4">
            <label for="hour" class="text-md text-gray-700 font-noto-sans block mb-1">
                Hora
            </label>
            <input 
                type="time" 
                id="hour" 
                name="hour" 
                class="w-full h-10 bg-white font-noto-sans text-md rounded-lg outline-none pl-4 border border-gray-400"
                bind:value={$form.hour}
                required
            />
        </div>
        <div class="mb-4">
            <label for="date" class="text-md text-gray-700 font-noto-sans block mb-1">
                Data
            </label>
            <input 
                type="date" 
                id="date" 
                name="date" 
                class="w-full h-10 bg-white font-noto-sans text-md rounded-lg outline-none pl-4 border border-gray-400"
                bind:value={$form.date}
                required
            />
        </div>
    </div>
    <div class="mb-4">
        <label for="content" class="text-md text-gray-700 font-noto-sans block mb-1">
            Conteúdo
        </label>
        <textarea 
            id="content" 
            name="content" 
            rows="3"
            class="w-full bg-white font-noto-sans text-md rounded-lg outline-none py-2 px-4 border border-gray-400"
            bind:value={$form.content}
            required
        ></textarea>
    </div>
    <button type="submit" class="cursor-pointer bg-blue-skywave px-8 py-2 rounded-md text-neutral-aurora font-noto-sans font-bold italic uppercase">
        {identifier ? 'Atualizar' : 'Cadastrar'} 
    </button>
</form>