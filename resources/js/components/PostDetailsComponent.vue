<template>
  <div>
    <div v-if="post">
      <div class="card mt-4">
        <div class="card-header">
          <img v-bind:src="post.image.image" class="card-img-top" alt="..." />
        </div>
        <div class="card-body">
          <h5 class="card-title">{{ post.title }}</h5>
          <router-link
            class="btn btn-success"
            :to="{ name: 'post-category', params: {category_id: post.category.id} }"
          >{{ post.category.title }}</router-link>
          <p class="card-text">{{ post.content }}</p>
        </div>
      </div>
    </div>
    <!-- <div v-else>
      <h1>El post no existe</h1>
    </div> -->
  </div>
</template>

<script>
export default {
  created() {
    this.getPost();
    //console.log("gadhsakjd " + this.$route.params.id);
  },

  methods: {
    getPost: function() {
      fetch("/api/post/" + this.$route.params.id)
        .then(resp => resp.json())
        .then(json => (this.post = json.data));
    }
  },

  data: function() {
    return {
      postSelected: "",
      post: ""
    };
  }
};
</script>