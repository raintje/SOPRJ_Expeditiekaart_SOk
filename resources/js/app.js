require('./bootstrap');
import Vue from 'vue'
import { LMap, LTileLayer, LMarker } from 'vue2-leaflet';
import 'leaflet/dist/leaflet.css';


//Main pages
import App from './views/app.vue'

Vue.component('l-map', LMap);
Vue.component('l-tile-layer', LTileLayer);
Vue.component('l-marker', LMarker);


const app = new Vue({
    el: '#app',
    components: { App }
});
