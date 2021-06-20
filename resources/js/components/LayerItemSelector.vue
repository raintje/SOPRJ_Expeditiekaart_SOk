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
        const response = await axios.get('/api/all-layeritems');
        if (response.status === 200) this.bijgerechten = response.data;
    },
    
}
</script>
