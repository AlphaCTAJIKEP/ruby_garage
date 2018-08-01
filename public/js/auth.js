/**
 * Events section
 */
$('#register-form').on('submit', function(e){
    e.preventDefault();
    let login = $(this).find('#regLogin').val();
    let password = $(this).find('#regPassword').val();
    let verif_login = checkLogin(login);
    let verif_password = checkPassword(password);
    let error_login = $(this).find('.reg-login__error');
    let error_password = $(this).find('.reg-password__error');
    if(!verif_login){
        error_login.html('Логин не должен быть короче 2-х символов');
        error_login.show();
    }
    else{
        error_login.hide();
    }
    if(!verif_password){
        error_password.html('Пароль не должен быть короче 6-и символов');
        error_password.show();
    }
    else{
        error_password.hide();
    }

    if(verif_login && verif_password){
        error_login.hide();
        error_password.hide();
        registerUser(verif_login,verif_password);
    }
});

$('#sign-form').on('submit', function(e){
    e.preventDefault();
    let login = $(this).find('#signLogin').val();
    let password = $(this).find('#signPassword').val();
    loginUser(login,password);
});

$('.header-logout').on('click', function(){
    logoutUser();
});

/**
 * Methods section
 */

const registerUser = (login,password) => {
    data = new FormData();
    data.append('user_login',login);
    data.append('user_password',password);
    $.ajax({
        type: "POST",
        url: "/auth/register",
        cache: false,
        contentType: false,
        processData: false,
        data: data,
        success: function (data) {
            console.log(data);
            let json = JSON.parse(data);
            if(json.errors === undefined){
                $('.header-success__message').html('Вы успешно зарегистрированы, можете зайти под своим логином');
                $('#register-form input').val('');
                onMessage($('.header-success__message'));
                $('#logIn-tab').click();
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

const loginUser = (login,password) => {
    data = new FormData();
    data.append('user_login',login);
    data.append('user_password',password);
    $.ajax({
        type: "POST",
        url: "/auth/login",
        cache: false,
        contentType: false,
        processData: false,
        data: data,
        success: function (data) {
            let json = JSON.parse(data);
            if(json.errors === undefined){
                $('.header-success__message').html('Добро пожаловать ' + json.success);
                $('#register-form input').val('');
                onMessage($('.header-success__message'));
                setTimeout(function(){
                    location.reload();
                }, 2000)
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

const logoutUser = () => {
    data = new FormData();
    $.ajax({
        type: "POST",
        url: "/auth/logout",
        cache: false,
        contentType: false,
        processData: false,
        data: data,
        success: function (data) {
                    location.reload();
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