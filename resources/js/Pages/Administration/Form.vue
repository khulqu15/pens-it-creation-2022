<template>
    <AppLayout title="Dashboard" :administration="[form.administration, '']">
        <div class="py-24 min-h-screen bg-gradient-to-br from-blue-500 to-cyan-500">
            <div class="max-w-7xl mx-auto px-8 sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg rounded-xl">
                    <div class="p-6 border-b">
                        <h1 class="text-2xl font-bold">{{ form.mode }}</h1>
                    </div>
                    <form v-if="form.mode === 'Administrasi'" @submit.prevent="onSubmitAdministration()">
                        <div class="bg-gray-50 py-6 px-12 space-y-4">
                            <div class="form-control w-full">
                                <label class="label">
                                    <span class="label-text font-bold text-cyan-700 text-lg">Nama Tim</span>
                                </label>
                                <input maxlength="100" required type="text" v-model="form.administration.name" placeholder="eg. Tim Eskobar Dev" class="input hover:border-cyan-500 w-full"/>
                            </div>
                            <div class="form-control w-full">
                                <label class="label">
                                    <span class="label-text font-bold text-cyan-700 text-lg">Asal Instansi</span>
                                </label>
                                <input maxlength="100" required type="text" v-model="form.administration.instance" placeholder="eg. Politeknik Elektronika Negeri Surabaya" class="input hover:border-cyan-500 w-full"/>
                            </div>
                            <div class="form-control w-full">
                                <label class="label">
                                    <span class="label-text font-bold text-cyan-700 text-lg">Kategori Instansi</span>
                                </label>
                                <select @change="onChangeCategory()" required v-model="form.administration.category" class="input hover:border-cyan-500 w-full">
                                    <option :value="null">Pilih Kategori Instansi</option>
                                    <option value="colleger">Kampus (Mahasiswa)</option>
                                    <option value="student">Sekolah (Siswa)</option>
                                </select>
                            </div>
                            <div v-if="form.administration.category" class="form-control w-full">
                                <label class="label">
                                    <span class="label-text font-bold text-cyan-700 text-lg">Kategori Lomba</span>
                                </label>
                                <select required v-model="form.administration.competitions" class="input hover:border-cyan-500 w-full">
                                    <option v-for="(item, index) in competitions" :key="index" :value="item.value">{{ item.label }}</option>
                                </select>
                            </div>
                            <div class="text-right space-x-3">
                                <a :href="route('dashboard')" type="button" class="btn btn-ghost px-5">Batal</a>
                                <button :disabled="loader" type="submit" class="btn btn-info px-5">
                                    <div v-if="loader">
                                        Memproses
                                    </div>
                                    <div v-else>
                                        Selanjutnya
                                    </div>
                                </button>
                            </div>
                        </div>
                    </form>
                    <form v-if="form.mode === 'Peserta'">
                        <div class="bg-gray-50 py-6 px-12 space-y-4">
                            <div v-if="form.participants.length > 0">
                                <div class="p-6 shadow-lg rounded-xl my-4 bg-white relative" v-for="(participant, index) in form.participants" :key="`participant-${index}`">
                                    <div class="absolute right-0 top-0">
                                        <button @click="removeParticipant(index)" type="button" class="btn bg-white border-0 hover:text-red-600 hover:bg-gray-200 text-red-500">
                                            <Icon icon="eva:close-fill" class="text-2xl"/>
                                        </button>
                                    </div>
                                    <div class="form-control w-full">
                                        <label class="label">
                                            <span class="label-text font-bold text-cyan-700 text-lg">{{ index == 0 ? 'Ketua Tim' : 'Anggota Tim '+index }}</span>
                                        </label>
                                        <input maxlength="100" required type="text" v-model="form.participants[index].name" placeholder="eg. Mohammad Fulan" class="input hover:border-cyan-500 border-px border-gray-200 w-full"/>
                                    </div>
                                    <div class="form-control w-full">
                                        <label class="label">
                                            <span class="label-text font-bold text-cyan-700 text-lg">Foto Kartu Tanda {{ form.administration.category === 'student' ? ' Pelajar' : ' Mahasiswa' }}</span>
                                        </label>
                                        <input :id="`participant-${index}`" @change="onChangeIdentityFile($event, index)" required type="file" accept="image/png, image/jpg, image/jpeg" placeholder="eg. Mohammad Fulan" class="hidden"/>
                                        <label :for="`participant-${index}`" class="border-dashed border-2 overflow-hidden hover:bg-cyan-200 transition-all cursor-pointer rounded-xl border-cyan-500 text-cyan-700">
                                            <div v-if="form.participants[index].identity !== null || form.participants[index].preview !== null">
                                                <img class="w-full" :src="form.participants[index].preview" alt="Preview KTP/KTM">
                                            </div>
                                            <div v-else class="flex p-8 justify-center gap-3 items-center">
                                                <Icon icon="akar-icons:image" class="text-3xl"></Icon>
                                                <h1>Klik untuk menambahkan</h1>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <button v-if="form.participants.length < max_count" type="button" @click="addParticipant()" class="btn text-neutral hover:text-white w-full text-center bg-white">
                                Tambah Peserta
                            </button>
                            <div class="text-right space-x-3">
                                <button @click="onBackFromParticipantForm" type="button" class="btn btn-ghost px-5">Administrasi</button>
                                <button :disabled="loader" @click="onSubmit()" type="submit" class="btn btn-info px-5">
                                    <div v-if="loader">
                                        Memproses
                                    </div>
                                    <div v-else>
                                        Selanjutnya
                                    </div>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout.vue'
