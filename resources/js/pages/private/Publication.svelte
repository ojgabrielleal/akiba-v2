<script>
    import { Meta } from "@/config";
    import { Layout } from "@/ui/layouts/private";
    import { Section } from "@/ui/components/private";
    import { PostForm, PublicationsGrid } from "@/ui/widgets/private";

    $: show = false;
    $: model = "post";

    let actions = [
        {
            title: "Matéria",
            icon: "/svg/materials.svg",
            onClick: () => {
                show = true;
                model = "post";
            }
        },
        {
            title: "Review",
            icon: "/svg/reviews.svg",
            onClick: () => {
                show = true;
                model = "review";
            }
        },
        {
            title: "Evento",
            icon: "/svg/events.svg",
            onClick: () => {
                show = true;    
                model = "event";
            }
        }
    ];
</script>

<Meta meta={{ title: "Matérias" } } />
<Layout>
    <Section title="Criar" {actions} />
        {#if show && model === "post"}
            <PostForm />
        {/if}
        <PublicationsGrid title="Todas as matérias, reviews e eventos" {show} {model} />
    <Section/>
</Layout>
