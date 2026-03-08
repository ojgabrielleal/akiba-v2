export const scrollx = (event) => {
    const el = event.currentTarget;

    if (el.scrollWidth > el.clientWidth) {
        el.scrollLeft += event.deltaY;
        event.preventDefault();
    }
}