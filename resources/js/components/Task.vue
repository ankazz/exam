<template>
<div>
    <div class="box box-primary">
        <div class="box-header with-border">
            <i class="ion ion-clipboard"></i>
            <h3 class="box-title">To Do List</h3>
            <div class="box-tools pull-right">
            <ul class="pagination pagination-sm inline">
                <li v-bind:class="[{disabled: !pagination.prev_page_url}]" class="page-item"><a class="page-link" href="#" @click="fetchTask(pagination.prev_page_url)">«</a></li>
                <li class="page-item disabled"><a class="page-link text-dark" href="#">Page {{ pagination.current_page }} of {{ pagination.last_page }}</a></li>
                <li v-bind:class="[{disabled: !pagination.next_page_url}]" class="page-item"><a class="page-link" href="#" @click="fetchTask(pagination.next_page_url)">»</a></li>
            </ul>
            </div>
        </div>
    
        <!-- /.box-header -->
        <div class="box-body">
            <table class="table table-bordered">
                <tbody>
                  <tr v-for="ed in tasks" v-bind:key="ed.id">
                    <th style="width: 15px">{{ ed.id }}</th>
                    <th>{{ ed.name }}</th>
                    <th>{{ ed.sname }}</th>
                    <th style="width: 60px">
                        <div class="tools">
                            <i class="fa fa-edit" @click="editTask(ed)"></i>
                            <i class="fa fa-trash-o" @click="deleteTask(ed.id)"></i>
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
                <form class="form-horizontal" @submit.prevent="addTask">
                <div class="form-group margin-bottom-none">
                    <div class="col-sm-4">
                        <input class="form-control input-sm" name="name" placeholder="Введите название" v-model="task.name">
                    </div>
                        <div class="col-sm-4">
                    <input class="form-control input-sm" placeholder="Введите короткое название" v-model="task.sname">
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
      tasks: [],
      task: {
        id: '',
        name: '',
        sname: ''
      },
      ed_id: '',
      pagination: {},
      edit: false
    };
  },
  created() {
    this.fetchTask();
  },
  methods: {
    fetchTask(page_url) {
    let vm = this;
    page_url = page_url || '/api/task';
        axios.get(page_url).then(response => {
        console.log(response.data);
        this.tasks = response.data.data;
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
    deleteTask(id) {
      if (confirm('Are You Sure?')) {
        fetch(`api/tasks/${id}`, {
          method: 'delete'
        })
          .then(res => res.json())
          .then(data => {
            toastr.success('Удалено');
            this.fetchTask();
          })
          .catch(err => console.log(err));
      }
    },
    addTask() {
      if (this.edit === false) {
        // Add
        axios.post('/api/task', {
            name: this.task.name,
            sname: this.task.sname
        }).then(response => {
            this.clearForm();
            toastr.success('Добавлено');
            this.fetchTask();
        }).catch(
            err => console.log(err)
            );

      } else {
        // Update
        axios.put('/api/task', {
            name: this.task.name,
            sname: this.task.sname,
            id: this.task.id
        }).then(response => {
            this.clearForm();
            toastr.success('Обнавлено');
            this.fetchTask();
        }).catch(
            err => console.log(err)
            );
      }
    },
    editTask(ed) {
      this.edit = true;
      this.task.name = ed.name,
      this.task.sname = ed.sname
      this.task.id = ed.id
    },
    clearForm() {
      this.edit = false;
      this.task.name = '';
      this.task.sname = '';
      this.task.id = '';
    }
  }
};
</script>