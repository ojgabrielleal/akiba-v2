<script>
    import { usePoll } from "@inertiajs/svelte";
    import { Meta } from "@/config";
    import { Layout } from "@/ui/layouts/private";
    import { AudienceCarrousel, ProgramHistoryTable } from "@/ui/widgets/private";

    usePoll(60 * 1000, {
        only: ["audience"]
    });
</script>

<Meta meta={{ title: "Log's" }} />
<Layout>
    <AudienceCarrousel title="Estatísticas da concorrência" />
    <ProgramHistoryTable title="Histórico de transmissões" />
</Layout>
       