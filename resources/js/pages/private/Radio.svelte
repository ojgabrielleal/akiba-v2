<script>
    import { Meta } from "@/config/meta";
    import { Layout } from "@/layouts/private";
    import { ScheduleGrid, RankingGrid, ListenerMonthGrid } from "@/ui/widgets/private/grid"
    import { ProgramCarrousel } from "@/ui/widgets/private/carrousel"
</script>

<Meta meta={{ title: "Rádio" }} />
<Layout>
    <ProgramCarrousel title="Programas cadastrados"/>
    <ScheduleGrid title="Grade de programação"/>
    <!--
    <RankingGrid/>
        <ListenerMonthGrid/>
    -->
</Layout>
