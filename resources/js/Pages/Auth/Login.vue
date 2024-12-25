<template>
  <form @submit.prevent="login">
    <div class="w-1/2 mx-auto">
      <div>
        <label for="email" class="label">E-mail</label>
        <input
      id="email"
      ref="emailInput"
      v-model="form.email"
      type="text"
      class="input"
      placeholder="Enter your email"
    />
        <div v-if="form.errors.email" class="input-error">{{ form.errors.email }}</div>
      </div>
      <div class="mt-4">
        <label for="password" class="label">Password</label>
        <input id="password" v-model="form.password" type="password" class="input" />
        <div v-if="form.errors.password" class="input-error">{{ form.errors.password }}</div>
      </div>
      <div class="mt-4 text-center">
        <button class="btn-primary w-full w-1/4 " type="submit">Login</button>

        <div class="mt-2 text-center">
          <Link :href="route('user-account.create')" class="text-sm text-gray-500">
            Need an account? Click here
          </Link>
        </div>
      </div>
    </div>
  </form>
</template>

<script setup>
import { useForm, Link } from '@inertiajs/vue3'
import Swal from 'sweetalert2';
import { ref } from 'vue';
import { usePage } from '@inertiajs/vue3';
const form = useForm({
  email: null,
  password: null,
})

const emailInput = ref(null); // Create a ref for the input element

const { props } = usePage();
const successMessage = props.flash.success;

const login =async () =>{




    try {
    // Send the form data to the backend
    const response = await form.post(route('login.store'), {
      onSuccess:  ()  => {
        if (successMessage) {
  Swal.fire({
    title: 'Success!',
    text: successMessage,
    icon: 'success',
    confirmButtonText: 'Continue',
  });
}
        // const response = page.props;

        // Swal.fire({
        //   title: 'Login Successful!',
        //   text: response.message || 'Welcome back!',
        //   icon: 'success',
        //   confirmButtonText: 'Continue',
        // }).then(() => {
        //   // Redirect the user after successful login
        //   window.location.href = response.redirect || '/listing';
        // });
      },
      onError: (errors) => {
        // If there are validation errors
        Swal.fire({
          title: 'Validation Error!',
          text: Object.values(errors).join(', ') || 'Please check your input.',
          icon: 'error',
          confirmButtonText: 'Retry',
        });
      },
    });
  } catch (error) {
    // Handle any unexpected server or network errors
    Swal.fire({
      title: 'Error!',
      text: error.response?.data?.message || 'An unexpected error occurred.',
      icon: 'error',
      confirmButtonText: 'Retry',
    });
  }

}
</script>
