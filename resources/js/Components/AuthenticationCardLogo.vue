<script setup>
import { Link } from '@inertiajs/inertia-vue3';
</script>

<template>
    <Link :href="'/'">
        <div class="flex items-center justify-center gap-4">
            <div class="relative">
                <h1 class="my-font text-8xl my-6 text-yellow-600 absolute top-2 left-1">HIMIT</h1>
                <h1 class="my-font text-8xl my-6 text-cyan-700 relative">HIMIT</h1>
            </div>
            <div class="relative">
                <h1 class="my-font text-5xl my-6 text-yellow-600 absolute top-1 left-1">FEST <br> 2022</h1>
                <h1 class="my-font text-5xl my-6 text-cyan-700 relative">FEST <br> 2022</h1>
            </div>
        </div>
    </Link>
</template>
