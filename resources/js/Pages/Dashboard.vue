<template>
    <AppLayout title="Dashboard" :administration="administration">
        <div class="py-24 min-h-screen bg-gradient-to-br from-blue-500 to-cyan-500">
            <div class="max-w-7xl mx-auto px-8 sm:px-6 lg:px-8">
                <div class="bg-white shadow-xl sm:rounded-lg rounded-xl">
                    <div v-if="$page.props.user.role === 'user'">
                        <Welcome :administration="administration" :elimination="elimination"/>
                    </div>
                    <div v-else>
                        <div class="grid p-6 grid-cols-2 gap-4 border-b">
                            <div>
                                <a :href="route('dashboard')" class="btn w-full border btn-info">Team</a>
                            </div>
                            <div>
                                <a :href="route('dashboard.user')" class="btn w-full border btn-ghost">User</a>
                            </div>
                        </div>
                        <div class="bg-gray-50 p-6">
                            <team-table :administrations="administrations"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout.vue';
import Welcome from '@/Components/Welcome.vue';
import TeamTable from "@/Components/TeamTable.vue";

export default {
    props: ['administration', 'elimination', 'administrations', 'users'],
    components: {
        AppLayout,
        Welcome,
        TeamTable,
    },
    data() {
        return {
        }
    }
}
</script>
