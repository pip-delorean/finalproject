import axios from "axios";
import Vue from "vue";
import Graph from "../components/Graph.vue";

axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";

document.addEventListener("DOMContentLoaded", function() {
    new Vue({
        el: "#root",
        components: {
          Graph,
        }
    });
});
