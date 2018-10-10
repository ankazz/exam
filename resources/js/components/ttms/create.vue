<template>
    <div class="my-3 p-3 bg-white rounded box-shadow">
        <form role="form" action="/ttms" methods="post">
            <div class="box-body">
                <div class="form-group">
                    <label for="name">Name:</label>
                    <input class="form-control" id="name" placeholder="Enter Name" name="name" v-model="name">
                </div>  
                <div class="form-group">
                  <label>ТМЦ</label>
                  <select class="form-control" v-model="tms_id">
                    <option v-for="m in tms" v-bind:value="m.id" :key="m.id">
                        {{ m.name }}
                    </option>    
                  </select>
                </div>     
                <div class="form-group">
                  <label>Ед. измерения</label>
                  <select class="form-control" v-model="edizm_id">
                    <option v-for="m in edizm" v-bind:value="m.id" :key="m.id">
                        {{ m.name }}
                    </option>    
                  </select>
                </div>        
            </div>
            <div class="box-footer">
                <button type="button" class="btn btn-success" v-on:click="addNewtypeTMS()">Add</button>
            </div>
        </form> 
    </div>
</template>

<script>
    export default {
        data() {
            return {
                name: '',
                tms_id: '',
                edizm_id: '',
                errors: [],
                tms: [],
                edizm: []
            }
        },
        mounted(){
            this.getTMS()
        },
        methods: {
            getTMS (){
                axios.get('/api/tms_total').then(response => {
                    this.tms = response.data
                }),
                axios.get('/api/edizm_total').then(response => {
                    this.edizm = response.data
                })
            },
            addNewtypeTMS(){
                this.errors = []

                axios.post('/api/ttms', {
                    name: this.name,
                    tms_id: this.tms_id,
                    edizm_id: this.edizm_id
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