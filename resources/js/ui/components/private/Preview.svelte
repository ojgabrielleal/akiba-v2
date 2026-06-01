<script>
    export let name = null;
    export let size = "default";
    export let tone = "default";
    export let fit = "cover";
    export let position = "center";
    export let color = "default";
    export let colorClass = "";
    export let frameClass = "";
    export let imageClass = "";
    export let src = null;
    export let oninput = null;
    export let required = false;
    export let disabled = false;

    let preview = null;

    const sizes = {
        default: {
            frame: "h-[18rem] rounded-md",
            image: "max-h-[18rem] rounded-md",
        },
        featured: {
            frame: "h-[18rem] rounded-md",
            image: "h-[18rem] rounded-md",
        },
        compact: {
            frame: "h-[10rem] rounded-md",
            image: "h-[10rem] rounded-md",
        },
        profile: {
            frame: "h-[15rem] rounded-md",
            image: "h-[15rem] rounded-md",
        },
        thumb: {
            frame: "w-24 h-24 rounded-md",
            image: "w-24 h-24 rounded-md",
        },
    };

    const tones = {
        default: "bg-blue-ocean border border-blue-skywave",
        muted: "bg-suspense-aurora",
    };

    const colors = {
        default: "text-orange-citric",
        muted: "text-blue-ocean",
        light: "text-suspense-aurora",
    };

    const fits = {
        cover: "object-cover",
        contain: "object-contain",
    };

    const positions = {
        center: "object-center",
        top: "object-top",
    };

    $: imageToShow = preview ?? (src && src !== "#" ? src : null);
    $: selectedSize = sizes[size] ?? sizes.default;
    $: selectedTone = tones[tone] ?? tones.default;
    $: selectedFit = fits[fit] ?? fits.cover;
    $: selectedPosition = positions[position] ?? positions.center;
    $: selectedColor = colors[color] ?? colors.default;
    $: placeholderClass = `${selectedSize.frame} ${selectedTone} ${frameClass} ${selectedColor} ${colorClass} w-full flex items-center justify-center overflow-hidden font-noto-sans text-7xl font-extrabold italic uppercase`;
    $: previewClass = `${selectedSize.image} ${selectedTone} ${frameClass} ${selectedFit} ${selectedPosition} ${imageClass} w-full`;

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
            class={previewClass}
            loading="lazy"
        />
    {:else}
        <div class={placeholderClass}>
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
