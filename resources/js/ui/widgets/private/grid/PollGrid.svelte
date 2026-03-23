<script>
    import { router, page } from "@inertiajs/svelte";
    import { Section } from "@/ui/components/private/";    
    import { Offcanvas } from "@/ui/components/private";
    import { PollForm } from "@/ui/widgets/private/form"
    import { hasPermission } from "@/utils";

    $: ({ polls } = $page.props);

    let permissions = {
        show_button_create: hasPermission('poll.create'),
        show_button_update: hasPermission('poll.update'),
        show_button_deactivate_poll: hasPermission('poll.deactivate'),
        show_button_create_vote: hasPermission('poll.create.vote')
    }

    let offcanvasRef;
    let identifier;

    let storageVotedPolls = JSON.parse(localStorage.getItem('voted') || '[]');

    const submitVote = (event, item) => {
        const form = event.target;
        const formData = new FormData(form);
        const option = formData.get('option');

        router.post(`/painel/medias/poll/vote/${option}`, {}, {
            onSuccess: () => {
                localStorage.setItem('voted', JSON.stringify(storageVotedPolls));
                storageVotedPolls.push(item.uuid);
                storageVotedPolls = storageVotedPolls;
            }
        });
    }

     const requestDeactivatePoll = (poll) => {
        router.delete(`/painel/medias/poll/${poll}`);
    }

</script>

<Offcanvas bind:this={offcanvasRef} title={identifier ? 'Atualizar enquete' : 'Cadastrar enquete'}>
    <div slot="content" let:close>
        <PollForm {identifier} {close}/>
    </div>
</Offcanvas>

