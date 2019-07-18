<template>
    <div>
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                Barcodes :)
                <a href="/admin/barcodes/print">Sample Barcodes</a>
                <div class="panel panel-default panel-table">

                    <div class="panel-heading">
                        <div class="row">
                            <div class="col col-xs-8">
                                <form class="form-inline" @submit.prevent>
                                    <div class="form-group">
                                        <label for="itemToAdd">Item</label>
                                        <input type="text" class="form-control" id="itemToAdd" v-model="current_name" placeholder="DogFood-000001">
                                    </div>
                                    <div class="form-group">
                                        <label for="pcsToAdd">Quantity</label>
                                        <input type="number" class="form-control" id="pcsToAdd" v-model="current_quantity" placeholder="1">
                                    </div>
                                    <button type="submit" class="btn btn-primary" @click="addItem()">ADD</button>
                                </form>
                            </div>

                            <div class="col col-xs-4 text-right">
                                <button type="button" class="btn btn-sm btn-success">Download</button>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
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
                                    <a class="btn btn-danger" @click="removeItem(item.id)"><i class="fa fa-trash-o"></i></a>
                                </td>
                                <!--<td>DogFood-000001</td>-->
                                <td><input type="text" name="item[barcodes][]" :value="item.name" readonly style="border:white"></td>
                                <!--<td>2</td>-->
                                <td><input type="text" name="item[quantity][]" :value="item.quantity" readonly style="border:white"></td>
                            </tr>
                            </tbody>
                        </table>

                    </div>
                </div>

            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                id_counter: 2,
                current_name: "",
                current_quantity: 1,
                items: [
                    { id: 1, name: "DogFood-00001", quantity: 1 },
                    { id: 2, name: "DogFood-00002", quantity: 1 },
                ]
            };
        },

        methods: {
            addItem() {
                if (this.current_quantity > 0 && this.current_name !== "") {
                    this.items.push( {id: this.id_counter, name: this.current_name, quantity: this.current_quantity} );
                    this.current_name = "";
                    this.current_quantity = 1;
                    this.id_counter++;
                }
            },

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