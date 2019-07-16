<script>
    import { Line, mixins } from 'vue-chartjs';

    export default {
        extends: Line,
        mixins: [mixins.reactiveProp],
        // props: ['options'],
        data: () => ({
            options: {
                title: {
                    display: true,
                    text: 'Sales per Month'
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
                    display: false,
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