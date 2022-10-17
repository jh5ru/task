<template>
    <div class="container">
        <nav class="navbar navbar-dark bg-dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">
                    Страница записи к нотариусу
                </a>
            </div>
        </nav>
        <div class="row mt-2">
            <div>
                <div>Пользователь: {{ user }}</div>
                <div v-if="user">
                    <button class="btn btn-danger" v-on:click="resetUsersRecords">Удалить записи всех пользователей
                    </button>
                </div>
            </div>
            <div class="card mt-3">
                <div class="card-body">
                    <form class="mt-3" v-on:submit.prevent="setUserRecord">
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Имя</label>
                            <input required type="text" v-model="form.firstname" class="form-control"
                                   id="exampleInputEmail1"
                                   aria-describedby="firstnameHelp">
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Фамилия</label>
                            <input required type="text" v-model="form.lastname" class="form-control"
                                   id="exampleInputEmail1"
                                   aria-describedby="lastnameHelp">
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Email</label>
                            <input required type="email" v-model="form.email" class="form-control"
                                   id="exampleInputEmail1"
                                   aria-describedby="emailHelp">
                        </div>


                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Услуга</label>
                            <select required v-model="form.service" class="form-select"
                                    aria-label="Default select example">
                                <option value="Доверенность">Доверенность</option>
                                <option value="Наследство">Наследство</option>
                                <option value="Справка">Справка</option>
                            </select>
                        </div>


                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Дата записи</label>
                            <Datepicker v-model="form.recording_at" autoApply :format="format"></Datepicker>
                        </div>

                        <button type="submit" class="btn btn-primary">Отправить заявку</button>
                    </form>
                </div>
            </div>
            <div class="card mt-3" v-if="user_records.length">
                <div class="card-body">
                    <table class="table table-dark table-hover">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Дата записи</th>
                            <th scope="col">Имя</th>
                            <th scope="col">Фамилия</th>
                            <th scope="col">Email</th>
                            <th scope="col">Услуга</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="record in user_records">
                            <th scope="row">{{ record.id }}</th>
                            <td>{{ record.recording_at }}</td>
                            <td>{{ record.firstname }}</td>
                            <td>{{ record.lastname }}</td>
                            <td>{{ record.email }}</td>
                            <td>{{ record.service }}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {v4 as uuidv4} from 'uuid';
import {ref} from 'vue';
import Datepicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css'

export default {
    name: 'App',
    components: {Datepicker},
    setup() {
        const date = ref(new Date());
        const format = (date) => {
            const day = date.getDate();
            const month = date.getMonth() + 1;
            const year = date.getFullYear();
            return `${day}.${month}.${year}`;
        }
        return {
            date,
            format,
        }
    },
    data() {
        return {
            user: false,
            user_records: [],
            form: {
                service: 'Доверенность',
                firstname: '',
                lastname: '',
                email: '',
                recording_at: '',
            },
        }
    },
    created() {
        this.setUser()
        this.getUserRecords()
    },
    methods: {
        setUser() {
            let app = this;
            let user_id = uuidv4();
            let user = app.$cookies.get('user')
            if (user) {
                app.user = user
            } else {
                app.$axios.post('/api/main', {
                    'user_id': user_id
                }).then(function () {
                    app.user = user_id
                    app.$cookies.set('user', user_id)
                }).catch(function (error) {
                    console.log(error)
                    app.$cookies.remove('user')
                })
            }
        },
        setUserRecord(e) {
            let app = this;
            app.form.user_id = app.$cookies.get('user')
            console.log(this.form)
            app.$axios.post('/api/save_records', app.form).then(function (data) {
                app.user_records.push(data.data)
            }).catch(function (error) {
                console.log(error)
            })
        },
        getUserRecords() {
            let app = this;
            app.$axios.get('/api/get_records/?user_id=' + app.$cookies.get('user')).then(function (data) {
                app.user_records = data.data
            }).catch(function (error) {
                console.log(error)
            })
        },
        resetUsersRecords() {
            let app = this;
            app.$axios.delete('/api/reset_records').then(function () {
                app.user_records = []
                app.$cookies.remove('user')
                app.user = false
            }).catch(function (error) {
                console.log(error)
            })
            location.reload()
        }
    }
}
</script>
