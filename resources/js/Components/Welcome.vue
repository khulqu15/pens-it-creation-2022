<template>
    <div>
        <div class="p-6 sm:px-6 bg-white border-b border-gray-200">
            <div>
                <ApplicationLogo :administration="administration" class="block h-12 w-auto" />
            </div>

            <div class="mt-12 text-gray-500">
                <span v-if="administration[0] && administration[0].category === 'colleger'">
                    Web Design Competition adalah perlombaan yang diperuntukan bagi mahasiswa/I aktif program sarjana maupun diploma di perguruan tinggi swasta atau negeri di seluruh Indonesia dengan menguji kreativitasnya dalam mendesain web. Keberadaan lomba ini diharapkan dapat menjadi wadah bagi mahasiswa/I dalam menuangkan ide-ide
                </span>
                <span v-else>
                    Kompetisi User Interface (UI)/User Experience (UX) Design adalah kompetisi desain antarmuka sistem/produk yang berorientasi kepada kenyamanan dan kemudahan pengguna (user) dalam menggunakan sistem/produk tersebut.
                </span>
            </div>
        </div>

        <div class="bg-gray-200 bg-opacity-25 grid grid-cols-1 md:grid-cols-1">
            <div class="p-6 border-b">
                <div class="flex justify-between items-center">
                    <div class="mt-2 text-sm text-gray-500">
                        <div class="flex items-center">
                            <Icon icon="akar-icons:folder-add" class="text-3xl"/>
                            <div class="ml-4 text-lg text-gray-600 leading-7 font-semibold">
                                <a href="#">Administrasi
                                    <div v-if="administration[0] !== null" class="badge gap-2" :class="{'badge-error': administration[0].is_confirmed === 0, 'badge-success': administration[0].is_confirmed}">
                                        {{ administration[0] && administration[0].is_confirmed === 0 ? 'Menunggu Konfirmasi' : 'Sudah Dikonfirmasi' }}
                                    </div>
                                    <div v-else class="badge gap-2 badge-ghost">
                                        Belum diisi
                                    </div>
                                </a>
                            </div>
                        </div>
                        <p class="mt-3 ml-12">Lengkapi berkas - berkas pendaftaran sesuai persyaratan dan upload pada akunmu</p>
                    </div>
                    <div>
                        <a v-if="administration[0] === null" :href="route('administration.create')" class="btn bg-yellow-500 border-0 hover:bg-yellow-700 text-black pt-1 px-6 mt-3">Lengkapi</a>
                        <a v-else :href="administration[0].is_confirmed === 1 ? '#' : route('administration.edit', administration[1])" class="btn bg-green-500 border-0 hover:bg-green-700 text-black pt-1 px-6 mt-3"
                            :class="{'btn-disabled opacity-50': administration[0].is_confirmed === 1}">
                            {{ administration[0].participant.length < 2 ? 'Lengkapi' : 'Edit' }}
                        </a>
                    </div>
                </div>
            </div>

            <div class="p-6 border-b">
                <div class="flex justify-between items-center">
                    <div class="mt-2 text-sm text-gray-500">
                        <div class="flex items-center">
                            <Icon icon="akar-icons:double-sword" class="text-3xl"/>
                            <div class="ml-4 text-lg text-gray-600 leading-7 space-x-1 font-semibold">
                                <a href="#">Penyisihan
                                    <div v-if="administration[0] && administration[0].elimination !== null" class="badge gap-2" :class="{'badge-error': administration[0].elimination.is_eliminated === 0, 'badge-success': administration[0].elimination.is_eliminated === 1}">
                                        {{ administration[0].elimination.is_eliminated === 0 ? 'Belum Tereliminasi' : 'Lolos Penyisihan' }}
                                    </div>
                                    <div v-else class="badge gap-2 badge-ghost">
                                        Belum diisi
                                    </div>
                                </a>
                            </div>
                        </div>
                        <p class="mt-3 ml-12">Babak penyisihan untuk menentukan kamu masuk babak final</p>
                    </div>
                    <div v-if="administration[0] && administration[0].is_confirmed">
                        <label :for="administration[0].elimination === null || administration[0].elimination.is_eliminated !== 1 ? 'elimination-modal' : ''" id="elimination-modal-label" v-if="administration[0]"
                            class="btn border-0 text-black pt-1 px-6 mt-3"
                            :class="{'bg-yellow-500 hover:bg-yellow-700': administration[0].elimination === null, 'bg-green-500 hover:bg-green-700': administration[0].elimination !== null, 'btn-disabled opacity-50': administration[0].elimination && administration[0].elimination.is_eliminated === 1}">
                            {{ administration[0].elimination === null ? 'Lengkapi' : 'Edit' }}
                        </label>
                        <input type="checkbox" id="elimination-modal" class="modal-toggle" />
                        <label for="elimination-modal" class="modal cursor-pointer">
                            <label class="modal-box relative" for="">
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
                                <p class="text-gray-500 mb-5">Kamu bisa mengirimkan link github, figma, drive atau yang lainnya.</p>
                                <form @submit.prevent="onEliminationSubmit()">
                                    <div class="form-control w-full">
                                        <input maxlength="255" id="elimination-input" v-model="form.elimination.link" required type="text" placeholder="eg. www.domain.com" class="input w-full shadow rounde-xl"/>
                                        <div class="grid grid-cols-2 gap-3">
                                            <label for="elimination-modal" class="btn btn-ghost mt-4 w-full">Tutup</label>
                                            <button class="btn btn-warning mt-4 w-full">Simpan</button>
                                        </div>
                                    </div>
                                </form>
                            </label>
                        </label>
                    </div>
                </div>
            </div>

            <div class="p-6">
                <div class="flex justify-between items-center">
                    <div class="mt-2 text-sm text-gray-500">
                        <div class="flex items-center">
                            <Icon icon="akar-icons:money" class="text-3xl"/>
                            <div class="ml-4 text-lg text-gray-600 leading-7 font-semibold">
                                <a href="#">Pembayaran
                                    <div v-if="administration[0] !== null && administration[0].payment !== null" class="badge gap-2" :class="{'badge-error': administration[0].payment_confirmation === 0, 'badge-success': administration[0].payment_confirmation}">
                                        {{ administration[0].payment_confirmation === 0 ? 'Menunggu Konfirmasi' : 'Sudah Dikonfirmasi' }}
                                    </div>
                                    <div v-else class="badge gap-2 badge-ghost">
                                        Belum diisi
                                    </div>
                                </a>
                            </div>
                        </div>
                        <p class="mt-3 ml-12">Lakukan pembayaran sesuai jenis lomba dan upload bukti pembayaran pada akunmu</p>
                    </div>
                    <div v-if="administration[0] && administration[0].elimination !== null">
                        <label v-if="administration[0].elimination.is_eliminated === 1" id="payment-modal-label" :for="administration[0].payment_confirmation === 0 ? 'payment-modal' : ''" class="btn bg-yellow-500 border-0 hover:bg-yellow-700 text-black pt-1 px-6 mt-3"
                            :class="{'bg-yellow-500 hover:bg-yellow-700': administration[0].payment === null, 'bg-green-500 hover:bg-green-700': administration[0].payment, 'btn-disabled opacity-50': administration[0] && administration[0].payment_confirmation === 1}">
                            {{ administration[0].payment === null ? 'Lengkapi' : 'Edit' }}
                        </label>
                        <input type="checkbox" id="payment-modal" class="modal-toggle" />
                        <label for="payment-modal" class="modal cursor-pointer">
                            <label class="modal-box relative" for="">
                                <h3 class="text-xl font-bold mb-3">Kirimkan Bukti Pembayaran</h3>
                                <form @submit.prevent="onPaymentSubmit()" enctype="multipart/form-data">
                                    <div class="form-control w-full">
                                        <input id="payment-input" @change="onChangePaymentFile($event)" required type="file" accept="image/png, image/jpg, image/jpeg" placeholder="eg. Mohammad Fulan" class="hidden"/>
                                        <label for="payment-input" class="w-full border-dashed border-2 overflow-hidden hover:bg-cyan-200 transition-all cursor-pointer rounded-xl border-cyan-500 text-cyan-700">
                                            <div v-if="form.payment.preview === null && form.payment.payment === null" class="flex p-8 justify-center gap-3 items-center">
                                                <Icon icon="akar-icons:image" class="text-3xl"></Icon>
                                                <h1>Klik untuk menambahkan</h1>
                                            </div>
                                            <div v-else>
                                                <img class="w-full" :src="form.payment.preview" alt="Preview Pembayaran">
                                            </div>
                                        </label>
                                        <div class="grid grid-cols-2 gap-3">
                                            <label for="payment-modal" class="btn btn-ghost mt-4 w-full">Tutup</label>
                                            <button class="btn btn-warning mt-4 w-full">Simpan</button>
                                        </div>
                                    </div>
                                </form>
                            </label>
                        </label>
                    </div>
                </div>
            </div>

        </div>
    </div>
