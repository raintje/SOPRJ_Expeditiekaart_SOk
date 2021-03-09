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

            <l-marker @add="openPopup" v-for="item in items" :lat-lng="location(item.y_pos, item.x_pos)" :key="item.id">
                <l-icon
                    :icon-anchor="staticAnchor"
                    class-name="marker blue"

                >
                    <l-tooltip
                        content="Dit is een voorbeeld text om meer informatie te krijgen over deze categorie<br> fsdfsfsfsdfsdfsdfsdfsdfsdsdd"/>
                    <l-popup :options="{ autoClose: false, closeOnClick: false }" :content="item.categorie"/>
                </l-icon>
            </l-marker>
            <!--            <l-polyline :lat-lngs="travel" />-->
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
            // maxBounds: [[393, 85], [575, 820]],
            maxBounds: [[290, 89], [659, 833]],
            minZoom: 1.4,
            crs: CRS.Simple,
            center: [2000, 3023],
            stars: [
                {name: "Sol", lng: 175.2, lat: 145.0},
                {name: "Mizar", lng: 41.6, lat: 130.1},
                {name: "Krueger-Z", lng: 13.4, lat: 56.5},
                {name: "Deneb", lng: 218.7, lat: 8.3}
            ],
            items: [],
            staticAnchor: [16, 37],
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
        getClass: function (item) {

            var result = [];
            result.push(' marker ');
            if (item.categorie === "bedrijfskunde") {
                result.push(' green');
            }
            if (item.categorie === "familie/sociaal") {
                result.push(' red');
            }
            if (item.categorie === "persoonlijke ontwikkeling") {
                result.push(' blue');
            }
            return result;
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
