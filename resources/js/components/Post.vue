<template>
<div>
    <div class="box box-primary">
        <div class="box-header with-border">
            <i class="ion ion-clipboard"></i>
            <h3 class="box-title">Рабочее место</h3>
            <div class="box-tools pull-right">
            <ul class="pagination pagination-sm inline">
                <li v-bind:class="[{disabled: !pagination.prev_page_url}]" class="page-item"><a class="page-link" href="#" @click="fetchPost(pagination.prev_page_url)">«</a></li>
                <li class="page-item disabled"><a class="page-link text-dark" href="#">Page {{ pagination.current_page }} of {{ pagination.last_page }}</a></li>
                <li v-bind:class="[{disabled: !pagination.next_page_url}]" class="page-item"><a class="page-link" href="#" @click="fetchPost(pagination.next_page_url)">»</a></li>
            </ul>
            </div>
        </div>
    
        <!-- /.box-header -->
        <div class="box-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Найменование</th>
                        <th>Действие</th>
                    </tr>
                </thead>
                <tbody>
                  <tr v-for="ed in post" v-bind:key="ed.id">
                    <th>{{ ed.name }}</th>
                    <th style="width: 60px">
                        <div class="tools">
                            <i class="fa fa-edit" @click="editPost(ed)"></i>
                            <i class="fa fa-trash-o" @click="deletePost(ed.id)"></i>
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
                <form class="form-horizontal" @submit.prevent="addPost">
                <div class="form-group margin-bottom-none">
                    <div class="col-sm-8">
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
      post: [],
      tm: {
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
    this.fetchPost();
  },
  methods: {
    fetchPost(page_url) {
    let vm = this;
    page_url = page_url || '/api/post';
        axios.get(page_url).then(response => {
        console.log(response.data);
        this.post = response.data.data;
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
    deletePost(id) {
      if (confirm('Are You Sure?')) {
        fetch(`api/post/${id}`, {
          method: 'delete'
        })
          .then(res => res.json())
          .then(data => {
            toastr.success('Удалено');
            this.fetchPost();
          })
          .catch(err => console.log(err));
      }
    },
    addPost() {
      if (this.edit === false) {
        // Add
        axios.post('/api/post', {
            name: this.tm.name
        }).then(response => {
            this.clearForm();
            toastr.success('Добавлено');
            this.fetchPost();
        }).catch(
            err => console.log(err)
            );

      } else {
        // Update
        axios.put('/api/post', {
            name: this.tm.name,
            id: this.tm.id
        }).then(response => {
            this.clearForm();
            toastr.success('Обнавлено');
            this.fetchPost();
        }).catch(
            err => console.log(err)
            );
      }
    },
    editPost(ed) {
      this.edit = true;
      this.tm.name = ed.name
      this.tm.id = ed.id
    },
    clearForm() {
      this.edit = false;
      this.tm.name = '';
      this.tm.id = '';
    }
  }
};
</script>