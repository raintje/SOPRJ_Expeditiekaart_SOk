<template>
    <div class="leaflet-bottom leaflet-left">
        <div class="legend leaflet-control">
            <h4 class="">Legenda</h4>
            <i class="blue"></i><span>Familie/sociaal</span><br>
            <i class="red"></i><span>Bedrijfskunde</span><br>
            <i class="green"></i><span>Persoonlijke ontwikkeling</span><br>
        </div>
    </div>
</template>

<script>

export default {
    name: 'Legenda',

    data: () => {
        return {
            Laravel: window.Laravel
        }
    }
}
</script>

