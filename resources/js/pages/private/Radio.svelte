<script>
    import { Meta } from "@/config";
    import { Layout } from "@/ui/layouts/private";
    import { ProgramScheduleGrid, MusicRankingGrid, ListenerMonthGrid, ProgramCarrousel } from "@/ui/widgets/private";
</script>

<Meta meta={{ title: "Rádio" } } />
<Layout>
    <ProgramCarrousel title="Programas cadastrados" />
    <ProgramScheduleGrid title="Grade de programação" />
    <MusicRankingGrid title="Ranking de música" />
    <ListenerMonthGrid title="Ouvinte do mês" />
</Layout>
