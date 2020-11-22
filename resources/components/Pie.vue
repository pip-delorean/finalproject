<template>
<canvas></canvas>
</template>

<script type="text/javascript">
import Chart from "chart.js";

function backgroundColors(length) {
    let colors = [];
    for (var i = 0; i < length; i++) {
        const randomColor = 'rgb(' +
            Math.round(Math.random() * 255) + ',' +
            Math.round(Math.random() * 255) + ',' +
            Math.round(Math.random() * 255) +
            ')';
        colors.push(randomColor);
    }
    console.log(colors);
    return colors;
}

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
        isdoughnut: {
            type: Boolean,
            required: false
        },
        title: {
          type: String,
          required: false
        }
    },

    data() {
        return {
            data: {
                labels: this.keys,
                datasets: [{
                    data: this.values,
                    backgroundColor: backgroundColors(this.keys.length),
                }]
            },
            chart: null,
        }

    },

    mounted() {
        this.chart = new Chart(this.$el.getContext("2d"), {
            type: this.isdoughnut === true ? "doughnut" : "pie",
            data: this.data,
            options: {
                legend: {
                    display: true,
                },
                title: {
                    display: true,
                    text: this.title ? this.title : ""
                },
                layout: {
                    padding: {
                        left: 25,
                        right: 25,
                        top: 25,
                        bottom: 25
                    }
                },
            },
        });
    }
}
</script>
