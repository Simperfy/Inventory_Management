<template>
    <div class="selector">
        <model-list-select
                            :list="inventory"
                           v-model="cartItem"
                           option-value="barcode"
                           option-text="barcode"
                            placeholder="item-000001"
                          >
        </model-list-select>
    </div>
</template>

<script>
    import axios from 'axios';
    import { ModelListSelect  } from 'vue-search-select';
    export default {
        components: {
            ModelListSelect
        },

        props: ['clearData'],

        data() {
            return {
                cartItem: {},
                inventory: [
                    // {barcode: 'screw-000001', price: 1000, text: 100, value: 100},
                    // {barcode: 'screw-000002', price: 2000, text: 100, value: 100},
                ],
            }
        },

        watch: {
            // watch selected item
            cartItem: function () {
                this.$emit('selected',this.cartItem);
            },

            clearData: function () {
                console.log('Clearing');
                this.cartItem = {}
            }
        },

        mounted() {
            axios
                .get('/api/product')
                .then(response => {
                    this.inventory = response.data.data;
                });
            console.log('Component mounted.')
        },

    }
</script>

<style scoped>
.selector {
    min-width: 150px;
    display: inline-block;
}
</style>
