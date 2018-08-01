const onMessage = el => {
    el.fadeIn(2000).promise().done(function(){
        el.fadeOut(2000);
    });
}

const checkLogin = login => {
    login.trim();
    if(login.length > 2){
        return login;
    }
    else{
        return false;
    }
}

const checkEmpty = string => {
    string.trim();
    if(string.length > 2){
        return string;
    }
    else{
        return false;
    }
}

const checkPassword = password => {
    password.trim();
    if(password.length >= 6){
        return password;
    }
    else{
        return false;
    }
}