import { Icon } from '@iconify/vue'
import { reactive } from 'vue'

export default {
    props: ['data', 'mode'],
    data() {
        return {
            loader: false,
            competitions: [],
            max_count: 3,
            form: {
                mode: 'Administrasi',
                administration: reactive({
                    name: '',
                    instance: '',
                    category: null,
                    competitions: '',
                    user_id: this.$page.props.user.id,
                }),
                participants: []
            }
        }
    },
    mounted() {
        if(this.data) {
            this.form.administration.name = this.data[0].id
            this.form.administration.name = this.data[0].name
            this.form.administration.instance = this.data[0].instance
            this.form.administration.category = this.data[0].category
            if(this.form.administration.category === 'student') {
                this.competitions = [{
                    label: 'UiUx Competition',
                    value: 'uiux',
                }]
            } else if(this.form.administration.category === 'colleger') {
                this.competitions = [{
                    label: 'Idea Bussiness',
                    value: 'bussiness',
                }, {
                    label: 'Web Competitions',
                    value: 'web',
                }]
            }
            setTimeout(() => {
                this.form.administration.competitions = this.data[0].competitions
            }, 250)
            if(this.data[0].participant.length > 0) {
                this.data[0].participant.map((participant, index) => {
                    let item = reactive({
                        id: participant.id,
                        name: participant.name,
                        role: participant.role,
                        identity: null,
                        preview: '/img/identity/'+participant.identity,
                    })
                    this.form.participants.push(item)
                })

            }
        }
        if(this.mode === 'edit') {
            this.form.administration._method = 'PATCH'
        }
    },
    components: {
        AppLayout,
        Icon,
    },
    methods: {
        onChangeCategory() {
            this.form.administration.competitions = ''
            if(this.form.administration.category === 'student') {
                this.competitions = [{
                    label: 'UiUx Competition',
                    value: 'uiux',
                }]
                this.form.administration.competitions = 'uiux'
            } else if(this.form.administration.category === 'colleger') {
                this.competitions = [{
                    label: 'Idea Bussiness',
                    value: 'bussiness',
                }, {
                    label: 'Web Competitions',
                    value: 'web',
                }]
                this.form.administration.competitions = 'bussiness'
            }
        },
        onSubmitAdministration() {
            let url = this.mode === 'create' ? this.route('administration.store') : this.route('administration.update', this.data[1])
            if(this.mode === 'detail') {
                this.form.mode = 'Peserta'
            } else {
                this.loader = true
                this.$inertia.post(url, this.form.administration, {
                    onFinish: visit => {
                        this.loader = false
                    },
                    onSuccess: (page) => {
                        this.form.mode = 'Peserta'
                    }
                })
            }
        },
        onBackFromParticipantForm() {
            this.form.mode = 'Administrasi'
        },
        addParticipant() {
            if(this.form.administration.category === 'student') this.max_count = 2
            else this.max_count = 3
            if(this.form.participants.length < this.max_count) {
                let participant = reactive({
                    id: null,
                    name: null,
                    role: this.form.participants.length === 0 ? 'leader' : 'member',
                    identity: null,
                    preview: null,
                })
                this.form.participants.push(participant)
            }
        },
        removeParticipant(index) {
            if(this.form.participants[index].id !== null) {
                this.$inertia.delete(this.route('participant.destroy', this.form.participants[index].id), {
                    onSuccess: (page) => {
                        this.form.participants.splice(index, 1)
                    }
                })
            } else
                this.form.participants.splice(index, 1)
        },
        onChangeIdentityFile(e, index) {
            let file = e.target.files[0]
            this.form.participants[index].identity = file
            this.form.participants[index].preview = URL.createObjectURL(file)
        },
        onSubmit() {
            if(this.form.participants.length > 0) {
                this.loader = true
                for(let i = 0; i < this.form.participants.length; i++) {
                    if(this.form.participants[i].name && this.form.participants[i].identity) {
                        let url = this.form.participants[i].id === null ? this.route('participant.store') : this.route('participant.update', this.form.participants[i].id)
                        let formdata = new FormData()
                        formdata.append('name', this.form.participants[i].name)
                        formdata.append('role', this.form.participants[i].role)
                        formdata.append('identity', this.form.participants[i].identity)
                        formdata.append('administration_id', this.data[0].id)
                        if(this.form.participants[i].id !== null)
                            formdata.append('_method', 'PATCH')
                        axios.post(url, formdata).then((response) => {
                            this.loader = false
                            if((i + 1) === this.form.participants.length) {
                                window.location.href = '/dashboard'
                            }
                        })
                    } else {
                        if((i + 1) === this.form.participants.length) {
                            window.location.href = '/dashboard'
                        }
                    }
                }
            }
        }
    }
}
</script>
