<template>

    <div>
        <l-map
            ref="map"
            :min-zoom="minZoom"
            :crs="crs"
            style="height: 100vh; width: 100%;"
            :max-bounds="maxBounds"

        >
            <l-image-overlay
                :url="url"
                :bounds="bounds"
            />

            <l-marker @add="openPopup" v-for="item in items"
                      :lat-lng="location(item.y_pos, item.x_pos)" :key="item.id">

                <l-icon
                    :icon-anchor="staticAnchor"
                    :style="{ 'background-color': item.color }"
                    :class-name="item.color + ' marker'"

                >

                    <l-tooltip :tooltip-anchor="tooltipAnchor" :content="item.description"/>
                    <l-popup :options="{ autoClose: false, closeOnClick: false }" :content="item.categorie"/>
                </l-icon>
            </l-marker>
        </l-map>
    </div>
</template>

<script>
import {CRS, latLng, icon} from "leaflet";
import Vue from 'vue';

export default {
    data() {
        return {
            url: "http://localhost:8000/img/wallpaper_2.svg",
            bounds: [[-120, -27], [1049, 1053]],
            maxBounds: [[290, 89], [659, 833]],
            minZoom: 1.4,
            crs: CRS.Simple,
            center: [2000, 3023],
            items: [],
            staticAnchor: [15, 0],
            tooltipAnchor: [15, 0],
            travel: [[145.0, 175.2], [8.3, 218.7]]
        };
    },
    mounted() {
        this.$refs.map.mapObject.setView([520, 450], 1);
        axios
            .get('/layeritems')
            .then(response => (this.items = response.data))
    },

    methods: {
        location: function (x, y) {
            return new latLng(x, y);
        },
        openPopup: function (event) {
            Vue.nextTick(() => {
                event.target.openPopup();
            })
        },

    }

};
</script>

<style>
.marker {
    border: 1px solid #333;
    border-radius: 20px 20px 20px 20px;
    box-shadow: 5px 3px 10px rgba(0, 0, 0, 0.2);
    text-align: center;
    width: 30px !important;
    height: 30px !important;
}

.blue {
    background-color: blue;
}

.red {
    background-color: red;
}

.green {
    background-color: lawngreen;
}
</style>
