<script>
    import { Bar, mixins } from 'vue-chartjs';

    export default {
        extends: Bar,
        mixins: [mixins.reactiveProp],
        // props: ['options'],
        data: () => ({
            options: {
            title: {
                display: true,
                    text: 'Breakdown Sales per Month'
            },

            scales: {
                yAxes: [{
                    // stacked: true,
                }],
                    xAxes: [{
                    // stacked: true,
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
        }),
        mounted () {
            this.renderChart(this.chartData, this.options)
        }
    }
</script>