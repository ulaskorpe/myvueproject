<template>
    <div class="d-flex justify-content-center align-items-center ">
      <div class="card p-4 shadow-lg" style="width: 700px;">
        <div class="card-body">
          <h5 class="card-title text-center mb-4">Create new</h5>
          <Link :href="`/mylist`">BACKTOWAR</Link><br>

          <form @submit.prevent="create">
            <div v-for="(field, index) in fields" :key="index" class="mb-3">
              <!-- Label -->
              <label :for="field.name" v-if="field.type !== 'hidden'" class="form-label">
                # {{ index + 1 }}. {{ field.name }}
              </label>

              <!-- Input Field -->
              <input
                :id="field.name"
                v-model="form[field.name]"
                class="form-control"
                :placeholder="'Enter ' + field.name"
                :type="field.type"
                v-show="field.type !== 'hidden'"
              />

              <!-- Error Message -->
              <div v-if="form.errors[field.name]" class="text-danger">
                {{ form.errors[field.name] }}
              </div>
            </div>

            <button type="submit" class="btn btn-primary">Create</button>
          </form>
        </div>
      </div>
    </div>
  </template>

  <style scoped>
  label {
    margin-right: 1em;
  }

  div {
    padding: 2px
  }
  </style>
  <script setup>
  import { Link } from '@inertiajs/vue3';
//  import { reactive } from 'vue';
  import { Inertia } from '@inertiajs/inertia';

  import { useForm } from '@inertiajs/inertia-vue3';

  // const form = reactive({
  const form = useForm({
      beds:0,
      baths:0,
      area:0,
      city : null,
      code : null,
      street : null,
      street_nr : null,
      price : 0,
      by_user_id : 1

  })




//const create = ()=>Inertia.post('/listing',form);

const create = () => {


  console.log('Form Errors:', form.errors); // Log the errors to see if they're populated

  form.post('/listing');
};
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
    //   data() {
    //     return {
    //       form: this.fields.reduce((acc, field) => {
    //         acc[field] = ""; // Initialize each field with an empty string
    //         return acc;
    //       }, {}),
    //     };
    //   },
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
