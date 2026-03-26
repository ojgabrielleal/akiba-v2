<script>
    import { page } from "@inertiajs/svelte"
    import { Meta } from "@/config/meta";
    import { Layout } from "@/layouts/private";
    import { ProfileForm } from "@/ui/widgets/private/form";

     $: ({ profile } = $page.props);

     $: titleAdapted = profile ? profile.data.nickname : 'Perfil';
</script>

<Meta meta={{ title: titleAdapted }} />
<Layout>
    <ProfileForm/>
</Layout>