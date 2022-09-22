<template>
    <div>
        <div class="grid md:grid-cols-4 grid-cols-2 space-y-2 gap-3 mb-4">
            <div>
                <input v-model="input.name" @keyup="onSearch" type="text" placeholder="Cari nama tim" class="input w-full" />
            </div>
            <div>
                <select v-model="input.category" @change="onSearch" class="input w-full">
                    <option value="">Semua Kategori</option>
                    <option value="colleger">Mahasiswa</option>
                    <option value="student">Siswa</option>
                </select>
            </div>
            <div>
                <select v-model="input.competition" @change="onSearch" class="input w-full">
                    <option value="">Semua Lomba</option>
                    <option v-for="(item, index) in competitions" :key="index" :value="item.value">{{ item.label }}</option>
                </select>
            </div>
            <div>
                <select v-model="input.sort" @change="onSearch" class="input w-full">
                    <option value="">Paling baru</option>
                    <option value="asc">Paling lama</option>
                </select>
            </div>
        </div>
        <div v-if="administrations.data.length > 0" class="overflow-x-auto overflow-y-visible">
            <table class="table w-full">
                <thead>
                <tr>
                    <th></th>
                    <th>Name</th>
                    <th>Instansi</th>
                    <th>Kategori</th>
                    <th>Lomba</th>
                    <th>Keanggotaan</th>
                    <th>Administrasi</th>
                    <th>Penyisihan</th>
                    <th>Pembayaran</th>
                    <th>Aksi</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(item, index) in administrations.data">
                    <th>{{ (administrations.current_page - 1) * administrations.per_page + index + 1 }}</th>
                    <td>{{ item.name }}</td>
                    <td>{{ item.instance }}</td>
                    <td>{{ item.category === 'colleger' ? 'Mahasiswa' : 'Siswa' }}</td>
                    <td>{{ item.competitions === 'uiux' ? 'UiUx Competition' : item.competition === 'web' ? 'Web Competition' : 'Idea Bussiness' }}</td>
                    <td>{{ item.participant.length }} Anggota</td>
                    <td>
                        <span class="badge" :class="{'badge-success': item.is_confirmed === 1, 'badge-error': item.is_confirmed === 0}">
                            {{ item.is_confirmed === 1 ? 'Confirmed' : 'Uniconfirmed' }}
                        </span>
                    </td>
                    <td>
                        <span v-if="item.elimination !== null" class="badge" :class="{'badge-success': item.elimination.is_eliminated === 1, 'badge-error': item.elimination.is_eliminated === 0}">
                            {{ item.elimination.is_eliminated === 1 ? 'Passed' : 'Un-pass' }}
                        </span>
                    </td>
                    <td>
                        <span class="badge" :class="{'badge-success': item.payment_confirmation === 1, 'badge-error': item.payment_confirmation === 0}">
                            {{ item.payment === null ? 'Unpaid' : 'Paid' }}
                        </span>
                    </td>
                    <td class="relative">
                        <div class="dropdown dropdown-left dropdown-start">
                            <label tabindex="0" class="btn btn-ghost p-2 border border-gray-100 text-black">
                                <Icon icon="clarity:ellipsis-vertical-line" class="text-xl"/>
                            </label>
                            <ul tabindex="0" class="absolute z-50 dropdown-content menu p-2 text-sm shadow bg-base-100 rounded-box w-52">
                                <li>
                                    <label for="confirmation_modal" @click="selected = index">Konfirmasi Administrasi</label>
                                </li>
                                <li v-if="item.elimination">
                                    <label for="elimination_modal" @click="selected = index">Lolos Penyisihan</label>
                                </li>
                                <li v-if="item.payment !== null">
                                    <label for="payment_modal" @click="selected = index">Konfirmasi Pembayaran</label>
                                </li>
                                <li>
                                    <label for="delete_modal" class="bg-red-100 text-red-700">Hapus</label>
                                </li>
                            </ul>
                        </div>
                    </td>
                </tr>
                </tbody>
            </table>
            <input type="checkbox" id="confirmation_modal" class="modal-toggle" />
            <label for="confirmation_modal" id="confirmation_modal_label" class="modal cursor-pointer">
                <label class="modal-box w-11/12 max-w-5xl" for="">
                    <h3 class="font-bold text-lg">Konfirmasi Administrasi</h3>
                    <div class="form-control w-full">
                        <label class="label">
                            <span class="label-text font-bold text-cyan-700">Nama Tim</span>
                        </label>
                        <input maxlength="100" disabled required type="text" readonly v-model="administrations.data[selected].name" placeholder="eg. Tim Eskobar Dev" class="input hover:border-cyan-500 w-full"/>
                    </div>
                    <div class="form-control w-full">
                        <label class="label">
                            <span class="label-text font-bold text-cyan-700">Asal Instansi</span>
                        </label>
                        <input maxlength="100" disabled required type="text" v-model="administrations.data[selected].instance" placeholder="eg. Politeknik Elektronika Negeri Surabaya" class="input hover:border-cyan-500 w-full"/>
                    </div>
                    <div class="form-control w-full">
                        <label class="label">
                            <span class="label-text font-bold text-cyan-700">Asal Instansi</span>
                        </label>
                        <select required disabled v-model="administrations.data[selected].category" class="input border border-gray-200 hover:border-cyan-500 w-full">
                            <option value="">Pilih Kategori Instansi</option>
                            <option value="colleger">Kampus (Mahasiswa)</option>
                            <option value="student">Sekolah (Siswa)</option>
                        </select>
                    </div>
                    <div v-if="administrations.data[selected].participant.length > 0">
                        <div class="p-6 shadow-lg rounded-xl my-4 bg-white relative" v-for="(participant, index) in administrations.data[selected].participant" :key="`participant-${index}`">
                            <div class="form-control w-full">
                                <div class="label">
                                    <span class="label-text font-bold text-cyan-700 text-lg">{{ index == 0 ? 'Ketua Tim' : 'Anggota Tim '+index }}</span>
                                </div>
                                <input maxlength="100" required type="text" v-model="participant.name" placeholder="eg. Mohammad Fulan" class="input hover:border-cyan-500 border-px border-gray-200 w-full"/>
                            </div>
                            <div class="form-control w-full">
                                <div class="label">
                                    <span class="label-text font-bold text-cyan-700 text-lg">Foto Kartu Tanda {{ administrations.data[selected].category === 'student' ? ' Pelajar' : ' Mahasiswa' }}</span>
                                </div>
                                <div class="border-dashed border-2 overflow-hidden hover:bg-cyan-200 transition-all cursor-pointer rounded-xl border-cyan-500 text-cyan-700">
                                    <div v-if="participant.identity">
                                        <img class="w-full" :src="`/img/identity/${participant.identity}`" alt="Preview KTP/KTM">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-action">
                        <label for="confirmation_modal" class="btn btn-ghost">Batal</label>
                        <button @click="confirmAdministration()" class="btn" :class="{'btn-error': administrations.data[selected].is_confirmed, 'btn-info': administrations.data[selected].is_confirmed === 0}">
                            {{ administrations.data[selected].is_confirmed ? 'Tidak jadi' : 'Konfirmasi' }}
                        </button>
                    </div>
                </label>
            </label>

            <input type="checkbox" id="elimination_modal" class="modal-toggle" />
            <label for="elimination_modal" id="elemination_modal_label" class="modal cursor-pointer">
                <label class="modal-box w-11/12 max-w-5xl relative" for="">
                    <div class="flex justify-between items-center mb-5">
                        <h3 class="text-2xl font-bold mb-3">Penyisihan</h3>
                        <div class="text-3xl flex gap-3 my-4">
                            <Icon icon="icon-park:github-one" />
                            <Icon icon="logos:figma" />
                            <Icon icon="logos:google-drive" />
                            <Icon icon="logos:gitlab" />
                            <Icon icon="logos:heroku-icon" />
                        </div>
                    </div>
                    <div class="form-control w-full" v-if="administrations.data[selected].elimination">
                        <input readonly disabled maxlength="255" id="elimination-input" v-model="administrations.data[selected].elimination.link" required type="text" placeholder="eg. www.domain.com" class="input w-full shadow rounde-xl"/>
                        <div class="grid grid-cols-2 gap-3">
                            <label for="elimination_modal" class="btn btn-ghost mt-4 w-full">Tutup</label>
                            <button @click="confirmElemination()" class="btn mt-4 w-full" :class="{'btn-error': administrations.data[selected].elimination.is_eliminated, 'btn-info': administrations.data[selected].elimination.is_eliminated === 0}">
                                {{ administrations.data[selected].elimination.is_eliminated ? 'Tidak jadi' : 'Konfirmasi' }}
                            </button>
                        </div>
                    </div>
                </label>
            </label>

            <input type="checkbox" id="payment_modal" class="modal-toggle" />
            <label for="payment_modal" id="payment_modal_label" class="modal cursor-pointer">
                <label class="modal-box w-11/12 max-w-5xl relative" for="">
                    <h3 class="text-2xl font-bold mb-3">Konfirmasi Pembayaran</h3>
                    <div class="form-control w-full">
                        <div class="w-full border-dashed border-2 overflow-hidden hover:bg-cyan-200 transition-all cursor-pointer rounded-xl border-cyan-500 text-cyan-700">
                            <div v-if="administrations.data[selected].payment !== null">
                                <img class="w-full" :src="`/img/payment/${administrations.data[selected].payment}`" alt="Preview Pembayaran">
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-3">
                            <label for="payment-modal" class="btn btn-ghost mt-4 w-full">Tutup</label>
                            <button @click="confirmPayment()" class="btn mt-4 w-full" :class="{'btn-error': administrations.data[selected].payment_confirmation, 'btn-info': administrations.data[selected].payment_confirmation === 0}">
                                {{ administrations.data[selected].payment_confirmation ? 'Tidak jadi' : 'Konfirmasi' }}
                            </button>
                        </div>
                    </div>
                </label>
            </label>

            <input type="checkbox" id="delete_modal" class="modal-toggle" />
            <label for="delete_modal" id="delete_modal_label" class="modal cursor-pointer">
                <label class="modal-box relative" for="">
                    <h3 class="text-2xl font-bold mb-3">Hapus Administrasi ?</h3>
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
                    <a v-if="administrations.prev_page_url !== null" class="btn btn-ghost" :href="set_url_page(administrations.prev_page_url)">«</a>
                    <button class="btn btn-ghost">{{ administrations.current_page }}</button>
                    <a v-if="administrations.next_page_url !== null" class="btn btn-ghost" :href="set_url_page(administrations.next_page_url)">»</a>
                </div>
            </div>
        </div>
        <div v-else>
            <div class="alert text-white alert-error shadow-lg">
                <div class="flex w-full justify-between items-center">
                    <div class="flex gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current flex-shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        <span>Tidak ada data! data tim tidak ditemukan.</span>
                    </div>
                    <div>
                        <button @click="onReset()" class="btn bg-white border-0 text-red-600 ml-auto">Reset</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { Icon } from '@iconify/vue'
