<template>
<Link href="/myself">Myself</Link><br>
<Link href="/letsgo">Letsgo</Link>
<div>{{ timer }}</div>
<slot>default</slot>
</template>

<script setup>

import { Link } from '@inertiajs/vue3'
import {ref} from 'vue'

const timer = ref(0) ///proxy obj

function updateTimer() {
  if (timer.value >= 10) {
    timer.value = 0; // Reset to 0 when it reaches 100
  } else {
    timer.value++; // Increment otherwise
  }
}

setInterval(()=>updateTimer(),1000)
</script>
