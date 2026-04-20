<script>
    import { Meta } from "@/config";
    import { Layout } from "@/ui/layouts/public";
    import { MainPlayer, MobilePlayer, FeaturedPosts } from "@/ui/widgets/public";
</script>

<Meta/>
<Layout>
    <div class="bg-blue-night lg:h-180 hidden lg:block lg:pt-50">
        <MainPlayer/>
    </div>
    <div class="bg-blue-night lg:hidden pt-10">
        <MobilePlayer/>
    </div>
    <div class="bg-blue-midnight pt-10 lg:pt-25">
        <FeaturedPosts title="Destaques da Akiba"/>
    </div>
</Layout>