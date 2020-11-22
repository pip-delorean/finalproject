<template>
<canvas></canvas>
</template>

<script type="text/javascript">
import Chart from "chart.js";

export default {
    props: {
        keys: {
            type: Array,
            required: true
        },
        values: {
            type: Array,
            required: true
        },
        type: {
            type: String,
            required: true
        },
        xlabel: {
            type: String,
            required: true
        },
        ylabel: {
            type: String,
            required: true
        }
    },

    data() {
        return {
            data: {
                labels: this.keys,
                datasets: [{
                    data: this.values,
                    yAxisID: this.ylabel,
                    xAxisID: this.xlabel,
                }]
            },
            chart: null,
        }

    },

    mounted() {
        this.chart = new Chart(this.$el.getContext("2d"), {
            type: this.type,
            data: this.data,
            options: {
                legend: {
                    display: false,
                },
                layout: {
                    padding: {
                        left: 25,
                        right: 25,
                        top: 25,
                        bottom: 25
                    }
                },
                scales: {
                    yAxes: [{
                        id: this.ylabel,
                        scaleLabel: {
                            display: true,
                            labelString: this.ylabel,
                        }
                    }],
                    xAxes: [{
                        id: this.xlabel,
                        scaleLabel: {
                            display: true,
                            labelString: this.xlabel,
                        }
                    }]
                }
            },
        });
    }
}
</script>
