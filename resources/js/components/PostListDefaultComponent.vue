<template>
  <div>
    <div class="card mt-4" v-for="post in posts" v-bind:key="post.title">
      <img v-bind:src="post.image" class="card-img-top" alt="..." />
      <div class="card-body">
        <h5 class="card-title">{{ post.title }}</h5>
        <p class="card-text">{{ post.content }}</p>
        <button class="btn btn-primary" v-on:click="postClick(post)">Ver resumen</button>
        <router-link
          class="btn btn-success"
          :to="{ name: 'detail', params: {id: post.id} }"
        >Detalles</router-link>
      </div>
    </div>
    <modal-post :key="componentKey" :post="postSelected"></modal-post>
    <v-pagination
      class="mt-4"
      v-model="currentPage"
      :page-count="total"
      :classes="bootstrapPaginationClasses"
      :labels="paginationAnchorTexts"
    ></v-pagination>
  </div>
</template>

<script>
import vPagination from "vue-plain-pagination";

export default {
  props: ["posts", "total", "pCurrentPage"],
  created() {
    this.currentPage = this.pCurrentPage;
  },

  methods: {
    postClick: function(p) {
      this.postSelected = p;
    },
  },

  data: function() {
    return {
      componentKey: 0,
      postSelected: "",
      currentPage: 1,
      bootstrapPaginationClasses: {
        ul: "pagination",
        li: "page-item",
        liActive: "active",
        liDisable: "disabled",
        button: "page-link"
      },
      paginationAnchorTexts: {
        first: "",
        prev: "&laquo;",
        next: "&raquo;",
        last: ""
      }
    };
  },

  components: { vPagination },

  watch: {
    currentPage: function(newVal, oldVal) {
      this.currentPage = newVal;
      this.$emit('getCurrentPage', newVal);
    }
  }
};
</script>