<template>
    <AppLayout title="Dashboard">
        <div class="py-24 min-h-screen bg-gradient-to-br from-blue-500 to-cyan-500">
            <div class="max-w-7xl mx-auto px-8 sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg rounded-xl">
                    <Welcome :administration="administration" :elimination="elimination"/>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout.vue';
import Welcome from '@/Components/Welcome.vue';

export default {
    props: ['administration', 'elimination'],
    components: {
        AppLayout,
        Welcome,
    }
}
</script>
