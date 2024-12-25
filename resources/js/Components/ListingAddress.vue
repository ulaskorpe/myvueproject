<template>
  <span>
    Address:
    {{ listing.street }} {{ listing.street_nr }}, {{
      listing.city }}
      <br>
      Price :
      {{ listing.price }}

  </span>
</template>

<script setup>
defineProps({
  listing: Object,
})
</script>
