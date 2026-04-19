<script>
    import { Meta } from "@/config";
    import { Layout } from "@/ui/layouts/public";
    import { MainPlayer, MobilePlayer } from "@/ui/widgets/public";
</script>

<Meta/>
<Layout>
    <div class="bg-blue-night lg:h-185 hidden lg:block lg:pt-50">
        <MainPlayer/>
    </div>
    <div class="bg-blue-night lg:hidden pt-10">
        <MobilePlayer/>
    </div>
    <div class="h-screen bg-blue-indigo">
        teste
    </div>
</Layout>