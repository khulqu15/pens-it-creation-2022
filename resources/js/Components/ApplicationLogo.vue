<template>
    <div class="flex items-center pt-12 gap-5">
        <div>
            <img src="/img/himit-fest-logo.png" class="w-20 h-20">
        </div>
        <div v-if="administration[0]">
            <span class="my-font text-4xl">{{ competitions.find(item => item.value === administration[0].competitions).label }}</span>
        </div>
        <div v-else>
            <span class="my-font text-4xl">Himit Competitions 2022</span>
        </div>
    </div>
</template>

<script>
export default {
    props: ['administration'],
    data() {
        return {
            competitions: [{
                label: 'UiUx Competition',
                value: 'uiux',
            }, {
                label: 'Web Competitions',
                value: 'web',
            }, {
                label: 'Idea Bussiness',
                value: 'bussiness',
            }]
        }
    }
}
</script>
