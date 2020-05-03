<template>
  <div class="col-8 offset-2">
    <div class="card">
      <div class="card-header">
        <img class="logo_200 mx-auto d-block" src="/images/logo.png" alt="">
      </div>
      <div class="card-body">
        <div class="input-group">
          <div class="input-group-prepend">
            <span class="input-group-text">Nombre</span>
          </div>
          <input type="text" class="form-control" v-model="name"/>
        </div>
        <div class="input-group mt-2">
          <div class="input-group-prepend">
            <span class="input-group-text">Apellido</span>
          </div>
          <input type="text" class="form-control" v-model="surname"/>
        </div>
        <div class="input-group mt-2">
          <div class="input-group-prepend">
            <span class="input-group-text">Email</span>
          </div>
          <input type="email" class="form-control" v-model="email"/>
        </div>
        <div class="input-group mt-2">
          <textarea class="form-control" placeholder="Comentarios..." cols="30" rows="10" v-model="content"></textarea>
        </div>
        <button @click="saveContact" class="btn btn-lg btn-primary mt-3 float-right">Enviar</button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  created() {
    this.saveContact();
  },

  methods: {
    saveContact() {

      console.log(this.name)

      return;

      // fetch("/api/post?page=" + this.currentPage)
      //   .then(resp => resp.json())
      //   .then(json => {
      //     this.posts = json.data.data;
      //     this.total = json.data.last_page;
      //   });
    },
    getCurrentPage: function(val) {
      this.currentPage = val;
      this.getPosts();
    }
  },

  data: function() {
    return {
      name: "",
      surname: "",
      email: "",
      content: "",
    };
  }
};
</script>