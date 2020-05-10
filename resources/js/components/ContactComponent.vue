<template>
  <div class="col-8 offset-2">
    <div class="card">
      <div class="card-header"><h3>Contáctame <i class="fa fa-smile-beam text-success"></i></h3></div>
      <div class="card-body">
        <form @submit.prevent="onSubmit" class="contact">
          <BaseInput label="Nombre" v-model="$v.form.name.$model" :validator="$v.form.name"></BaseInput>
          <BaseInput label="Apellido" v-model="$v.form.surname.$model" :validator="$v.form.surname"></BaseInput>
          <BaseInput
            label="Email"
            type="email"
            v-model="$v.form.email.$model"
            :validator="$v.form.email"
          ></BaseInput>
          <BaseInput
            label="Teléfono"
            v-model="$v.form.phone.$model"
            :mask="'(###) ###-###-###'"
            :validator="$v.form.phone"
          ></BaseInput>
          <div class="form-group">
            <label>Contenido</label>
            <textarea v-model="$v.form.content.$model" class="form-control" rows="3"></textarea>
          </div>
          <button :disabled="!formValid" type="submit" class="btn btn-primary"> <i class="fa fa-envelope"></i> Enviar</button>
          <button class="btn btn-danger btn-sm" @click="resetForm"> <i class="fa fa-redo"></i> Limpiar</button>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
import BaseInput from "../components/BaseInput.vue";
import { required, minLength, email } from "vuelidate/lib/validators";

export default {
  components: {
    BaseInput
  },
  created() {},
  data() {
    return {
      form: {
        name: "",
        surname: "",
        email: "",
        phone: "",
        content: ""
      }
    };
  },
  validations: {
    form: {
      name: {
        required,
        minLength: minLength(2)
      },
      surname: {
        required,
        minLength: minLength(2)
      },
      email: {
        required,
        email
      },
      phone: {
        required,
        minLength: minLength(14)
      },
      content: {
        required
      }
    }
  },
  methods: {
    resetForm() {
      this.$v.form.name.$model = "";
      this.$v.form.surname.$model = "";
      this.$v.form.email.$model = "";
      this.$v.form.phone.$model = "";
      this.$v.form.content.$model = "";

      this.$v.$reset();

      document
        .querySelectorAll("form.contact input, form.contact textarea")
        .forEach(ele => (ele.value = ""));
      this.$awn.info("Formulario reiniciado");
    },
    onSubmit() {
      if (this.formValid) {
        axios
          .post("/api/contact", {
            name: this.$v.form.name.$model,
            surname: this.$v.form.surname.$model,
            email: this.$v.form.email.$model,
            phone: this.$v.form.phone.$model,
            message: this.$v.form.content.$model
          })
          .then(resp => {
            this.$awn.success("Contacto registrado con éxito");
          });
      }
    }
  },
  computed: {
    formValid() {
      return !this.$v.$invalid;

      //   return (
      //     this.form.name.length > 0 &&
      //     this.form.surname.length > 0 &&
      //     this.form.phone.length > 0 &&
      //     this.form.email.length > 0 &&
      //     this.form.content.length > 0
      //   );
    }
  }
};
</script>

<style lang="scss">
@import "~vue-awesome-notifications/dist/styles/style.scss";
</style>