<script>
    import { page } from "@inertiajs/svelte";
    import { Meta } from "@/config";
    import { Layout } from "@/ui/layouts/private/";
    import {
        GreatingHero,
        ActivityCarrousel,
        TaskCarrousel,
        PostGrid,
        CalendarGrid,
        RapidAccessGrid,
    } from "@/ui/widgets/private";

    $: ({ user } = $page.props);
</script>

<Meta meta={{ title: "Dashboard" } } />
<Layout>
        <GreatingHero />
    <!--
        <RapidAccessGrid />
        <ActivityCarrousel title="Avisos e Atividades" />
        <TaskCarrousel title="Minhas Tarefas" />
        <PostGrid title="Últimas Matérias" />
        <CalendarGrid title="Calendário" />
    -->
</Layout>
