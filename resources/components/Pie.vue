<template>
<canvas></canvas>
</template>

<script type="text/javascript">
import Chart from "chart.js";

function hash_to_number(string) {
  let arr = string.split('');
  return arr.reduce(
    (hashCode, currentVal) =>
      (hashCode = currentVal.charCodeAt(0) + (hashCode << 6) + (hashCode << 16) - hashCode),
    0
  );
};

function transform_to_rgb(number) {
  const percent = (parseInt(number) - -1000) / (1000 - -1000);
  return Math.round(percent * (255));
}

function backgroundColors(keys) {
    const colors = [];
    for (var i = 0; i < keys.length; i++) {
        const hash = String(hash_to_number(keys[i]));
        const red = transform_to_rgb(hash.substring(1,4));
        const green = transform_to_rgb(hash.substring(4,7));
        const blue = transform_to_rgb(hash.substring(7,10));
        const randomColor = `rgb(${red}, ${green}, ${blue})`;
        colors.push(randomColor);
    }
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
                    backgroundColor: backgroundColors(this.keys),
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
