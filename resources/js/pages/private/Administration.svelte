<script>
    import { Meta } from "@/config";
    import { Layout } from "@/ui/layouts/private";
    import { UserGrid, CalendarGrid, RoleTable, ActivityCarrousel, TaskGrid, AutomaticGrid } from "@/ui/widgets/private";
</script>

<Meta meta={{ title: "ADM's" }} />
<Layout>
    <UserGrid title="Membros"/>
    <RoleTable title="Cargos" />
    <CalendarGrid title="Calendário" variant="administration"/>
    <ActivityCarrousel title="Avisos e atividades" variant="administration"/>
    <TaskGrid title="Tarefas" />
    <AutomaticGrid title="Auto DJ"/>
</Layout>