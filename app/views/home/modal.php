<div class="modal fade" id="add-project__modal" tabindex="-1" role="dialog" aria-labelledby="add-project__modal" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <div class="modal-error"></div>
        <form id="add-project__form" method="post">
            <input type="text" placeholder="Type project name..." name="project-name">
            <p class="add-project__error"></p>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" id="add-project__success" class="btn btn-primary">Add</button>
      </div>
    </div>
  </div>
</div>