{#if polls}
    <Section title="Enquetes">
        {#if permissions.show_button_create || permissions.show_button_update}
            <div class="flex justify-center">
                <button class="cursor-pointer text-neutral-aurora text-xl font-noto-sans font-bold uppercase italic rounded-sm py-1 px-3 bg-orange-amber" on:click={()=> {
                    offcanvasRef.open();
                    identifier = null;
                }}>
                    Criar enquete
                </button>
            </div>
        {/if}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-5 mt-10">
            {#if polls.data.length > 0}
                {#each polls.data as item}
                    {@const alreadyVoted = storageVotedPolls.includes(item.uuid)}
                    <form on:submit|preventDefault={(event) => submitVote(event, item)} class="flex flex-col justify-between gap-5 bg-blue-skywave p-5 rounded-md">
                        <div class="text-neutral-aurora text-xl text-start font-noto-sans font-bold">
                            {item.question}
                        </div>
                        <div class="flex flex-col gap-3">
                            {#each item.options as optitem}
                                <div class="inline-flex items-center">
                                    <label class="relative flex items-center cursor-pointer" for={optitem.uuid}>
                                        <input 
                                            id={optitem.uuid} 
                                            name="option" 
                                            type="radio" 
                                            class="peer h-5 w-5 cursor-pointer appearance-none rounded-full bg-neutral-aurora" 
                                            value={optitem.uuid} 
                                            disabled={alreadyVoted}
                                            required
                                        >
                                        <div class="absolute bg-blue-skywave w-2/4 h-2/4 rounded-full opacity-0 peer-checked:opacity-100 transition-opacity duration-200 top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2"></div>
                                    </label>
                                    <label class="w-full ml-2 flex justify-between text-neutral-aurora text-md font-noto-sans cursor-pointer" for={optitem.id}>
                                        <div>
                                            {optitem.option}
                                        </div>
                                        <div>
                                            {optitem.votes}
                                        </div>
                                    </label>
                                </div>
                            {/each}
                        </div>
                        <div class="flex justify-between">
                            {#if permissions.show_button_create_vote}
                                <button type="submit" class="cursor-pointer text-neutral-aurora text-md font-noto-sans font-bold uppercase italic rounded-sm py-1 px-3 bg-orange-amber disabled:opacity-50" disabled={alreadyVoted}>
                                    Votar
                                </button>
                            {/if}
                            <div class="flex gap-3">
                                {#if permissions.show_button_update}
                                    <button type="button" aria-label="Editar" class="cursor-pointer" on:click={()=> {
                                        offcanvasRef.open();
                                        identifier = item.uuid;
                                    }}>
                                        <img src="/svg/default/edit.svg" alt="" aria-hidden="true" class="w-5 filter-neutral-aurora" loading="lazy"/>
                                    </button>
                                {/if}
                                {#if permissions.show_button_deactivate_poll}
                                    <button type="button" class="cursor-pointer" aria-label="Desativar" on:click={()=>requestDeactivatePoll(item.uuid)}>
                                        <img src="/svg/default/trash.svg" alt="" aria-hidden="true" class="w-5 filter-neutral-aurora" loading="lazy"/>
                                    </button>
                                {/if}
                            </div>
                        </div>
                    </form>
                {/each}
            {:else}
                <article class="bg-blue-cerulean opacity-50 p-5 rounded-md pointer-events-none">
                    <div class="text-neutral-aurora text-xl text-start font-noto-sans font-bold mb-7">
                        Quem é o mais preguiçoso do time da Akiba até agora?
                    </div>
                    <dl class="flex flex-col gap-3 mb-7">
                        <dt class="inline-flex items-center">
                            <label class="relative flex items-center cursor-pointer" for="option">
                                <input 
                                    id="option"
                                    name="option" 
                                    type="radio" 
                                    class="peer h-5 w-5 cursor-pointer appearance-none rounded-full bg-neutral-aurora" 
                                >
                                <div class="absolute bg-blue-skywave w-2/4 h-2/4 rounded-full opacity-0 peer-checked:opacity-100 transition-opacity duration-200 top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2"></div>
                            </label>
                            <label class="w-full ml-2 flex justify-between text-neutral-aurora text-md font-noto-sans cursor-pointer" for="option">
                                Neko Kirame
                            </label>
                        </dt>
                        <dd class="inline-flex items-center">
                            <label class="relative flex items-center cursor-pointer" for="option">
                                <input 
                                    id="option"
                                    name="option" 
                                    type="radio" 
                                    class="peer h-5 w-5 cursor-pointer appearance-none rounded-full bg-neutral-aurora" 
                                >
                                <div class="absolute bg-blue-skywave w-2/4 h-2/4 rounded-full opacity-0 peer-checked:opacity-100 transition-opacity duration-200 top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2"></div>
                            </label>
                            <label class="w-full ml-2 flex justify-between text-neutral-aurora text-md font-noto-sans cursor-pointer" for="option">
                                Takashi
                            </label>
                        </dd>
                        <dt class="inline-flex items-center">
                            <label class="relative flex items-center cursor-pointer" for="option">
                                <input 
                                    id="option"
                                    name="option" 
                                    type="radio" 
                                    class="peer h-5 w-5 cursor-pointer appearance-none rounded-full bg-neutral-aurora" 
                                >
                                <div class="absolute bg-blue-skywave w-2/4 h-2/4 rounded-full opacity-0 peer-checked:opacity-100 transition-opacity duration-200 top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2"></div>
                            </label>
                            <label class="w-full ml-2 flex justify-between text-neutral-aurora text-md font-noto-sans cursor-pointer" for="option">
                                NHK
                            </label>
                        </dt>
                        <dd class="inline-flex items-center">
                            <label class="relative flex items-center cursor-pointer" for="option">
                                <input 
                                    id="option"
                                    name="option" 
                                    type="radio" 
                                    class="peer h-5 w-5 cursor-pointer appearance-none rounded-full bg-neutral-aurora" 
                                >
                                <div class="absolute bg-blue-skywave w-2/4 h-2/4 rounded-full opacity-0 peer-checked:opacity-100 transition-opacity duration-200 top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2"></div>
                            </label>
                            <label class="w-full ml-2 flex justify-between text-neutral-aurora text-md font-noto-sans cursor-pointer" for="option">
                                Suzuh
                            </label>
                        </dd>
                    </dl>
                    <div class="flex justify-between">
                        <button type="submit" class="cursor-pointer text-neutral-aurora text-md font-noto-sans font-bold uppercase italic rounded-sm py-1 px-3 bg-orange-amber">
                            Votar
                        </button>
                    </div>
                </article>
            {/if}
        </div>
    </Section>
{/if}