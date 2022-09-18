<template>
    <div>
        <div class="grid grid-cols-3 gap-3 mb-4">
            <div>
                <input v-model="input.name" @keyup="onSearch" type="text" placeholder="Cari nama tim" class="input w-full" />
            </div>
            <div>
                <select v-model="input.role" @change="onSearch" class="input w-full">
                    <option value="">Pilih role</option>
                    <option value="admin">Admin</option>
                    <option value="user">User</option>
                </select>
            </div>
            <div>
                <select v-model="input.sort" @change="onSearch" class="input w-full">
                    <option value="">Paling baru</option>
                    <option value="asc">Paling lama</option>
                </select>
            </div>
        </div>
        <table class="table w-full">
            <thead>
            <tr>
                <th></th>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Aksi</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(item, index) in users.data">
                <th>{{ (users.current_page - 1) * users.per_page + index + 1 }}</th>
                <td>{{ item.name }}</td>
                <td>{{ item.email }}</td>
                <td>{{ item.role === 'admin' ? 'Admin' : 'User' }}</td>
                <td>
                    <div v-if="item.role === 'user'" class="dropdown dropdown-left dropdown-start">
                        <label tabindex="0" class="btn btn-ghost p-2 border border-gray-100 text-black">
                            <Icon icon="clarity:ellipsis-vertical-line" class="text-xl"/>
                        </label>
                        <ul tabindex="0" class="dropdown-content menu p-2 text-sm shadow bg-base-100 rounded-box w-52">
                            <li><label for="delete_modal" @click="selected = index" class="bg-red-100 text-red-700">Hapus</label></li>
                        </ul>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>

        <input type="checkbox" id="delete_modal" class="modal-toggle" />
        <label for="delete_modal" id="delete_modal_label" class="modal cursor-pointer">
            <label class="modal-box relative" for="">
                <h3 class="text-2xl font-bold mb-3">Hapus User ?</h3>
                <div class="form-control w-full">
                    <div class="grid grid-cols-2 gap-3">
                        <label for="delete_modal" class="btn btn-ghost mt-4 w-full">Tutup</label>
                        <button @click="onDestroy()" class="btn mt-4 w-full btn-error">Hapus</button>
                    </div>
                </div>
            </label>
        </label>

        <div class="text-right">
            <div class="btn-group mt-4 ml-auto inline-block">
                <a v-if="users.prev_page_url !== null" class="btn btn-ghost" :href="set_url_page(users.prev_page_url)">«</a>
                <button class="btn btn-ghost">{{ users.current_page }}</button>
                <a v-if="users.next_page_url !== null" class="btn btn-ghost" :href="set_url_page(users.next_page_url)">»</a>
            </div>
        </div>
    </div>
</template>

<script>
import { Icon } from '@iconify/vue'
import {reactive} from "vue";
export default {
    props: ['users'],
    data() {
        return {
            selected: 0,
            input: reactive({
                name: '',
                role: '',
                sort: '',
            }),
        }
    },
    mounted() {
        console.log(this.administrations)
    },
    components: {
        Icon
    },
    methods: {
        onSearch() {
            this.$inertia.get(this.route('dashboard.user'), this.input, {
                preserveState: true,
                preserveScroll: true
            })
        },
        set_url_page(link) {
            if(link !== null) {
                console.log(link)
                let str = Object.entries(this.input).map(([key, val]) => `${key}=${val}`).join('&');
                return link+'&'+str
            }
        },
        onDestroy() {
            this.$inertia.delete(this.route('user.destroy', this.users.data[this.selected].id), {
                preserveScroll: true,
                preserveState: true,
                onSuccess: (page) => {
                    document.getElementById('delete_modal_label').click()
                }
            })
        }
    }
}
</script>

<style scoped>

</style>
