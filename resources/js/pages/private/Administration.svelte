<script>
    import { Meta } from "@/config/meta";
    import { Layout } from "@/layouts/private";
    import { UserGrid, RoleGrid, ActivityGrid, CalendarGrid } from "@/ui/widgets/private/grid";
</script>

<Meta meta={{ title: "ADM's" }} />
<Layout>
    <UserGrid title="Membros"/>
    <RoleGrid title="Cargos" />
    <CalendarGrid title="Calendário" variant="administration"/>
    <ActivityGrid title="Atividades" />
</Layout>