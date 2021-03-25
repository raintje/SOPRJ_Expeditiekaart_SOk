<template>

    <div>

        <Legenda></Legenda>

        <l-map
            ref="map"
            :min-zoom="minZoom"
            :crs="crs"
            style="height: 98vh; width: 100%;"
            :max-bounds="maxBounds"

        >
            <l-image-overlay
                :url="url"
                :bounds="bounds"
            />
            <l-control class="example-custom-control">
                <p @click="saveLocations">
                    Opslaan
                </p>
            </l-control>

            <l-marker @add="openPopup" v-for="item in items"
                      :lat-lng="location(item.y_pos, item.x_pos)" :draggable="true" :key="item.id">

                <l-icon
                    :icon-anchor="staticAnchor"
                    :class-name="getClass(item)"

                >


                    <l-popup :options="{ autoClose: false, closeOnClick: false }" :content="item.layer_item.title"/>
                </l-icon>
            </l-marker>
        </l-map>
    </div>
</template>

<script>
import {CRS, latLng, icon} from "leaflet";
import Vue from 'vue';
import SvgIcon from "./SvgIcon";
import Navigation from "./Navigation";
import Legenda from "./Legenda";

export default {
    components: {
        SvgIcon, Navigation, Legenda
    },
    data() {
        return {
            url: "/img/wallpaper.svg",
            bounds: [[-120, -27], [1049, 1053]],
            maxBounds: [[298, 89], [659, 833]],
            minZoom: 1.4,
            crs: CRS.Simple,
            center: [2000, 3023],
            items: [],
            staticAnchor: [15, 0],
            tooltipAnchor: [15, 0],
            travel: [[145.0, 175.2], [8.3, 218.7]],
            Laravel: window.Laravel

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
        saveLocations() {
            const requestOptions = {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': Laravel.csrfToken },
                body: JSON.stringify(this.items)
            };
            fetch('/items/edit/location/save', requestOptions)
                .then(async response => {
                    const data = await response.json();
                    console.log(data);
                    // // check for error response
                    // if (!response.ok) {
                    //     // get error message from body or default to response status
                    //     const error = (data && data.message) || response.status;
                    //     return Promise.reject(error);
                    // }
                    //
                    // this.postId = data.id;
                })
                .catch(error => {
                    this.errorMessage = error;
                    console.error('There was an error!', error);
                });
        },
        getClass: function (item) {

            let baseClass = "marker";

            let colors = item.categories.map(i => i.color);

            if(colors.length === 1){
                return baseClass +" "+ item.categories[0].color;
            }
            else if(colors.includes("red", "green")){
                return baseClass + " red-green"
            }
            else if(colors.includes("red", "blue")){
                return baseClass + " blue-red"
            }
            else if(colors.includes("blue", "green")){
                return baseClass + " blue-green"
            }
            else{
                return baseClass;
            }
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

.blue-green {
    background-image: linear-gradient(blue, lawngreen);
}

.blue-red {
    background-image: linear-gradient(blue, red);
}

.red-green {
    background-image: linear-gradient(red, lawngreen);
}

.example-custom-control {
    background: #fff;
    padding: 0 0.5em;
    border: 1px solid #aaa;
    border-radius: 0.1em;
}

</style>
