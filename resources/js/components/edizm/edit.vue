<template>
    <div>
        <form role="form" action="/edizm" methods="post">
            <div class="box-body">
                <div class="form-group">
                    <label for="description">Name:</label>
                    <input class="form-control" id="name" placeholder="Enter Name" name="name" v-model="name">
                    <span v-if="errors.name" class="error">{{ errors.name[0] }}</span>
                </div>
                
            </div>
            <div class="box-footer">
                <button type="button" class="btn btn-success" v-on:click="UpdateEdIzm()">Update</button>
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
                errors: ''
            }
        },
        mounted() {
            axios.get('/api/edizm/'+this.id).then(response => {
                this.name = response.data.name
            }).catch(error => {
                console.log(error)
            })
        },
        methods: {
            UpdateEdIzm() {
                axios.put('/api/edizm/'+this.id, {
                    name: this.name
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
