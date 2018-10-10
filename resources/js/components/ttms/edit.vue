<template>
    <div>
        <form role="form" action="/ttms" methods="post">
            <div class="box-body">
                <div class="form-group">
                    <label for="description">Name:</label>
                    <input class="form-control" id="name" placeholder="Enter Name" name="name" v-model="name">
                    <span v-if="errors.name" class="error">{{ errors.name[0] }}</span>
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
                <button type="button" class="btn btn-success" v-on:click="UpdateTypeTMS()">Update</button>
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
                tms_id: '',
                edizm_id: '',
                errors: [],
                tms: [],
                edizm: []
            }
        },
        mounted() {
            axios.get('/api/ttms/'+this.id).then(response => {
                this.name = response.data.name,
                this.tms_id = response.data.tms_id,
                this.edizm_id = response.data.edizm_id
            }).catch(error => {
                console.log(error)
            }),
            axios.get('/api/tms_total').then(response => {
                this.tms = response.data
            }),
            axios.get('/api/edizm_total').then(response => {
                this.edizm = response.data
            })
        },
        methods: {
            UpdateTypeTMS() {
                axios.put('/api/ttms/'+this.id, {
                    name: this.name,
                    tms_id: this.tms_id,
                    edizm_id: this.edizm_id
                }).then(response => {
                    console.log(response)
                }).catch(error => {
                    console.log(error)
                })
            }
        }
}
</script>

<style>

</style>
