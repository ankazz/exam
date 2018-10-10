<template>
    <div>
        <form role="form" action="/users" methods="post">
            <div class="box-body">
                <div class="form-group">
                    <label for="description">Name:</label>
                    <input class="form-control" id="name" placeholder="Enter Name" name="name" v-model="name">
                    <span v-if="errors.name" class="error">{{ errors.name[0] }}</span>
                </div>
                <!-- select -->
                <div class="form-group">
                    <label>Роль</label>
                    <template v-for="role in roles">
                    <div class="checkbox">
                        <label>
                        <input type="checkbox" v-bind:id="role.id" v-bind:value="role.name" v-model="selected_f">@{{role.name}}
                        </label>
                    </div>
                    </template>
                </div>
                
            </div>
            <div class="box-footer">
                <button type="button" class="btn btn-success" v-on:click="UpdateUsers()">Update</button>
            </div>
        </form>
    </div>
</template>

<script>
export default {
    props: ['id'],
    data() {
            return {
                name: '',
                errors: '',
                roles: []
            }
        },
        created: function() {
            this.getRoles();
        },
        mounted() {
            axios.get('/api/users/'+this.id).then(response => {
                this.name = response.data.name
            }).catch(error => {
                console.log(error)
            })
        },
        methods: {
            UpdateUsers() {
                axios.put('/api/users/'+this.id, {
                    name: this.name
                }).then(response => {
                    console.log(response)
                }).catch(error => {
                    console.log(error)
                })
            },
            getRoles: function(page) {
                var urlKeeps = '/users/getRoles/'+this.id;
 
                axios.get(urlKeeps).then(response => {
                    this.roles = response.data
                    for (var i = 0; i < response.data.length; i++) {
                        if (response.data[i].model_id != null) {this.selected_f.push(response.data[i].name)}
                    }
                });
            },
            updateRole(role){     	
                var urlKeeps = '/admin/users/updateRole'
                axios.post(urlKeeps, {
                    _token: myToken.csrfToken,
                    task: role
                })
                .then(function (response) {
                    toastr.success('Сохранено');
                }).catch(error => {
                    this.errors = 'Заполните все поля';
                    toastr.error('Ошибка');
                });
            }
        },
        watch: {
            //эта функция запускается при любом изменении вопроса
            selected_f: function () {
                axios.post('/admin/users/updateRole', {
                    _token: myToken.csrfToken,
                    selected_f: this.selected_f,
                    id_user: id_user
                }).then(response => {
                        console.log('test');
                });
            }   
        }
}
</script>

<style>

</style>
