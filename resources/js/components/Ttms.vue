<template>
<div>
    <div class="box box-primary">
        <div class="box-header with-border">
            <i class="ion ion-clipboard"></i>
            <h3 class="box-title">To Do List</h3>
            <div class="box-tools pull-right">
            <ul class="pagination pagination-sm inline">
                <li v-bind:class="[{disabled: !pagination.prev_page_url}]" class="page-item"><a class="page-link" href="#" @click="fetchTtms(pagination.prev_page_url)">«</a></li>
                <li class="page-item disabled"><a class="page-link text-dark" href="#">Page {{ pagination.current_page }} of {{ pagination.last_page }}</a></li>
                <li v-bind:class="[{disabled: !pagination.next_page_url}]" class="page-item"><a class="page-link" href="#" @click="fetchTtms(pagination.next_page_url)">»</a></li>
            </ul>
            </div>
        </div>
    
        <!-- /.box-header -->
        <div class="box-body">
            <table class="table table-bordered">
                <tbody>
                  <tr v-for="ed in ttms" v-bind:key="ed.id">
                    <th style="width: 15px">{{ ed.id }}</th>
                    <th>{{ ed.name }}</th>
                    <th>{{ ed.tname }}</th>
                    <th>{{ ed.ename }}</th>
                    <th style="width: 60px">
                        <div class="tools">
                            <i class="fa fa-edit" @click="editTtms(ed)"></i>
                            <i class="fa fa-trash-o" @click="deleteTtms(ed.id)"></i>
                        </div>
                    </th>
                  </tr>
                </tbody>
              </table>
        </div>
        
    </div>
    <div class="box box-primary">
        <div class="box-header with-border">
            <i class="ion ion-clipboard"></i>
            <h3 class="box-title">To Do List</h3>
            <div class="box-tools pull-right"></div>
        </div>
    
        <!-- /.box-body -->
        <div class="box-footer clearfix no-border">
            <div class="post clearfix">
                <form class="form-horizontal" @submit.prevent="addTtms">
                <div class="form-group margin-bottom-none">
                    <div class="col-sm-3">
                        <input class="form-control input-sm" name="name" placeholder="Введите название" v-model="ttm.name">
                    </div>
                    <div class="col-sm-3">
                        <select v-model="ttm.tms_id" class="form-control input-sm">
                            <option disabled value="">Выберите один из вариантов</option>
                            <option v-for="tm in tms" v-bind:key="tm.id" v-bind:value="tm.id">{{ tm.name }}</option>
                        </select>
                    </div>
                    <div class="col-sm-3">
                        <select v-model="ttm.edizm_id" class="form-control input-sm">
                            <option disabled value="">Выберите один из вариантов</option>
                            <option v-for="tm in edizm" v-bind:key="tm.id" v-bind:value="tm.id">{{ tm.name }}</option>
                        </select>
                    </div>
                    <template v-if="edit">
                    <div class="col-sm-2">
                        <button type="submit" class="btn btn-success pull-right btn-block btn-sm">Update</button>
                    </div>
                    <div class="col-sm-1">
                        <button type="button" @click="clearForm()" class="btn btn-danger pull-right btn-block btn-sm">Cancel</button>
                    </div>
                    </template>
                    <template v-else>
                    <div class="col-sm-3">
                        <button type="submit" class="btn btn-success pull-right btn-block btn-sm">Create</button>
                    </div>
                    </template>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>    
</template>

<script>
export default {
  data() {
    return {
        tms: [],
        edizm: [],
        ttms: [],
        ttm: {
            id: '',
            name: '',
            tms_id: '',
            edizm_id: '',
        },
        ed_id: '',
        pagination: {},
        selected: '',
        edit: false
    };
  },
  created() {
    this.fetchTtms();
    this.fetchTms();
    this.fetchEdizm();
  },
  methods: {
    fetchTtms(page_url) {
    let vm = this;
    page_url = page_url || '/api/ttms';
        axios.get(page_url).then(response => {
        console.log(response.data);
        this.ttms = response.data.data;
        vm.makePagination(response.data.meta, response.data.links);
        })
    },
    fetchTms() {
    let vm = this;
        axios.get('/api/tms').then(response => {
        this.tms = response.data.data;
        })
    },
    fetchEdizm() {
    let vm = this;
        axios.get('/api/edizm').then(response => {
        this.edizm = response.data.data;
        })
    },
    makePagination(meta, links) {
      let pagination = {
        current_page: meta.current_page,
        last_page: meta.last_page,
        next_page_url: links.next,
        prev_page_url: links.prev
      };
      this.pagination = pagination;
    },
    deleteTtms(id) {
      if (confirm('Are You Sure?')) {
        fetch(`api/ttms/${id}`, {
          method: 'delete'
        })
          .then(res => res.json())
          .then(data => {
            toastr.success('Удалено');
            this.fetchTtms();
          })
          .catch(err => console.log(err));
      }
    },
    addTtms() {
      if (this.edit === false) {
        // Add
        axios.post('/api/ttms', {
            name: this.ttm.name,
            tms_id: this.ttm.tms_id,
            edizm_id: this.ttm.edizm_id
        }).then(response => {
            this.clearForm();
            toastr.success('Добавлено');
            this.fetchTtms();
        }).catch(
            err => console.log(err)
            );

      } else {
        // Update
        axios.put('/api/ttms', {
            name: this.ttm.name,
            tms_id: this.ttm.tms_id,
            edizm_id: this.ttm.edizm_id,
            id: this.ttm.id
        }).then(response => {
            this.clearForm();
            toastr.success('Обнавлено');
            this.fetchTtms();
        }).catch(
            err => console.log(err)
            );
      }
    },
    editTtms(ed) {
      this.edit = true;
      this.ttm.name = ed.name,
      this.ttm.tms_id = ed.tms_id,
      this.ttm.edizm_id = ed.edizm_id,
      this.ttm.id = ed.id
    },
    clearForm() {
      this.edit = false;
      this.ttm.name = '';
      this.ttm.tms_id = '';
      this.ttm.edizm_id = '';
      this.ttm.id = '';
    }
  }
};
</script>