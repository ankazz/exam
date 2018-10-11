<template>
<div>
    <div class="box box-primary">
        <div class="box-header with-border">
            <i class="ion ion-clipboard"></i>
            <h3 class="box-title">Рабочее место</h3>
            <div class="box-tools pull-right">
            <ul class="pagination pagination-sm inline">
                <li v-bind:class="[{disabled: !pagination.prev_page_url}]" class="page-item"><a class="page-link" href="#" @click="fetchStudent(pagination.prev_page_url)">«</a></li>
                <li class="page-item disabled"><a class="page-link text-dark" href="#">Page {{ pagination.current_page }} of {{ pagination.last_page }}</a></li>
                <li v-bind:class="[{disabled: !pagination.next_page_url}]" class="page-item"><a class="page-link" href="#" @click="fetchStudent(pagination.next_page_url)">»</a></li>
            </ul>
            </div>
        </div>
    
        <!-- /.box-header -->
        <div class="box-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Найменование</th>
                        <th>Должность</th>
                        <th>Место работы</th>
                        <th>Примечание</th>
                        <th>Код</th>
                        <th>Действие</th>
                    </tr>
                </thead>
                <tbody>
                  <tr v-for="student in students" v-bind:key="student.id">
                    <th>{{ student.name }}</th>
                    <th>{{ student.post_name }}</th>
                    <th>{{ student.job_name }}</th>
                    <th>{{ student.code }}</th>
                    <th>{{ student.description }}</th>
                    <th style="width: 60px">
                        <div class="tools">
                            <i class="fa fa-edit" @click="editStudent(student)"></i>
                            <i class="fa fa-trash-o" @click="deleteStudent(student.id)"></i>
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
                <form class="form-horizontal" @submit.prevent="addStudent">
                <div class="form-group margin-bottom-none">
                    <div class="col-sm-2">
                        <input class="form-control input-sm" name="name" placeholder="Введите название" v-model="tm.name">
                    </div>
                    <div class="col-sm-2">
                        <select v-model="tm.post_id" class="form-control input-sm">
                            <option disabled value="">Выберите один из вариантов</option>
                            <option v-for="post in posts" v-bind:key="post.id" v-bind:value="post.id">{{ post.name }}</option>
                        </select>
                    </div>
                    <div class="col-sm-2">
                        <select v-model="tm.job_id" class="form-control input-sm">
                            <option disabled value="">Выберите один из вариантов</option>
                            <option v-for="job in jobs" v-bind:key="job.id" v-bind:value="job.id">{{ job.name }}</option>
                        </select>
                    </div>
                    <div class="col-sm-2">
                        <input class="form-control input-sm" name="description" placeholder="Введите название" v-model="tm.description">
                    </div>
                    <div class="col-sm-2">
                        <input class="form-control input-sm" name="code" placeholder="Введите название" v-model="tm.code">
                    </div>
                    <template v-if="edit">
                    <div class="col-sm-1">
                        <button type="submit" class="btn btn-success pull-right btn-block btn-sm">Update</button>
                    </div>
                    <div class="col-sm-1">
                        <button type="button" @click="clearForm()" class="btn btn-danger pull-right btn-block btn-sm">Cancel</button>
                    </div>
                    </template>
                    <template v-else>
                    <div class="col-sm-2">
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
      students: [],
      posts: [],
      jobs: [],
      tm: {
        id: '',
        name: '',
        post_id: '',
        job_id: '',
        description: '',
        code: ''
      },
      ed_id: '',
      pagination: {},
      edit: false
    };
  },
  created() {
    this.fetchStudent();
    this.fetchPost();
    this.fetchJob();
  },
  methods: {
    fetchStudent(page_url) {
    let vm = this;
    page_url = page_url || '/api/student';
        axios.get(page_url).then(response => {
        console.log(response.data);
        this.students = response.data.data;
        vm.makePagination(response.data.meta, response.data.links);
        })
    },
    fetchPost() {
    let vm = this;
        axios.get('/api/post_total').then(response => {
        this.posts = response.data;
        })
    },
    fetchJob() {
    let vm = this;
        axios.get('/api/job_total').then(response => {
        this.jobs = response.data;
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
    deleteStudent(id) {
      if (confirm('Are You Sure?')) {
        fetch(`api/student/${id}`, {
          method: 'delete'
        })
          .then(res => res.json())
          .then(data => {
            toastr.success('Удалено');
            this.fetchStudent();
          })
          .catch(err => console.log(err));
      }
    },
    addStudent() {
      if (this.edit === false) {
        // Add
        axios.post('/api/student', {
            name: this.tm.name,
            post_id: this.tm.post_id,
            job_id: this.tm.job_id,
            code: this.tm.code,
            description: this.tm.description
        }).then(response => {
            this.clearForm();
            toastr.success('Добавлено');
            this.fetchStudent();
        }).catch(
            err => console.log(err)
            );

      } else {
        // Update
        axios.put('/api/student', {
            name: this.tm.name,
            post_id: this.tm.post_id,
            job_id: this.tm.job_id,
            code: this.tm.code,
            description: this.tm.description,
            id: this.tm.id
        }).then(response => {
            this.clearForm();
            toastr.success('Обнавлено');
            this.fetchStudent();
        }).catch(
            err => console.log(err)
            );
      }
    },
    editStudent(student) {
      this.edit = true;
      this.tm.name = student.name
      this.tm.post_id = student.post_id
      this.tm.job_id = student.job_id
      this.tm.code = student.code
      this.tm.description = student.description
      this.tm.id = student.id
    },
    clearForm() {
      this.edit = false;
      this.tm.name = '';
      this.tm.post_id = '';
      this.tm.job_id = '';
      this.tm.code = '';
      this.tm.description = '';
      this.tm.id = '';
    }
  }
};
</script>