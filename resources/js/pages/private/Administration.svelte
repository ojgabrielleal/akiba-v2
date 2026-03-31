<script>
    import { Meta } from "@/config/meta";
    import { Layout } from "@/layouts/private";
    import { UserGrid, RoleGrid, ActivityGrid } from "@/ui/widgets/private/grid";
</script>

<Meta meta={{ title: "ADM's" }} />
<Layout>
    <UserGrid title="Membros"/>
    <RoleGrid title="Cargos" />
    <ActivityGrid title="Atividades" />
</Layout>