<script>
    import { page } from "@inertiajs/svelte";
    import { Meta } from "@/config";
    import { Layout } from "@/ui/layouts/private/";
    import {
        WellcomeHero,
        ActivityCarrousel,
        TaskCarrousel,
        PublicationsGrid,
        CalendarGrid,
    } from "@/ui/widgets/private";

    $: ({ user } = $page.props);
</script>

<Meta meta={{ title: "Dashboard" } } />
<Layout>
    <WellcomeHero />
    <ActivityCarrousel title="Avisos e Atividades" />
    <TaskCarrousel title="Minhas Tarefas" />
    <PublicationsGrid title="Minhas últimas matérias" />
    <CalendarGrid title="Calendário" />
</Layout>
