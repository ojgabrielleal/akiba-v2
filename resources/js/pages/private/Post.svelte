<script>
    import Cookies from "js-cookie";
    import { router, page } from "@inertiajs/svelte";
    import { Meta } from "@/config";
    import { Layout } from "@/ui/layouts/private";
    import { Section } from "@/ui/components/private";
    import { PostForm, ReviewForm, PostGrid } from "@/ui/widgets/private";

    $: ({ post } = $page.props);
    
    let showEditor = post ?? Cookies.get("akiba_post_show_editor");
    let postType = post?.data.type ?? Cookies.get("akiba_post_type");

    let operation = (type) => {
        showEditor ? router.visit("/panel/post") : showEditor = true
    
        if(!Cookies.get("akiba_post_show_editor")){
            Cookies.set("akiba_post_show_editor", true);
            Cookies.set("akiba_post_type", type);
        }

        Cookies.set("akiba_post_type", type);
        postType = type;

    }

    let actions = [
        {
            title: "Matéria",
            icon: "/svg/materials.svg",
            onClick: () => operation('post')
        },
        {
            title: "Review",
            icon: "/svg/reviews.svg",
            onClick: () => operation('review')
        },
        {
            title: "Evento",
            icon: "/svg/events.svg",
            onClick: () => operation('event')
        }
    ];
</script>

<Meta meta={{ title: "Matérias" } } />
<Layout>
    <Section title="Criar" {actions} />
        {#if showEditor}
            {#if postType === 'post'}
                <PostForm />
            {:else if postType === 'review'}
                <ReviewForm />
            {/if}
        {/if}
        <PostGrid title="Todas as matérias, reviews e eventos"/>
    <Section/>
</Layout>
