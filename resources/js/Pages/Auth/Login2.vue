
<template>
    <form @submit.prevent="login">
      <input
        v-model="form.email"
        type="text"
        class="input"
        placeholder="Enter your email"
      />
      <input
        v-model="form.password"
        type="password"
        class="input"
        placeholder="Enter your password"
      />
      <button type="submit" class="button">Login</button>
    </form>
  </template>



<script setup>
import { useForm } from '@inertiajs/vue3';
import Swal from 'sweetalert2';

const form = useForm({
  email: '',
  password: '',
});

const login = async () => {
  try {
    // Make the POST request to the backend (Inertia)
    await form.post(route('login.store'), {
      onSuccess: (page) => {
        // Capture the response from backend
        const response = page.props; // Inertia response will contain the JSON data

        // Handle success or error based on the response
        if (response.status === 'success') {
          Swal.fire({
            title: 'Success!',
            text: response.message || 'Welcome back!',
            icon: 'success',
            confirmButtonText: 'Continue',
          }).then(() => {
            // Redirect after successful login (if provided)
            if (response.redirect) {
              window.location.href = response.redirect;
            }
          });
        } else {
          Swal.fire({
            title: 'Error!',
            text: response.message || 'Something went wrong!',
            icon: 'error',
            confirmButtonText: 'Retry',
          });
        }
      },
      onError: (errors) => {
        // Handle validation errors
        Swal.fire({
          title: 'Error!',
          text: Object.values(errors).join(', ') || 'There was a problem!',
          icon: 'error',
          confirmButtonText: 'Retry',
        });
      },
    });
  } catch (error) {
    Swal.fire({
      title: 'Error!',
      text: 'An unexpected error occurred.',
      icon: 'error',
      confirmButtonText: 'Retry',
    });
  }
};
</script>
