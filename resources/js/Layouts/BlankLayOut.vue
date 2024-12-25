<template>
   <header class="border-b border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 w-full">
    <div class="container mx-auto">
      <nav class="p-4 flex items-center justify-between">
        <div class="text-lg font-medium">
          <Link :href="route('listing.index')">Listings</Link>
        </div>
        <div class="text-xl text-indigo-600 dark:text-indigo-300 font-bold text-center">
          <Link :href="route('listing.index')">LaraZillow</Link>
        </div>
        <div v-if="false" class="flex items-center gap-4">
          <Link
            class="text-gray-500 relative pr-2 py-2 text-lg"
            :href="route('notification.index')"
          >
            🔔
            <div v-if="notificationCount" class="absolute right-0 top-0 w-5 h-5 bg-red-700 dark:bg-red-400 text-white font-medium border border-white dark:border-gray-900 rounded-full text-xs text-center">
              {{ notificationCount }}
            </div>
          </Link>

          <Link class="text-sm text-gray-500" :href="route('realtor.listing.index')">{{ user.name }}</Link>
          <Link :href="route('realtor.listing.create')" class="btn-primary">+ New Listing</Link>
          <div>
            <Link :href="route('logout')" method="delete" as="button">Logout</Link>
          </div>
        </div>

        <div v-else class="flex items-center gap-2">
          <Link :href="route('user-account.create')">Register</Link>
          <Link :href="route('login')">Sign-In</Link>
        </div>
      </nav>
    </div>
  </header>
<div>

  <div v-if="page.props.flash.success" class="alert alert-success">
    {{ page.props.flash.success }}
  </div>

<Link href="/listing">Listings</Link>&nbsp;
<Link href="/listing/create">New Listing</Link>

    <slot>default</slot>
</div>
    </template>
<script setup>
import { ref ,computed} from 'vue';

import { Link, usePage } from '@inertiajs/vue3'

const x = ref(2)
const y = computed(()=>x.value*3)
</script>

<script>
export default {
  computed: {
    page() {
      return this.$page; // Inertia exposes the current page props here
    },
  },
};
</script>
<style scoped>
.success {
  background-color: green;
  color: white;
}
</style>
