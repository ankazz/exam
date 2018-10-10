<template>
<div>
    <div class="d-flex align-items-center p-3 my-3 text-white-50 bg-white rounded box-shadow">
            <a href="/users/create" class="btn btn-success pull-right">Add New Task</a>
    </div>
    <div class="my-3 p-3 bg-white rounded box-shadow">
        <h6 class="border-bottom border-gray pb-2 mb-0">Tasks Listing</h6>
    
        <table class="table table-striped">
            <thead>
                <th>ID</th>
                <th>Найменование</th>
                <th>Действие</th>
            </thead>
            <tbody>
                <tr v-for="(m, index) in users" :key=m.id>
                    <td>{{ m.id }}</td>
                    <td>{{ m.name }}</td>
                    <td><a :href="'/users/edit/'+m.id" class="btn btn-primary btn-sm">Edit</a> || <a href="javascript:;" class="btn btn-danger btn-sm" v-on:click="deleteUsers(m.id,index)">Delete</a></td>
                </tr>
            </tbody>
        </table>
 
        <div class="pagination">
            <button class="btn btn-default" v-on:click="fetchPaginateTasks(pagination.prev_page_url)" :disabled="!pagination.prev_page_url">
                Previos
            </button>
                <span>Page {{ pagination.current_page }} of {{ pagination.last_page }} </span>
            <button class="btn btn-default" v-on:click="fetchPaginateTasks(pagination.next_page_url)" :disabled="!pagination.next_page_url">
                Next
            </button>
        </div>
    </div>  
</div>  
</template>

<script>

export default {
    data(){
        return {
            users: [],
            url: '/api/users',
            pagination: []
        }
    },
    mounted(){
        this.getUsers()
    },
    methods: {
        getUsers(){
            let $this = this
            axios.get(this.url).then(response => {
                this.users = response.data.data
                $this.makePagination(response.data)
            })
        },
        deleteUsers(id,index){
            axios.delete(this.url+'/'+id).then(response => {
                console.log(response)

                this.users.splice(index, 1)
            }).catch(error => {
                console.log(error)
            })
        },
        makePagination(data) {
            let pagination = {
                current_page: data.current_page,
                last_page: data.last_page,
                next_page_url: data.next_page_url,
                prev_page_url: data.prev_page_url,
            }

            this.pagination = pagination
        },
        fetchPaginateTasks(url) {
            this.url = url
            this.getUsers()
        }
    }
}
</script>

<style>

</style>