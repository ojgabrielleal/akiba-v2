<script>
    import Cookies from "js-cookie";
    import { router, page } from "@inertiajs/svelte";
    import { Meta } from "@/config";
    import { Layout } from "@/ui/layouts/private";
    import { Section } from "@/ui/components/private";
    import { PostForm, PostGrid } from "@/ui/widgets/private";

    $: ({ post } = $page.props);
    
    let showEditor = post ?? Cookies.get("akiba_show_post_editor");

    let actions = [
        {
            title: "Matéria",
            icon: "/svg/materials.svg",
            onClick: () => {
                Cookies.set("akiba_show_post_editor", true);
                showEditor = true;
            }
        },
        {
            title: "Review",
            icon: "/svg/reviews.svg",
            onClick: () => { router.visit("/panel/review") }
        },
        {
            title: "Evento",
            icon: "/svg/events.svg",
            onClick: () => { router.visit("/panel/event") }
        }
    ];
</script>

<Meta meta={{ title: "Matérias" } } />
<Layout>
    <Section title="Criar" {actions} />
        {#if showEditor}
            <PostForm />
        {/if}
        <PostGrid title="Todas as matérias, reviews e eventos"/>
    <Section/>
</Layout>
