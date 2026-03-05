<script>
    export let title;

    import { page } from "@inertiajs/svelte";
    import { Modal, Section } from "@/ui/components/private/";
    import { ProgramForm } from "@/ui/widgets/private/form";

    $: ({ programs } = $page.props);

    $:console.log(programs)
</script>

<div class="flex justify-center mb-10">
    <Modal>
        <div class="cursor-pointer bg-blue-skywave px-4 py-2 rounded-md text-neutral-aurora font-noto-sans font-bold uppercase italic" slot="action" >
            Cadastrar programa
        </div>
        <div slot="title">
            Novo programa
        </div>
        <div slot="content" let:close>
            <ProgramForm {close}/>
        </div>
    </Modal>
</div>
<Section {title}>
    {#if programs.data.length > 0}
        <div class="grid grid-cols-4 gap-15 lg:gap-x-0 lg:gap-y-15 0 mt-10 mb-20">
            {#each programs.data as item}
                <div class="flex justify-center gap-5 lg:border-r-2 lg:border-neutral-aurora/10 lg:last:border-0">
                    <div>
                         <img src={item.image} alt="" aria-hidden="true" loading="lazy" class='w-60 transition duration-300 ease-in-out'>
                    </div>
                    <div class="flex flex-col gap-5">
                        <Modal>
                            <div slot="action">
                                <img src="/svg/default/edit.svg" alt="" aria-hidden="true" class="w-[1.2rem] filter-blue-skywave" loading="lazy"/>
                            </div>
                            <div slot="title">
                                Novo programa
                            </div>
                            <div slot="content" let:close>
                                <!--<ShowsForm {close}/>-->
                            </div>
                        </Modal>
                        <button>
                            <img src="/svg/default/trash.svg" alt="" aria-hidden="true" class="w-[1.2rem] filter-red-crimson" loading="lazy"/>
                        </button>
                    </div>
                </div>
            {/each}
        </div>
    {/if}
</Section>
