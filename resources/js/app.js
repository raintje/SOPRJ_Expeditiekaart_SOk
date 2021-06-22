require('./bootstrap');
import Vue from 'vue';
import {CRS, latLng, icon} from "leaflet";
import {LImageOverlay, LMap, LMarker, LPopup, LIcon, LTooltip, LTileLayer, LControl , LRectangle } from "vue2-leaflet";
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'

import 'leaflet/dist/leaflet.css';
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'

//Main pages
import App from './views/app.vue';
import editLocation from './components/editLocation';
import LayerItemSelector from './components/LayerItemSelector';

Vue.component('l-image-overlay', LImageOverlay);
Vue.component('l-popup', LPopup);
Vue.component('l-icon', LIcon);
Vue.component('l-tooltip', LTooltip);
Vue.component('l-map', LMap);
Vue.component('l-control', LControl);
Vue.component('l-tile-layer', LTileLayer);
Vue.component('l-marker', LMarker);
Vue.component('l-rectangle', LRectangle);
Vue.component('edit-location', editLocation);

//custom
Vue.component('layeritem-selector', LayerItemSelector);

Vue.filter('str_limit', function (value, size) {
    if (!value) return '';
    value = value.toString();

    if (value.length <= size) {
        return value;
    }
    return value.substr(0, size) + '...';
});

Vue.use(IconsPlugin);
Vue.use(BootstrapVue);

window.Vue = require('vue');

const app = new Vue({
    el: '#app',
    components: { App, editLocation }
});


