<template>
  <Link :href="`/listing/create`"  class="btn btn-primary" > Create Listing </Link><br>
  <Link href="/mylist">Listings</Link>&nbsp;

  <div v-if="true">

  <div v-for="(listing,index) in listings" v-bind:key="listing.id">


<ListingAddress :listing="listing" />
<br>
<Link :href="`/listing/${listing.id}`">
    SHOWxxx
</Link>

<div v-if="false">
<Link :href="`/listing/${listing.id}/edit`">Edit</Link><br>
<Link :href="route('listing.edit',{listing:listing.id})">EditZIGGY</Link>

</div>
<div>
<Link :href="`/listing/${listing.id}`" method="DELETE">Delete</Link><br>
<Link :href="route('listing.destroy',{listing:listing.id})">destroyZIGGY</Link>
</div>
<hr>
</div>

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
import MainLayout from '@/Layouts/MainLayout.vue';

    export default {
       layout: BlankLayout
    }
    </script>
