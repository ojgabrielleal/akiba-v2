<script>
    import { Meta } from "@/config/meta";
    import { Layout } from "@/layouts/private";
    import { UserGrid, CalendarGrid } from "@/ui/widgets/private/grid";
    import { RoleTable } from "@/ui/widgets/private/table";
    import { ActivityCarrousel } from "@/ui/widgets/private/carrousel";
</script>

<Meta meta={{ title: "ADM's" }} />
<Layout>
    <UserGrid title="Membros"/>
    <RoleTable title="Cargos" />
    <CalendarGrid title="Calendário" variant="administration"/>
    <ActivityCarrousel title="Avisos e atividades" variant="administration"/>
</Layout>