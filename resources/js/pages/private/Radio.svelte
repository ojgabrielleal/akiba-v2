<script>
    import { Meta } from "@/config/meta";
    import { Layout } from "@/layouts/private";
    import { ProgramScheduleGrid, MusicRankingGrid, ListenerMonthGrid } from "@/ui/widgets/private/grid"
    import { ProgramCarrousel } from "@/ui/widgets/private/carrousel"
</script>

<Meta meta={{ title: "Rádio" }} />
<Layout>
    <ProgramCarrousel title="Programas cadastrados"/>
    <ProgramScheduleGrid title="Grade de programação"/>
    <MusicRankingGrid title="Ranking de música"/>
    <!--
        <ListenerMonthGrid/>
    -->
</Layout>
