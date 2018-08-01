<?php $this->view('containers/header'); ?>


<main>
        <?php foreach($data['projects'] as $value){ ?>
        <div class="container project-container mb-4" id="project-<?= $value['id']; ?>">
            <div class="row border border-primary project-header">
                <div class="col-md-1 p-2 text-right project-header__icon">
                    <i class="far fa-calendar-alt fa-2x"></i>
                </div>
                <div class="col-md-9 d-flex align-items-center p-2 project-header__title"><?= $value['name']; ?></div>
                <div class="col-md-2 p-2 project-header__edit">
                    <i class="fas fa-pencil-alt border-right pr-2 edit-project"></i>
                    <i class="far fa-trash-alt pl-2 pr-3 delete-project"></i>
                </div>
            </div>
            <div class="row project-input">
                <div class="col-md-1 project-input__icon p-2 text-right">
                    <i class="fas fa-plus fa-2x"></i>
                </div>
                <div class="col-md-9 py-2 pr-0 pl-2 project-input__input">
                    <input type="text" placeholder="Start typing here to create a task">
                </div>
                <div class="col-md-2 py-2 pl-0">
                    <a href="#" class="project-button__add task-success">Add Task</a>
                </div>
            </div>
            <?php if(!empty($value['task'])){ 
                foreach($value['task'] as $task){
                ?>
                    <div class="row project-row" data-id="<?= $task['id']; ?>" data-order="<?= $task['order']; ?>">
                        <div class="col-md-1 p-2 text-center project-row__checkbox">
                            <input type="checkbox" <?php echo $task['status'] == 1 ? 'checked' : 'test' ?>>
                        </div>
                        <div class="col-md-9 p-2 project-row__name border-right">
                            <?= $task['name']; ?>
                        </div>
                        <div class="col-md-2 p-2 project-row__edit">
                            <div class="d-flex flex-column  border-right pr-2 sort-container">
                                <i class="fas fa-sort-up sort-up"></i>
                                <i class="fas fa-sort-down sort-down"></i>
                            </div>
                            <i class="fas fa-pencil-alt border-right pl-2 pr-2 task-edit"></i>
                            <i class="far fa-trash-alt pl-2 pr-3 task-delete"></i>
                        </div>
                    </div>
                <?php } } ?>        

        </div>
        <?php } ?>
</main>

<?php $this->view('home/modal'); ?>

<div class="footer-button">
    <a href="#" data-toggle="modal" data-target="#add-project__modal"><i class="fas fa-plus fa-2x mr-2"></i> Add TODO List </a>
</div>

<?php $this->view('containers/footer'); ?>