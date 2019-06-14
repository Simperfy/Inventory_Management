<template>
    <div>
        <chart-component :chartData="data" :options="options"></chart-component>
        <button @click="fillData()" type="button">Click</button>
        <p>Most Sold Item: {{mostSoldItem.name}} </p>
        <p>Profit : {{mostSoldItem.profit}} </p>
    </div>
</template>

<script>
    import ChartComponent from './components/ChartComponent';
    export default {
        data() {
            return {
                data: {
                    labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                    datasets: []
                },
                options: {
                    title: {
                        display: true,
                        text: 'Sales Report'
                    },

                    scales: {
                        yAxes: [{
                            stacked: true,
                        }],
                        xAxes: [{
                            stacked: true,
                            categoryPercentage: 0.5,
                            barPercentage: 1
                        }],
                    },

                    legend: {
                        display: true,
                    },
                    responsive: true,
                    maintainAspectRatio: false
                }
            }
        },

        computed: {
            mostSoldItem() {
                let result = {
                    name: '',
                    profit: 0
                };

                this.data.datasets.forEach(function(item) {
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
            fillData() {
                // prepare data
                let tempData = [
                    {
                        type: 'line',
                        label: 'Expenses',
                        backgroundColor: `rgb(255, 10, 0)`,
                        fill: false,
                        data: [40, 20, 12, 39, 10, 40, 39, 80, 40, 20, 12, 11]
                    }
                ];

                tempData[0].data = tempData[0].data.map(item => item * 2);

                for (let x = 0; x < 10; x++) {
                    let r = Math.floor(Math.random() * 255);
                    let g = Math.floor(Math.random() * 255);
                    let b = Math.floor(Math.random() * 255);

                    tempData.push({
                        type: 'bar',
                        label: `Item ${x + 1}`,
                        backgroundColor: `rgb(${r}, ${g}, ${b})`,
                        data: [40, 20, 2*r, 39, 10, 40, 39, 80, 40, 20, 12, 11] // @todo remove "* r"
                    });
                }

                // set data
                this.data = {
                    labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                    datasets: tempData
                }
            }
        },

        components: {ChartComponent},
    }
</script>

<style scoped>

</style>