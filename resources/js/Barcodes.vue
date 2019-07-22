<template>
    <div>
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <!--Barcodes :)
                <a :href="links.printBarcode">Sample Barcodes</a>-->
                <div class="panel panel-default panel-table">

                    <div class="panel-heading">
                        <div class="row">
                            <div class="col col-xs-8">
                                <form class="form-inline" @submit.prevent>
                                    <div class="form-group">
                                        <p style="display: inline">Barcode</p>
                                        <product-selector @selected="onProductSelect" @addAll="onAddAll" :clearData="clearOnAdd"></product-selector>
                                    </div>
                                    <div class="form-group">
                                        <label for="pcsToAdd">Quantity</label>
                                        <input type="number" class="form-control" id="pcsToAdd" v-model="current_quantity" placeholder="1">
                                    </div>
                                    <button type="submit" class="btn btn-primary" @click="addItem()">ADD</button>
                                    <a class="btn btn-link" style="color: blue; text-decoration:underline" @click="childAddAllItems()">ADD ALL</a>
                                </form>
                            </div>

                            <div class="col col-xs-4 text-right">
                                <button type="button" class="btn btn-sm btn-success" @click="downloadForm()">Download</button>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <form :action="links.printBarcode" method="POST" ref="printBarcodeForm">
                            <slot></slot>
                            <table class="table table-striped table-bordered table-list">
                                <thead>
                                <tr>
                                    <th><em class="fa fa-cog"></em></th>
                                    <th>Item</th>
                                    <th>Pcs</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="item in items" :key="item.id">
                                    <td align="center">
                                        <a href="#" class="btn btn-danger" @click="removeItem(item.id)"><i class="fa fa-trash-o"></i></a>
                                    </td>
                                    <td><input type="text" name="itemBarcodes[]" :value="item.name" readonly style="border:white"></td>
                                    <td><input type="text" name="itemQuantity[]" :value="item.quantity" readonly style="border:white"></td>
                                </tr>
                                </tbody>
                            </table>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</template>

<script>
    import ProductSelector from './components/ProductSelector';
    export default {
        components: {
            ProductSelector
        },

        data() {
            return {
                links: {
                    printBarcode: '/admin/barcodes/print'
                },

                id_counter: 1,
                currentItemBarcode: null,
                clearOnAdd: false,
                current_quantity: 1,
                items: [
                    // {id: 2, name: 'scw-00001', quantity: 8},
                    // {id: 3, name: 'dogFood-000001', quantity: 30}
                ]

            };
        },

        methods: {
            downloadForm() {
                this.$refs.printBarcodeForm.submit();
            },

            // Event Listeners
            onAddAll(inventory) {
                let self = this;
                inventory.forEach(function (item) {
                    console.log(item.barcode);
                    self.addItem(item.barcode, 1);
                })
            },

            onProductSelect(item) {
                this.currentItemBarcode = item.barcode;
            },
            // ./Event Listeners

            // add item to table
            addItem(itemBarcode = this.currentItemBarcode, itemQuantity = this.current_quantity) {
                console.log('adding item');

                if (itemQuantity > 0 && itemBarcode) {
                    console.log('pass');
                    this.items.push( {id: this.id_counter, name: itemBarcode, quantity: itemQuantity} );
                    this.current_quantity = 1;
                    this.currentItemBarcode = null;
                    this.id_counter++;
                    this.clearOnAdd = !this.clearOnAdd; // doesn't matter if true or false, this is only used to trigger watch function on product selector
                }
            },

            childAddAllItems() {
                this.$children[0].addAll();
            },

            // remove item from table
            removeItem(id) {
                for (let i = 0; i < this.items.length; i++) {
                    if (this.items[i].id === id)
                        this.items.splice(i, 1);
                }
            }
        },

    }
</script>

<style scoped>
    .panel-table .panel-body{
        padding:0;
    }

    .panel-table .panel-body .table-bordered{
        border-style: none;
        margin:0;
    }

    .panel-table .panel-body .table-bordered > thead > tr > th:first-of-type {
        text-align:center;
        width: 100px;
    }

    .panel-table .panel-body .table-bordered > thead > tr > th:last-of-type,
    .panel-table .panel-body .table-bordered > tbody > tr > td:last-of-type {
        border-right: 0px;
    }

    .panel-table .panel-body .table-bordered > thead > tr > th:first-of-type,
    .panel-table .panel-body .table-bordered > tbody > tr > td:first-of-type {
        border-left: 0px;
    }

    .panel-table .panel-body .table-bordered > tbody > tr:first-of-type > td{
        border-bottom: 0px;
    }

    .panel-table .panel-body .table-bordered > thead > tr:first-of-type > th{
        border-top: 0px;
    }

    .panel-table .panel-footer .pagination{
        margin:0;
    }

    /*
    used to vertically center elements, may need modification if you're not using default sizes.
    */
    .panel-table .panel-footer .col{
        line-height: 34px;
        height: 34px;
    }

    .panel-table .panel-heading .col h3{
        line-height: 30px;
        height: 30px;
    }

    .panel-table .panel-body .table-bordered > tbody > tr > td{
        line-height: 34px;
    }
</style>