<template>
  <div>
    <h1>{{ category.title }}</h1>

    <post-list-default
      :key="currentPage"
      @getCurrentPage="getCurrentPage"
      v-if="total > 0"
      :posts="posts"
      :pCurrentPage="currentPage"
      :total="total"
    ></post-list-default>
  </div>
</template>

<script>
export default {
  created() {
    this.getPosts();
  },

  methods: {
    postClick: function(p) {
      this.postSelected = p;
    },
    getPosts() {
      fetch("/api/post/" + this.$route.params.category_id + "/category?page=" + this.currentPage)
        .then(resp => resp.json())
        .then(json => {
          this.posts = json.data.posts.data;
          this.category = json.data.category;
          this.total = json.data.posts.last_page;
        });
    },
    getCurrentPage: function(val) {
      this.currentPage = val;
      this.getPosts();
    }
  },

  data: function() {
    return {
      postSelected: "",
      posts: [],
      category: "",
      total: 0,
      currentPage: 1,
    };
  }
};
</script>