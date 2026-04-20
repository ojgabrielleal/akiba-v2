<script>
    import { Meta } from "@/config";
    import { Layout } from "@/ui/layouts/public";
    import { MainPlayer, MobilePlayer, PostGrid, ReviewGrid } from "@/ui/widgets/public";
</script>

<Meta/>
<Layout>
    <div class="bg-blue-night lg:h-179 hidden lg:block lg:pt-50">
        <MainPlayer/>
    </div>
    <div class="bg-blue-night lg:hidden pt-10">
        <MobilePlayer/>
    </div>
    <div class="bg-blue-midnight pt-10 lg:pt-30">
        <PostGrid title="Destaques da Akiba" variant="featured"/>
        <ReviewGrid title="Reviews da Akiba" variant="latest"/>
    </div>

</Layout>