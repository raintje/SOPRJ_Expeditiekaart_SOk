require('./bootstrap');
import Vue from 'vue';
import {CRS, latLng, icon} from "leaflet";
import {LImageOverlay, LMap, LMarker, LPopup, LIcon, LTooltip, LTileLayer } from "vue2-leaflet";

import 'leaflet/dist/leaflet.css';

//Main pages
import App from './views/app.vue'

Vue.component('l-image-overlay', LImageOverlay);
Vue.component('l-popup', LPopup);
Vue.component('l-icon', LIcon);
Vue.component('l-tooltip', LTooltip);
Vue.component('l-map', LMap);
Vue.component('l-tile-layer', LTileLayer);
Vue.component('l-marker', LMarker);

window.Vue = require('vue');

const app = new Vue({
    el: '#app',
    components: { App }
});
