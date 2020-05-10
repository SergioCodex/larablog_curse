<template>
  <div>
    <div class="form-group">
      <label>{{ label }}</label>
      <input
        v-if="mask"
        :type="type"
        :class="{'is-valid': !validator.$error && validator.$dirty, 'is-invalid': validator.$error}"
        class="form-control"
        v-on:input="$emit('input', $event.target.value)"
        v-mask="mask"
      />
      <input
        v-else
        :type="type"
        :class="{'is-valid': !validator.$error && validator.$dirty, 'is-invalid': validator.$error}"
        class="form-control"
        v-on:input="$emit('input', $event.target.value)"
      />
    </div>
  </div>
</template>

<script>
export default {
  props: {
    label: {
      type: String,
      required: true
    },
    type: {
      type: String,
      default: "text",
      validator(value) {
        return ["text", "email", "password"].includes(value);
      }
    },
    value: {
      type: String,
      required: true
    },
    validator: {
      type: Object,
      required: true
    },
    mask: {
      type: String,
      required: false
    }
  }
};
</script>