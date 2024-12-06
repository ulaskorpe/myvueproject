<template>
  <div class="d-flex justify-content-center align-items-center vh-100">
    <div class="card p-4 shadow-lg" style="width: 400px;">
      <div class="card-body">
        <h5 class="card-title text-center mb-4">Create new </h5>
        <Link :href="`/mylist`" > BACKTOWAR </Link><br>
        <button @click="showAlert" class="btn btn-primary">Show Alert</button>
      <form>
        <div v-for="(field, index) in fields" :key="index" class="mb-3">
          <label :for="field" class="form-label">{{ field }}</label>
          <input
            :id="field"
            v-model="form[field]"
            class="form-control"
            :placeholder="'Enter ' + field"
            type="text"
          />
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
      </form>
    </div>
</div>
</div>
  </template>
<style scoped>
label {
  margin-right: 2em;
}

div {
  padding: 2px
}
</style>
<script setup>
import { Link } from '@inertiajs/vue3';
import { reactive } from 'vue';

const form = reactive({
    beds:0,
})
const x = form.beds
</script>

  <script>
  import Swal from "sweetalert2";
  import BlankLayout from '../../Layouts/BlankLayOut.vue';

  export default {
    layout: BlankLayout,
    props: {

      fields: {
        type: Array,
        required: true, // Ensures this prop is passed
      },
    },
    data() {
      return {
        form: this.fields.reduce((acc, field) => {
          acc[field] = ""; // Initialize each field with an empty string
          return acc;
        }, {}),
      };
    },
    methods: {
        showAlert() {
        Swal.fire({
            title: "Hello!",
            text: "This is a SweetAlert in Vue.",
            icon: "success",
            confirmButtonText: "Cool",
        });
    },
      handleSubmit() {
        console.log(this.form); // Log the form data
      },
    },
  };
  </script>
