<script>
    import { Meta } from "@/config";
    import { Layout } from "@/layouts/private";
    import { ReviewForm, ReviewGrid } from "@/ui/widgets/private";
</script>

<Meta meta={{ title: "Reviews" }} />
<Layout>
    <ReviewForm />
    <ReviewGrid title="Todos os reviews" />
</Layout>
