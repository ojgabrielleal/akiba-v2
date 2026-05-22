<script>
    export let name = null;
    export let standard = "h-[18rem] rounded-lg";
    export let view = "max-h-[18rem]";
    export let src = null;
    export let oninput = null;
    export let required = false;
    export let disabled = false;

    let preview = null;

    $: imageToShow = preview ?? (src && src !== "#" ? src : null);

    const previewImage = (event) => {
        if (disabled) {
            return;
        }

        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = (e) => {
                preview = e.target.result;
            };
            reader.readAsDataURL(file);
        } else {
            preview = null;
        }
    };
</script>

<label class={["block",
    { "cursor-pointer": !disabled },
    { "cursor-not-allowed opacity-60": disabled },
]}>
    {#if imageToShow}
        <img
            src={imageToShow}
            alt=""
            aria-hidden="true"
            class={`${view} w-full object-cover object-center rounded-lg bg-blue-ocean`}
            loading="lazy"
        />
    {:else}
        <div class={`${standard} w-full bg-blue-ocean border border-blue-skywave flex items-center justify-center overflow-hidden font-noto-sans text-orange-citric text-7xl font-bold italic uppercase`}>
            +
        </div>
    {/if}
    <input
        id={name}
        type="file"
        {name}
        class="sr-only"
        accept="image/*"
        {required}
        {disabled}
        on:input={oninput}
        on:change={previewImage}
    />
</label>
