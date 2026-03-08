<script>
    import { Meta } from "@/config/meta";
    import { Layout } from "@/layouts/private";
    import { RankingGrid, ListenerMonthGrid } from "@/ui/widgets/private/grid"
    import { ProgramCarrousel } from "@/ui/widgets/private/carrousel"
</script>

<Meta meta={{ title: "Rádio" }} />
<Layout>
    <ProgramCarrousel title="Programas cadastrados"/>
    <!--
        <RankingGrid/>
        <ListenerMonthGrid/>
    -->
</Layout>
