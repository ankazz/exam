<template>
    <div>
        <form role="form" action="/service" methods="post">
            <div class="box-body">
                <div class="form-group">
                    <label for="description">Name:</label>
                    <input class="form-control" id="name" placeholder="Enter Name" name="name" v-model="name">
                    <span v-if="errors.name" class="error">{{ errors.name[0] }}</span>
                </div>
                <div class="form-group">
                    <label for="description">Короткое название:</label>
                    <input class="form-control" id="sname" placeholder="Enter Name" name="sname" v-model="sname">
                    <span v-if="errors.sname" class="error">{{ errors.sname[0] }}</span>
                </div>
                
            </div>
            <div class="box-footer">
                <button type="button" class="btn btn-success" v-on:click="UpdateService()">Update</button>
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
                sname: '',
                errors: ''
            }
        },
        mounted() {
            axios.get('/api/service/'+this.id).then(response => {
                this.name = response.data.name,
                this.sname = response.data.sname
            }).catch(error => {
                console.log(error)
            })
        },
        methods: {
            UpdateService() {
                axios.put('/api/service/'+this.id, {
                    name: this.name,
                    sname: this.sname
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
