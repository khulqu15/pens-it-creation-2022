<template>
    <div>
        <div id="header" class="relative">
            <img src="/img/bg-hero.png" class="w-full h-auto absolute top-0 left-0">
            <LayoutHeader/>
            <div class="flex justify-center pt-24">
                <div class="relative">
                    <h1 class="my-font text-8xl relative z-10 text-cyan-600">HIMIT FEST 2022</h1>
                    <h1 class="my-font text-8xl absolute -bottom-2 text-yellow-600">HIMIT FEST 2022</h1>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { Link } from '@inertiajs/inertia-vue3'
import LayoutHeader from '@/Components/LayoutHeader.vue'
export default {
    components: {
        LayoutHeader,
        Link,
    }
}
</script>
