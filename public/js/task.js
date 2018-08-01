/**
 * Event section
 */

 $(document).on('click','.sort-up', function(){
    let parent = $(this).parent().parent().parent();
    let id = parent.data('id');
    let up = parent.prev('.project-row');
    if(up.length !== 0){
        let up_id = up.data('id');
        let parent_order = parent.attr("data-order");
        let up_order = up.attr("data-order");
        console.log(parent,parent_order,up_order);
        parent.attr("data-order", up_order);
        up.attr("data-order",parent_order);
        up.before(parent);
        taskSort(id,up_order,up_id,parent_order);
    }
 });

 $(document).on('change','.project-row__checkbox input', function(){
     let parent = $(this).closest('.project-row');
     let id = parent.attr('data-id');
    if($(this).is(':checked')){
        editTask(id,false,1);
    }
    else{
        editTask(id,false,0);
    }
 });

 $(document).on('click','.sort-down', function(){
    let parent = $(this).parent().parent().parent();
    let id = parent.data('id');
    let down = parent.next('.project-row');
    if(down.length !== 0){
        let down_id = down.data('id');
        let parent_order = parent.attr("data-order");
        let down_order = down.attr("data-order");
        console.log(parent,parent_order,down_order);
        parent.attr("data-order", down_order);
        down.attr("data-order",parent_order);
        parent.before(down);
        taskSort(id,down_order,down_id,parent_order);
    }
});

$(document).on('click','.task-delete', function(){
    let parent = $(this).parent().parent();
    let id = parent.data('id');
    taskDelete(id);
});

$(document).on('click','.task-success', function(e){
    e.preventDefault();
    let input = $(this).parent().siblings('.project-input__input').find('input');
    let project = $(this).closest('.project-container');
    let project_id = project.attr('id').replace('project-',"");
    if(input.length !== 0){
        let value = input.val();
        let verif_value = checkEmpty(value);
        if(!verif_value){
            $('.header-errors__message').html('Неверное название задачи');
            onMessage($('.header-errors__message'));
        }
        else{
            taskAdd(verif_value,project_id);
        }
    } 
});

$(document).on('click','.task-edit', function(){
    let name = $(this).parent().siblings('.project-row__name');
    console.log(name);
    editableTask(name);
});

/**
 * Methods section
 */

 const taskSort = (first_id,first_order,second_id,second_order) => {
    let data = new FormData();
    data.append('first_id', first_id);
    data.append('first_order', first_order);
    data.append('second_id', second_id);
    data.append('second_order', second_order);
    $.ajax({
        type: "POST",
        url: "/task/taskorder",
        cache: false,
        contentType: false,
        processData: false,
        data: data,
        success: function (data) {
            console.log(data);
            json = JSON.parse(data);
            if(json.errors !== undefined){
                $('.header-errors__message').html(json.errors);
                onMessage($('.header-errors__message'));
            }
        },
        error: function(xhr,textStatus,err){
            console.log("readyState: " + xhr.readyState);
            console.log("responseText: "+ xhr.responseText);
            console.log("status: " + xhr.status);
            console.log("text status: " + textStatus);
            console.log("error: " + err);
        }
    });
 }

 const taskDelete = id => {
    let data = new FormData();
    data.append('task_id',id);
    $.ajax({
        type: "POST",
        url: "/task/taskdelete",
        cache: false,
        contentType: false,
        processData: false,
        data: data,
        success: function (data) {
            console.log(data);
            json = JSON.parse(data);
            if(json.errors !== undefined){
                $('.header-errors__message').html(json.errors);
                onMessage($('.header-errors__message'));
            }
            else{
                $('.project-row[data-id='+json.id+']').remove();
            }
        },
        error: function(xhr,textStatus,err){
            console.log("readyState: " + xhr.readyState);
            console.log("responseText: "+ xhr.responseText);
            console.log("status: " + xhr.status);
            console.log("text status: " + textStatus);
            console.log("error: " + err);
        }
    });
 }

 const taskAdd = (value,project_id) => {
    let data = new FormData();
    data.append('task_name',value);
    data.append('project_id',project_id);
    $.ajax({
        type: "POST",
        url: "/task/taskadd",
        cache: false,
        contentType: false,
        processData: false,
        data: data,
        success: function (data) {
            json = JSON.parse(data);
            console.log(json);
            if(json.errors !== undefined){
                $('.header-errors__message').html(json.errors);
                onMessage($('.header-errors__message'));
            }
            else{
                let template = taskTemplate(json);
                let project = $('#project-'+json.project_id);
                project.append(template).find('.project-input__input input').val('');
            }
        },
        error: function(xhr,textStatus,err){
            console.log("readyState: " + xhr.readyState);
            console.log("responseText: "+ xhr.responseText);
            console.log("status: " + xhr.status);
            console.log("text status: " + textStatus);
            console.log("error: " + err);
        }
    });
 }

 const taskTemplate = data => {
     let template = `
            <div class="row project-row" data-id="${data.id}" data-order="${data.order}">
                <div class="col-md-1 p-2 text-center project-row__checkbox">
                    <input type="checkbox">
                </div>
                <div class="col-md-9 p-2 project-row__name border-right">
                ${data.name}
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
     `;
     return template;
 }

 const editableTask = (el) => {
    let task = el.parent();
    let id = task.attr('data-id');
    let input = el.find('input');
    if(input.length !== 0){
        let value = input.val();
        let verif_value = checkEmpty(value);
        if(verif_value){
            editTask(id,verif_value);
        }
        else{
            $('.header-errors__message').html('Название задачи не может быть короче 2-х символов');
            onMessage($('.header-errors__message'));
        }
    }
    else{
        let value = el.html();
        el.empty();
        el.append('<input type="text" value="'+ value.trim() +'">');
    }
}

const editTask = (id, value = false , status = false) => {
    data = new FormData();
    data.append('task_id',id);
    if(value){
        data.append('task_name',value)
    }
    if(status !== false){
        data.append('task_status',status);
    }
   
    $.ajax({
        type: "POST",
        url: "/task/edittask",
        cache: false,
        contentType: false,
        processData: false,
        data: data,
        success: function (data) {
            console.log(data);
            json = JSON.parse(data);
            if(json.name !== null){
                $('.project-row[data-id='+json.id+'] .project-row__name').html(json.name);
            }
            else if(json.errors === undefined){
                $('.header-errors__message').html(json.errors);
                onMessage($('.header-errors__message'));
            }
        },
        error: function(xhr,textStatus,err){
            console.log("readyState: " + xhr.readyState);
            console.log("responseText: "+ xhr.responseText);
            console.log("status: " + xhr.status);
            console.log("text status: " + textStatus);
            console.log("error: " + err);
        }
    });
}