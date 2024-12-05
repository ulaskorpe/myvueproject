<template>
  <div>Index</div>
  <Link href="/hello">
   count :: {{ counter }}
  </Link>
  <div>
    The message is {{ message }}
  </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'
defineProps({ message: String })

import {ref} from 'vue'
let counter  = ref(0)

// setInterval(() =>

//     counter.value++
//     //console.log(counter.value)



//     ,1000
// );

</script>
