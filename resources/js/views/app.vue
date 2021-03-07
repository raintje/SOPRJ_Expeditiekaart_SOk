<template>

    <div>
        <l-map
            ref="map"
            :min-zoom="minZoom"
            :crs="crs"
            style="height: 100vh; width: 100%;"

        >
            <l-image-overlay
                :url="url"
                :bounds="bounds"
                :max-bounds="maxBounds"
            />
            <l-marker
                v-for="item in items"
                :key="item.id"
                :lat-lng="location(item.y_pos, item.x_pos)"
            >
                <l-popup :content="item.categorie" />
            </l-marker>
<!--            <l-polyline :lat-lngs="travel" />-->
        </l-map>
    </div>
</template>

<script>
import {CRS, latLng} from "leaflet";
import {LImageOverlay, LMap, LMarker, LPolyline, LPopup} from "vue2-leaflet";

export default {
    components: {
        LMap,
        LImageOverlay,
        LMarker,
        LPopup,
        LPolyline
    },
    data() {
        return {
            url: "http://localhost:8000/img/wallpaper_2.svg",
            bounds: [[-26.5, -25], [1021.5, 1023]],
            maxBounds: [[450, 450], [450, 450]],
            minZoom: 1.4,
            crs: CRS.Simple,
            center: [2000, 3023],
            stars: [
                { name: "Sol", lng: 175.2, lat: 145.0 },
                { name: "Mizar", lng: 41.6, lat: 130.1 },
                { name: "Krueger-Z", lng: 13.4, lat: 56.5 },
                { name: "Deneb", lng: 218.7, lat: 8.3 }
            ],
            items: [],
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
        }
    }

};
</script>
