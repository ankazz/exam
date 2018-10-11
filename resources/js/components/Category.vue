<template>
<div>
    <div class="box box-primary">
        <div class="box-header with-border">
            <i class="ion ion-clipboard"></i>
            <h3 class="box-title">Рабочее место</h3>
            <div class="box-tools pull-right">
            <ul class="pagination pagination-sm inline">
                <li v-bind:class="[{disabled: !pagination.prev_page_url}]" class="page-item"><a class="page-link" href="#" @click="fetchCategory(pagination.prev_page_url)">«</a></li>
                <li class="page-item disabled"><a class="page-link text-dark" href="#">Page {{ pagination.current_page }} of {{ pagination.last_page }}</a></li>
                <li v-bind:class="[{disabled: !pagination.next_page_url}]" class="page-item"><a class="page-link" href="#" @click="fetchCategory(pagination.next_page_url)">»</a></li>
            </ul>
            </div>
        </div>
    
        <!-- /.box-header -->
        <div class="box-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Код</th>
                        <th>Найменование</th>
                        <th>Действие</th>
                    </tr>
                </thead>
                <tbody>
                  <tr v-for="ed in category" v-bind:key="ed.id">
                    <th>{{ ed.code }}</th>
                    <th>{{ ed.name }}</th>
                    <th style="width: 60px">
                        <div class="tools">
                            <i class="fa fa-edit" @click="editCategory(ed)"></i>
                            <i class="fa fa-trash-o" @click="deleteCategory(ed.id)"></i>
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
                <form class="form-horizontal" @submit.prevent="addCategory">
                <div class="form-group margin-bottom-none">
                    <div class="col-sm-1">
                        <input class="form-control input-sm" name="code" placeholder="Введите название" v-model="tm.code">
                    </div>
                    <div class="col-sm-7">
                        <input class="form-control input-sm" name="name" placeholder="Введите название" v-model="tm.name">
                    </div>
                    <template v-if="edit">
                    <div class="col-sm-2">
                        <button type="submit" class="btn btn-success pull-right btn-block btn-sm">Update</button>
                    </div>
                    <div class="col-sm-2">
                        <button type="button" @click="clearForm()" class="btn btn-danger pull-right btn-block btn-sm">Cancel</button>
                    </div>
                    </template>
                    <template v-else>
                    <div class="col-sm-4">
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
      category: [],
      tm: {
        id: '',
        name: '',
        code: ''
      },
      ed_id: '',
      pagination: {},
      edit: false
    };
  },
  created() {
    this.fetchCategory();
  },
  methods: {
    fetchCategory(page_url) {
    let vm = this;
    page_url = page_url || '/api/category';
        axios.get(page_url).then(response => {
        console.log(response.data);
        this.category = response.data.data;
        vm.makePagination(response.data.meta, response.data.links);
        
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
    deleteCategory(id) {
      if (confirm('Are You Sure?')) {
        fetch(`api/category/${id}`, {
          method: 'delete'
        })
          .then(res => res.json())
          .then(data => {
            toastr.success('Удалено');
            this.fetchCategory();
          })
          .catch(err => console.log(err));
      }
    },
    addCategory() {
      if (this.edit === false) {
        // Add
        axios.post('/api/category', {
            name: this.tm.name,
            code: this.tm.code
        }).then(response => {
            this.clearForm();
            toastr.success('Добавлено');
            this.fetchCategory();
        }).catch(
            err => console.log(err)
            );

      } else {
        // Update
        axios.put('/api/category', {
            name: this.tm.name,
            code: this.tm.code,
            id: this.tm.id
        }).then(response => {
            this.clearForm();
            toastr.success('Обнавлено');
            this.fetchCategory();
        }).catch(
            err => console.log(err)
            );
      }
    },
    editCategory(ed) {
      this.edit = true;
      this.tm.name = ed.name
      this.tm.code = ed.code
      this.tm.id = ed.id
    },
    clearForm() {
      this.edit = false;
      this.tm.name = '';
      this.tm.code = '';
      this.tm.id = '';
    }
  }
};
</script>