import {reactive} from "vue"

export default {
    props: ['administrations'],
    name: "TeamTable",
    data() {
        return {
            input: reactive({
                name: '',
                category: '',
                sort: '',
                competition: '',
            }),
            competitions: [{
                label: 'UiUx Competition',
                value: 'uiux',
            },{
                label: 'Idea Bussiness',
                value: 'bussiness',
            }, {
                label: 'Web Competition',
                value: 'web',
            }],
            selected: 0
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
            this.$inertia.get(this.route('dashboard'), this.input, {
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
        confirmAdministration() {
            let value = this.administrations.data[this.selected].is_confirmed ? 0 : 1
            this.$inertia.post(this.route('administration.confirm', this.administrations.data[this.selected].id), {
                is_confirmed: value,
            }, {
                preserveScroll: true,
                preserveState: true,
                onSuccess: (page) => {
                    document.getElementById('confirmation_modal_label').click()
                }
            })
        },
        confirmElemination() {
            let value = this.administrations.data[this.selected].elimination.is_eliminated ? 0 : 1
            this.$inertia.post(this.route('elimination.confirm', this.administrations.data[this.selected].elimination.id), {
                is_eliminated: value,
            }, {
                preserveScroll: true,
                preserveState: true,
                onSuccess: (page) => {
                    document.getElementById('elemination_modal_label').click()
                }
            })
        },
        confirmPayment() {
            let value = this.administrations.data[this.selected].payment_confirmation ? 0 : 1
            this.$inertia.post(this.route('administration.payment.confirmation', this.administrations.data[this.selected].id), {
                payment_confirmation: value,
            }, {
                preserveScroll: true,
                preserveState: true,
                onSuccess: (page) => {
                    document.getElementById('payment_modal_label').click()
                }
            })
        },
        onDestroy() {
            this.$inertia.delete(this.route('administration.destroy', this.administrations.data[this.selected].id), {
                preserveScroll: true,
                preserveState: true,
                onSuccess: (page) => {
                    document.getElementById('delete_modal_label').click()
                }
            })
        }
    },
}
</script>

<style scoped>

</style>
