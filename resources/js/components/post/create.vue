<template>
    <div class="my-3 p-3 bg-white rounded box-shadow">
        <form role="form" action="/post" methods="post">
            <div class="box-body">
                <div class="form-group">
                    <label for="name">Name:</label>
                    <input class="form-control" id="name" placeholder="Enter Name" name="name" v-model="name">
                </div>      
                <div class="form-group">
                    <label for="name">Короткое название:</label>
                    <input class="form-control" id="sname" placeholder="Enter Name" name="sname" v-model="sname">
                </div>          
            </div>
            <div class="box-footer">
                <button type="button" class="btn btn-success" v-on:click="addNewJob()">Add</button>
            </div>
        </form> 
    </div>
</template>

<script>
    export default {
        data() {
            return {
                name: '',
                sname: '',
                errors: []
            }
        },
        methods: {
            addNewJob(){
                this.errors = []

                axios.post('/api/post', {
                    name: this.name,
                    sname: this.sname
                }).then(response => {
                    console.log(response)
                }).catch(error => {
                    if(error.response.status == 422) {
                        this.errors = error.response.data.errors
                    }
                })
            }
        }
    }
</script>