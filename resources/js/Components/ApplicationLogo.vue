<template>
    <div class="flex items-center pt-12 gap-5">
        <div>
            <img src="/img/himit-fest-logo.png" class="w-20 h-20">
        </div>
        <div>
            <span class="my-font text-4xl">{{ administration[0] ? administration[0].category === 'student' ? 'UiUx' : 'Web' : 'Himit' }} Competition  2022</span>
        </div>
    </div>
</template>

<script>
export default {
    props: ['administration']
}
</script>
