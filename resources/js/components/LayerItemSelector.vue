<template>
    <div>
        
    </div>
</template>

<script>
export default {
    props: ['level', 'infoLayer', 'infoPath'],
    data() {
        return {
            layerItems: []
        }
    },
    mounted() {
        axios
            .get('/api/all-layeritems')
            .then(response => (this.layerItems = response.data))
    },
}
</script>
