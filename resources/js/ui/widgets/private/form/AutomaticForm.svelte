<script>
    export let identifier; 

    import axios from "axios";
    import { useForm, page } from "@inertiajs/svelte";
    import { Preview } from "@/ui/components/private";
    import { hasPermission } from "@/utils";

    $: ({ users } = $page.props);

</script>

<form>

</form>
