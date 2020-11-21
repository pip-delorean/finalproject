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
    },

    data() {
        return {
            data: {
                labels: this.keys,
                datasets: [{
                    data: this.values
                }]
            },
            chart: null,
        }

    },

    mounted() {
        this.chart = new Chart(this.$el.getContext("2d"), {
            type: "line",
            data: this.data
        });
    }
}
</script>
