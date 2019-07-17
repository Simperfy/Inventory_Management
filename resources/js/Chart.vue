<template>
    <div>
        <form action="/api/reports" method="get" @submit.prevent>
            <div class="row">
                <div class="col-sm-3">
                    <p style="color: #00468b">From</p>
                    <datepicker :name="'dateFrom'" v-model="dateFrom" :calendar-button="true" :calendar-button-icon-content="'Date'" :typeable="true"></datepicker>
                </div>
                <div class="col-sm-3">
                    <p style="color: #008b46">To</p>
                    <datepicker :name="'dateTo'" v-model="dateTo" :calendar-button="true" :calendar-button-icon-content="'Date'" :typeable="true"></datepicker>
                </div>
                <div class="col-sm-3" style="padding-top: 25px">
                    <button type="submit" class="btn btn-primary" @click="renderChart()">Go</button>
                </div>
            </div>
        </form>

        <chart-line-component :chartData="lineChartData"></chart-line-component>
        <chart-bar-component :chartData="barChartData"></chart-bar-component>
        <p>Most Sold Item: {{mostSoldItem.name}} </p>
        <p>Profit : {{mostSoldItem.profit}} </p>
    </div>
</template>

<script>
    import ChartBarComponent from './components/ChartBarComponent';
    import ChartLineComponent from './components/ChartLineComponent';
    import Datepicker from 'vuejs-datepicker';
    import { ModelListSelect  } from 'vue-search-select';
    import axios from 'axios';
    export default {
        data() {
            return {
                dateFrom: this.getFirstDateOfMonth(),
                dateTo: this.getLastDateOfMonth(),

                barChartData: {
                    labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                    datasets: []
                },

                lineChartData: {
                    labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                    datasets: []
                },
            }
        },

        computed: {
            mostSoldItem() {
                let result = {
                    name: '',
                    profit: 0
                };

                this.barChartData.datasets.forEach(function(item) {
                    let initialNum = 0;
                    let profitSum = item.data.reduce((accumulatedNum, currentNum) => accumulatedNum + currentNum, initialNum);

                    if (profitSum > result.profit) {
                        result.name = item.label;
                        result.profit = profitSum;
                    }
                });

                return result;
            }
        },

        methods: {
            getFirstDateOfMonth() {
                let date = new Date();
                return new Date(date.getFullYear(), date.getMonth(), 1);
            },

            getLastDateOfMonth() {
                let date = new Date();
                return new Date(date.getFullYear(), date.getMonth() + 1, 0);
            },

            getData() {
                let tempBarChartData, tempLineChartData;
                // let self = this;
                return axios.get('/api/reports', {
                    params: {
                        dateFrom: this.dateFrom,
                        dateTo: this.dateTo
                    }
                }).then(response => {
                    // console.log(response.data);
                    let result = response.data;
                    let barChartSales = [];
                    let lineChartSales = [];

                    let lineChartDataSaleItem = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]; // jan - dec

                    // loop through saleitems category object
                    for(const key of Object.keys(result)) {
                        let r = Math.floor(Math.random() * 255);
                        let g = Math.floor(Math.random() * 255);
                        let b = Math.floor(Math.random() * 255);
                        // loop through arrays of sales
                        let barChartDataSaleItem = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]; // jan - dec
                        result[key].forEach(function (item, index) {
                            // console.log(item.price);
                            let date = new Date(item.created_at);
                            let month = date.getMonth(); // January is 0, February is 1, and so on.

                            barChartDataSaleItem[month] += item.price;
                            lineChartDataSaleItem[month] += item.price;
                        });

                        // add profit per category for that month
                        barChartSales.push({
                            // type: 'bar',
                            label: key,
                            backgroundColor: `rgb(${r}, ${g}, ${b})`,
                            data: barChartDataSaleItem
                        });

                    }

                    // sum of all profit for that month
                    lineChartSales.push({
                        // type: 'bar',
                        // label: key,
                        backgroundColor: `rgb(0, 130, 0)`,
                        data: lineChartDataSaleItem
                    });
                    console.log('linechart', lineChartSales);

                    tempBarChartData = {
                        labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                        datasets: barChartSales
                    };

                    tempLineChartData = {
                        labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                        datasets: lineChartSales
                    };

                    return {tempBarChartData, tempLineChartData};

                    }).catch(error => {
                        console.log(error);
                        alert(error);
                    });
            },

            renderChart() {
                this.getData().then(data => {
                    this.barChartData = data.tempBarChartData;
                    this.lineChartData = data.tempLineChartData;
                });


            }
        },

        components: {
            ChartBarComponent,
            ChartLineComponent,
            ModelListSelect,
            Datepicker
        },
    }
</script>

<style scoped>

</style>