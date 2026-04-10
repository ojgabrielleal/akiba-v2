<script>
    import { Meta } from "@/config/meta";
    import { Layout } from "@/layouts/private";
    import { UserGrid, RoleGrid, CalendarGrid } from "@/ui/widgets/private/grid";
    import { ActivityCarrousel } from "@/ui/widgets/private/carrousel";
</script>

<Meta meta={{ title: "ADM's" }} />
<Layout>
    <UserGrid title="Membros"/>
    <RoleGrid title="Cargos" />
    <CalendarGrid title="Calendário" variant="administration"/>
    <ActivityCarrousel title="Avisos e atividades" variant="administration"/>
</Layout>