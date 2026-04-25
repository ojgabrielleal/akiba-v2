<script>
    import { Meta } from "@/config";
    import { Layout } from "@/ui/layouts/private";
    import { PodcastForm, PodcastGrid } from "@/ui/widgets/private";
</script>

<Meta meta={{ title: "Podcasts" } } />
<Layout>
    <PodcastForm />
    <PodcastGrid title="Todos os podcasts" />
</Layout>
