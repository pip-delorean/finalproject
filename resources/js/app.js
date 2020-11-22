import axios from "axios";
import Vue from "vue";
import Graph from "../components/Graph.vue";
import Pie from "../components/Pie.vue";

axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";

document.addEventListener("DOMContentLoaded", function() {
    new Vue({
        el: "#root",
        components: {
          Graph,
          Pie
        }
    });
});
