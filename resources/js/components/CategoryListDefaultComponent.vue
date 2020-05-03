<template>
  <div class="row">
    <div class="col-md-3" v-for="category in categories" v-bind:key="category.id">
      <div class="card mt-4">
        <router-link :to="{ name: 'post-category', params: {category_id: category.id} }">
          <img src=" '/images_categories/php.svg'" class="card-img-top mt-3" alt="..." />
          <div class="card-body">
            <h5 class="card-title text-center">{{ category.title }}</h5>
          </div>
        </router-link>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  created() {
    this.getCategories();
  },

  methods: {
    getCategories: function() {
      fetch("/api/category/all")
        .then(resp => resp.json())
        .then(json => (this.categories = json.data));
    }
  },

  data: function() {
    return {
      categories: ""
    };
  },

  watch: {
    currentPage: function(newVal, oldVal) {
      this.currentPage = newVal;
      this.$emit("getCurrentPage", newVal);
    }
  }
};
</script>