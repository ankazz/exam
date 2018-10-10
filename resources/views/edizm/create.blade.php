<form role="form"  v-on:submit.prevent="addNewEdIzm" methods="post">
    <div class="modal fade" id="create">
      <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">
                <span>&times;</span>
              </button>
              <h4>Crear</h4>
            </div>
            <div class="modal-body">
                <label for="name">Name:</label>
                <input class="form-control" id="name" placeholder="Enter Name" name="name" v-model="name">
                <span v-for="error in errors" class="text-danger">@{{ error }}</span>
            </div>              
            <div class="modal-footer">
              <input type="submit" class="btn btn-primary" value="Guardar">
            </div>
        </div>
    </div>
</form> 