<script>
    import { Meta } from "@/config";
    import { Layout } from "@/ui/layouts/private";
    import { EventForm, EventGrid } from "@/ui/widgets/private";
</script>

<Meta meta={{ title: "Eventos" } } />
<Layout>
    <EventForm />
    <EventGrid title="Todos os Eventos" />
</Layout>
