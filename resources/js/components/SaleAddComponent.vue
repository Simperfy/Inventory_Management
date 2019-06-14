<template>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <input type="hidden" name="user_id" value="1">
                    <input type="hidden" name="amount" v-model="totalPrice">
                    <input type="hidden" name="amount_paid" v-model="amountPaid" required>
                    <form class="form-inline" @submit.prevent>
                        <model-list-select :list="inventory"
                                           v-model="cartItem"
                                           option-value="barcode"
                                           option-text="barcode"
                                           placeholder="item-000001">
                        </model-list-select>

                        <!--<input type="text" class="form-control" placeholder="item-000001" v-model="cartItem" @keyup.enter="addBarcode(cartItem)">-->
                        <button type="button" class="btn btn-primary" @click="addBarcode(cartItem)">Add Item</button>
                        <br>
                        <div class="form-group" :class="{'has-error': invalidAmount}">
                            <div class="input-group">
                                <input type="number" class="form-control" name="amount_paid"
                                       placeholder="Amount Paid" v-model="amountPaid">
                            </div>
                        </div>

                        <h3 class="pull-right">Total: ₱{{ totalPrice }}</h3>
                    </form>
                    <!--<input v-model="cartItem" @keyup.enter="addBarcode(cartItem)">-->

                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>Product</th>
                            <th>Quantity</th>
                            <th class="text-center">Price</th>
                            <th class="text-center">Total</th>
                            <th> </th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(item, index) in cart" :key="index">
                            <input type="hidden" :name="`cart[${index}][barcode]`" :value="item.barcode">
                            <input type="hidden" :name="`cart[${index}][quantity]`" :value="item.quantity">
                            <input type="hidden" :name="`cart[${index}][price]`" :value="item.price">

                            <td class="col-sm-8 col-md-6">
                                <div class="media">
                                    <a class="thumbnail pull-left" href="#"> <img class="media-object"
                                                                                  src="http://icons.iconarchive.com/icons/custom-icon-design/flatastic-2/72/product-icon.png"
                                                                                  style="width: 72px; height: 72px;">
                                    </a>
                                    <div class="media-body">
                                        <h4 class="media-heading"><a href="#">{{ item.barcode }}</a></h4>
                                        <h5 class="media-heading"> {{ item.barcode }}</h5>
                                        <span>Status: </span><span class="text-success"><strong>In Stock</strong></span>
                                    </div>
                                </div>
                            </td>
                            <td class="col-sm-1 col-md-1" style="text-align: center">
                                <input type="number" class="form-control" v-model.number="item.quantity">
                            </td>
                            <td class="col-sm-1 col-md-1 text-center"><strong>₱{{ item.price }}</strong></td>
                            <td class="col-sm-1 col-md-1 text-center"><strong>₱{{ item.price * item.quantity }}</strong>
                            </td>
                            <td class="col-sm-1 col-md-1">
                                <button type="button" class="btn btn-danger" @click="removeCartIem(index)">
                                    <i class="fa fa-trash-o"></i> Remove
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td>  </td>
                            <td>  </td>
                            <td>  </td>
                            <td><h3>Total</h3></td>
                            <td class="text-right"><h3><strong>₱{{ totalPrice }}</strong></h3></td>
                        </tr>
                        <tr>
                            <td>   </td>
                            <td>   </td>
                            <td>   </td>
                            <td><h5>Amount Paid</h5></td>
                            <td class="text-right"><h5><strong>₱{{ amountPaid}}</strong></h5></td>
                        </tr>
                        <tr>
                            <td>   </td>
                            <td>   </td>
                            <td>   </td>
                            <td><h5>Change</h5></td>
                            <td class="text-right"><h5><strong>₱{{ change }}</strong></h5></td>
                        </tr>
                        <tr>
                            <td>  </td>
                            <td>  </td>
                            <td>  </td>
                            <td>
                                <!--<button type="button" class="btn btn-default">-->
                                <!--<span class="fa fa-shopping-cart"></span> Continue Shopping-->
                                <!--</button></td>-->
                            <td>
                                <button type="submit" class="btn" :class="(btnColor ? 'btn-success' : 'btn-danger')" @click="canSubmit">
                                    Checkout <span class="fa fa-play"></span>
                                </button>
                            </td>
                        </tr>
                        </tbody>
                    </table>

                    <!--<ul>-->
                    <!--<li v-for="(item, index) in cart">-->
                    <!--{{ item.barcode }} PHP {{ item.price}}-->
                    <!--</li>-->
                    <!--</ul>-->
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from 'axios';
    import { ModelListSelect  } from 'vue-search-select';
    export default {
        data() {
            return {
                amountPaid: '',
                cartItem: {},
                cart: [],
                inventory: [
                    // {barcode: 'screw-000001', price: 1000, text: 100, value: 100},
                    // {barcode: 'screw-000002', price: 2000, text: 100, value: 100},
                ],
            }
        },

        methods: {
            getBarcode(item) {
                return item.barcode;
            },

            // add Item to the cart
            addBarcode(cartItem) {
                cartItem = this.searchBarcode(cartItem.barcode);

                if (cartItem) {
                    // console.log(cartItem);
                    let newItem = {barcode: cartItem.barcode, price: cartItem.price, quantity: 1};
                    // Vue.set(cartItem, "quantity", 1); // add quantity property
                    this.cart.push(newItem);
                    this.cartItem = {};
                }
            },

            // search and return
            searchBarcode(barcodeToSearch) {
                return this.inventory.find(function (item) {
                    if (item.barcode === barcodeToSearch) {
                        return item;
                    }
                });
            },

            removeCartIem(index) {
                this.cart.splice(index, 1);
            },

            // can checkout?
            canSubmit(event) {
                if(!this.checkCart || this.invalidAmount) {
                   event.preventDefault();
                   return false;
                }
            }

        },

        watch: {
            // watch selected item
            cartItem: function () {
                this.addBarcode(this.cartItem);
            },
        },

        computed: {
            // checkout color
            btnColor() {
                return (this.checkCart && !this.invalidAmount);
            },

            checkCart() {
                return (this.cart.length > 0);
            },

            invalidAmount() {
                return (this.change < 0);
            },

            change() {
                return this.amountPaid - this.totalPrice;
            },

            totalPrice() {
                let total = 0;
                this.cart.forEach(function (item) {
                    total += item.price * item.quantity;
                });

                return total;
            }
        },

        mounted() {
            axios
                .get('/api/product')
                .then(response => {
                    // console.log(response.data.data);
                this.inventory = response.data.data;

            });
            console.log('Component mounted.')
        },
        created() {
            console.log('created')
        },
        components: {
            ModelListSelect
        }
    }
</script>
