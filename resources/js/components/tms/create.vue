<template>
    <div class="my-3 p-3 bg-white rounded box-shadow">
        <form role="form" action="/tms" methods="post">
            <div class="box-body">
                <div class="form-group">
                    <label for="name">Name:</label>
                    <input class="form-control" id="name" placeholder="Enter Name" name="name" v-model="name">
                </div>              
            </div>
            <div class="box-footer">
                <button type="button" class="btn btn-success" v-on:click="addNewTMS()">Add</button>
            </div>
        </form> 
    </div>
</template>

<script>
    export default {
        data() {
            return {
                name: '',
                errors: []
            }
        },
        methods: {
            addNewTMS(){
                this.errors = []

                axios.post('/api/tms', {
                    name: this.name
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