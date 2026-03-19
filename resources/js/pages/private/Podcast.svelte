<script>
    import { Meta } from "@/config/meta";
    import { Layout } from "@/layouts/private";
    import { PodcastForm } from "@/ui/widgets/private/form"
    import { PodcastGrid } from "@/ui/widgets/private/grid"
</script>

<Meta meta={{ title: "Podcasts" }} />
<Layout>
    <PodcastForm/>
    <PodcastGrid/>
</Layout>