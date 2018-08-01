/**
 * Events section
 */
$(document).on('click', '.edit-project', function(){
    let name = $(this).parent().siblings('.project-header__title');
    editableProject(name);
});

$(document).on('click','.delete-project', function(){
    let project = $(this).closest('.project-container');
    let id = project.attr('id');
    deleteProject(id);
});

$('#add-project__success').on('click', function(){
    let data = new FormData();
    let name = $('#add-project__form input[name="project-name"]').val();
    let verif_name = checkEmpty(name);
    if(!verif_name){
        $('.modal-error').html('Неверное название проекта');
        onMessage($('.modal-error'));
    }
    else{
        data.append('project-name',name);
        $.ajax({
            type: "POST",
            url: "/project/createproject",
            cache: false,
            contentType: false,
            processData: false,
            data: data,
            success: function (data) {
                let json = JSON.parse(data);
                if(json.errors === undefined){
                    let input = $('#add-project__form input[name="project-name"]');
                    let name = input.val();
                    input.val('');
                    $('#add-project__modal').modal('hide');
                    $('.header-success__message').html('Проект ' + name + ' успешно добавлен');
                    onMessage($('.header-success__message'));
                    let data = {
                        id: json.id,
                        name: json.name
                    };
                    let template = addProject(data);
                    console.log(template);
                    $('main').append(template);
                }
                else{
                    $('.modal-error').html(json.errors);
                    onMessage($('.modal-error'));
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
});

/**
 * Methods section
 */

const editProject = (id,name) => {
    id = Number(id.replace('project-',""));
    data = new FormData();
    data.append('project_id',id);
    data.append('project_name',name);
    $.ajax({
        type: "POST",
        url: "/project/editproject",
        cache: false,
        contentType: false,
        processData: false,
        data: data,
        success: function (data) {
            json = JSON.parse(data);
            if(json.errors === undefined){
                let project = $('#project-' + json.id);
                let name = project.find('.project-header__title').html(json.name);
            }
            else{
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

const editableProject = (el) => {
    let project = el.parent().parent();
    let id = project.attr('id');
    let input = el.find('input');
    if(input.length !== 0){
        let value = input.val();
        let verif_value = checkEmpty(value);
        if(verif_value){
            editProject(id,verif_value);
        }
        else{
            $('.header-errors__message').html('Название проекта не может быть короче 2-х символов');
            onMessage($('.header-errors__message'));
        }
        
    }
    else{
        let value = el.html();
        el.empty();
        el.append('<input type="text" value="'+ value.trim() +'">');
    }
}

const deleteProject = id => {
    id = Number(id.replace('project-',""));
    data = new FormData();
    data.append('project_id',id);
    $.ajax({
        type: "POST",
        url: '/project/deleteproject',
        cache: false,
        contentType: false,
        processData: false,
        data: data,
        success: function(data){
            console.log(data);
            json = JSON.parse(data);
            if(json.errors === undefined){
                let project = $('#project-' + json.id);
                project.remove();
                $('.header-success__message').html('Проект успешно удален');
                onMessage($('.header-success__message'));
            }
            else{
                $('.header-errors__message').html(json.errors);
                onMessage($('.header-errors__message'));
            }
        },
        error: function(xhr, textStatus, err){
            console.log("readyState: " + xhr.readyState);
            console.log("responseText: "+ xhr.responseText);
            console.log("status: " + xhr.status);
            console.log("text status: " + textStatus);
            console.log("error: " + err);
        }
    })
}

const addProject = data => {
    let template = `
    <div class="container project-container mb-4" id="project-${data.id}">
            <div class="row border border-primary project-header">
                <div class="col-md-1 p-2 text-right project-header__icon">
                    <i class="far fa-calendar-alt fa-2x"></i>
                </div>
                <div class="col-md-9 d-flex align-items-center p-2 project-header__title">${data.name}</div>
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
                    <a href="#" class="project-button__add">Add Task</a>
                </div>
            </div>
        </div>`;
        return template;
}