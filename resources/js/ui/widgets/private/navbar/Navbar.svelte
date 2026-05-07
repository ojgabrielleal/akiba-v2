<script>
    import { page, Link } from "@inertiajs/svelte";
    import { hasPermission } from "@/utils";
    import { navbar } from "@/data";

    $: ({ user } = $page.props);

    let mobilenavbar = false;
</script>

<nav class="container-page flex items-center justify-between">
    <div class="w-[15rem]">
        <img 
            src="/img/default/logo.webp"
            alt="Logo"
        />
    </div>
    <ul class="flex flex-1 justify-center">
        {#each navbar.private as item}
            {#if hasPermission(item.permission)}
                <li class="px-5 first:pl-0 border-l first:border-none border-neutral-gray/50">
                    <Link
                        title=""
                        aria-label=""
                        href={item.address}
                        class="group/item"
                    >
                        <img
                            src={item.icon}
                            alt={item.name}
                            class="w-5 h-5 inline-block mr-1 filter-neutral-gray group-hover/item:filter-orange-amber"
                        />
                    </Link>
                </li>
            {/if}
        {/each}
    </ul>
    <div class="w-[15rem] flex justify-end">
        <Link
            title=""
            aria-label=""
            class="bg-neutral-white w-10 h-10 rounded-full flex items-center justify-center"
            href={`/profile/${user.uuid}`}
        >
            <img 
                src={user.avatar}
                alt="Logout"
                class="object-cover object-top"
            />
        </Link>
    </div>
</nav>
