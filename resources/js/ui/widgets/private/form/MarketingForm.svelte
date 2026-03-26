<script>
    export let close = () => {};
    export let identifier;

    import { useForm } from "@inertiajs/svelte";
    import { Preview } from "@/ui/components/private";
    import { hasPermission } from "@/utils";

    let permissions = {
        create: hasPermission('repository.create'),
        update: hasPermission('repository.update')
    }

    let form = useForm({
        _method: null,
        image: null,
        name: null,
        type: null,
        url: null
    });

    $: if (identifier) {
        axios.get(`/painel/marketing/repository/${identifier}`)
        .then((response) => {
            const data = response.data.data;

            $form._method = "PATCH"
            $form.image = data.image;
            $form.name = data.name;
            $form.type = data.type;
            $form.url = data.url;
        })
        .catch(()=>{
            console.error('Error when find file selected');
            close();
        })
    }

    const submit = () => {
        let url = identifier ? 
            `/painel/marketing/repository/${identifier}` : 
            '/painel/marketing/repository';
            
        $form.post(url, {
            onSuccess: ()=>close()
        });
    }
</script>

<form on:submit|preventDefault={submit}>
    <div class="mb-4">
        <Preview 
            name="image" 
            standard="w-full h-[10rem] rounded-lg"
            src={$form.image}
            oninput={event => $form.image = event.target.files[0]}
            required={!identifier}
        />
    </div>
    <div class="mb-4">
        <label class="text-md text-gray-700 font-noto-sans block mb-1" for="name">
            Nome do arquivo
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
        <label class="text-md text-gray-700 font-noto-sans block mb-1" for="type">
            Categoria do arquivo
        </label>
        <select 
            id="type" 
            name="type"
            class="w-full h-10 bg-white font-noto-sans text-md rounded-lg outline-none pl-4 border border-gray-400"
            bind:value={$form.type}
            required
        >
            <option value="tutorial">Tutoriais</option>
            <option value="software">Programas</option>
            <option value="package">Pacotes</option>
        </select>
    </div>
    <div class="mb-4">
        <label class="text-md text-gray-700 font-noto-sans block mb-1" for="url">
            URL do conteúdo hospedado externamente
        </label>
        <input 
            id="url"
            type="url" 
            name="url" 
            class="w-full h-10 bg-white font-noto-sans text-md rounded-lg outline-none pl-4 border border-gray-400" 
            bind:value={$form.url}
            required
        />
    </div>
    {#if permissions.create && permissions.update}
        <button type="submit" class="cursor-pointer bg-blue-skywave px-8 py-2 rounded-md text-neutral-aurora font-noto-sans font-bold italic uppercase">
            {identifier ? 'Atualizar' : 'Cadastrar'}
        </button>
    {/if}
</form>