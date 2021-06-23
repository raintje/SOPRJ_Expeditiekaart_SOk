<template>
    <div>
        <div class="form-group">
            <select name='level' v-model="option" @change="onChange()" class="form-control" id="layerInput">
                <option v-for="index in 4" :value="index">{{ index }}</option>
            </select>
        </div>

        <div class="form-group">
            <label for="itemPathSelect">Vervolgpaden<i class="fas fa-info-circle" rel="tooltip"
                                                       :title="infoPath"></i></label>
            <select id="itemPathSelect" class="custom-select mb-2 sm:flex sm:flex-col">
                <option selected>Opties</option>
                <option v-for="item in this.getSelected" :value="item.id" v-text="item.title"></option>
            </select>
        </div>
        <div id="item-links-container">
            <div class="tag">
                <div class="tag-text">Nemo est eius et quia consequuntur et commodi vel.</div>
                <div class="tag-close">x</div>
                <input type="hidden" name="itemLinks[]" value="19"></div>
        </div>

    </div>
</template>

<script>
export default {
    props: ['level', 'infoLayer', 'infoPath'],
    data() {
        return {
            option: "",
            layerItems: []
        }
    },
    mounted() {
        this.getItems();
        this.option = parseInt(this.level);
    },
    methods: {
        onChange() {
            let e = document.querySelector("#item-links-container");

            let child = e.lastElementChild;
            while (child) {
                e.removeChild(child);
                child = e.lastElementChild;
            }
            this.getItems();
            // this.generateSelect();
        },
        getItems() {
            axios
                .get('/api/not-firstLayeritems')
                .then(response => (this.layerItems = response.data)
                    .then(console.log(response.data)))
        }
    },
    computed: {
        getSelected: function () {
            let result = JSON.parse(JSON.stringify(this.layerItems));
            return result.filter(e => e.level === parseInt(this.option) + 1)
        }
    }
}
</script>
