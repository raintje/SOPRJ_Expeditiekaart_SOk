<template>
    <span v-html="svg" class="SvgIcon" />
</template>

<script>
export default {
    name: "SvgIcon",
    data: () => {return {
        svg: null
    }},
    props: {
        icon: {
            type: String,
            required: true
        }
    },
    mounted() {
       const {icon} = this;

        const { iconCache = {} } = window;
        window.iconCache = iconCache;

        this.svg = window.iconCache[`${icon}`];

        if (!this.svg)
            fetch(require(`../../assets/icons/${icon}.svg`).default)
                .then(resp => resp.text())
                .then(svg => {
                    window.iconCache[`${icon}`] = svg;
                    this.svg = svg
                });
    }
}
</script>

