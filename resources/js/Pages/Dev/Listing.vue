<template>
  <Link :href="`/listing/create`" > Create Listing </Link><br>

<div v-for="(listing,index) in listings" v-bind:key="listing.id">

    <Link :href="`/listing/${listing.id}`">
        <ListingAddress :listing="listing" />
</Link>


</div>

 </template>
    <script setup>
    import { Link } from '@inertiajs/vue3';
    defineProps({
        listings : Array
    })
</script>
    <script >
    //// this is persistence layout
    import BlankLayout from '../../Layouts/BlankLayOut.vue';
    import ListingAddress from '@/Components/ListingAddress.vue';
import Listing from '../Listing/Index/Components/Listing.vue';

    export default {
        layout: BlankLayout
    }
    </script>