</template>

<script>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Icon } from '@iconify/vue'
import {reactive} from "vue";

export default {
    props: ['administration', 'elimination'],
    components: {
        Icon,
        ApplicationLogo
    },
    data() {
        return {
            loader: false,
            form: {
                elimination: reactive({
                    link: '',
                    administration_id: null
                }),
                payment: reactive({
                    payment: null,
                    administration_id: null,
                    preview: null,
                })
            }
        }
    },
    mounted() {
        if(this.administration[0]) {
            this.form.elimination.administration_id = this.administration[0].id
            this.form.payment.administration_id = this.administration[0].id
            if(this.administration[0].elimination)
                this.form.elimination.link = this.administration[0].elimination.link
            if(this.administration[0].payment)
                this.form.payment.preview = '/img/payment/'+this.administration[0].payment
                this.form.payment.payment = this.administration[0].payment
        }
    },
    methods: {
        onChangePaymentFile(e) {
            let file = e.target.files[0]
            this.form.payment.payment = file
            this.form.payment.preview = URL.createObjectURL(file)
        },
        onEliminationSubmit() {
            this.loader = true
            if(this.administration[0].elimination !== null)
                this.form.elimination._method = 'PATCH'

            let url = this.administration[0].elimination === null ? this.route('elimination.store') : this.route('elimination.update', this.elimination[1])
            this.$inertia.post(url, this.form.elimination, {
                onFinish: visit => {
                    this.loader = true
                },
                onSuccess: (page) => {
                    document.getElementById('elimination-modal-label').click()
                }
            })
        },
        onPaymentSubmit() {
            this.loader = true
            this.$inertia.post(this.route('administration.payment', this.administration[1]), this.form.payment, {
                onFinish: visit => {
                    this.loader = true
                },
                onSuccess: (page) => {
                    document.getElementById('payment-modal-label').click()
                }
            })
        },
    }
}
</script>
