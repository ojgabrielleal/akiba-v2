<script>
    import { onMount } from "svelte";
    import Quill from "quill";
    import "quill/dist/quill.snow.css";

    export let value;
    export let height = "50rem";
    export let name = "content";
    export let required = false;
    export let disable = false;
    export let disabled = false;

    let quill;
    let editor;
    let textarea;

    onMount(() => {
        quill = new Quill(editor, {
            theme: "snow",
            modules: {
                toolbar: [
                    [{ font: [] }, { size: [] }],
                    ["bold", "italic", "underline", "strike"],
                    [{ color: [] }, { background: [] }],
                    [{ script: "sub" }, { script: "super" }],
                    [{ header: 1 }, { header: 2 }, "blockquote", "code-block"],
                    [
                        { list: "ordered" },
                        { list: "bullet" },
                        { indent: "-1" },
                        { indent: "+1" },
                    ],
                    [{ direction: "rtl" }, { align: [] }],
                    ["link", "image", "video", "formula"],
                    ["clean"],
                ],
            },
        });

        quill.on("text-change", () => {
            value = quill.root.innerHTML;
            textarea.value = value === "<p><br></p>" ? "" : value;
        });
    });

    $: isDisabled = disable || disabled;

    $: if (quill) {
        quill.enable(!isDisabled);
    }

    $: if (quill && value !== quill.root.innerHTML) {
        quill.root.innerHTML = value;
        textarea.value = value === "<p><br></p>" ? "" : value;
    }
</script>

<div
    class="rounded-xl overflow-hidden bg-blue-ocean"
    class:opacity-70={isDisabled}
    class:cursor-not-allowed={isDisabled}
>
    <div bind:this={editor} class="p-3" style="min-height: {height};"></div>
</div>
<textarea
    bind:this={textarea}
    {name}
    {required}
    disabled={isDisabled}
    class="sr-only"
>
</textarea>
