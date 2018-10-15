document.addEventListener('submit', getForm);

function getForm(e) {
    e.preventDefault();
    if (e.target.id === 'login-form') {
        ajaxLogin();
    }
    if (e.target.id === 'register-form') {
        ajaxRegister();
    }
    if (e.target.id === 'token-form') {
        ajaxToken();
    }
    if (e.target.id === 'ajax-switch-off') {
        ajaxSwitchOff();
    }
}

function ajaxSwitchOff() {
    var value = "ajax=";
    var loc = document.getElementById('ajax_switch_off').value;
    var xhr = new XMLHttpRequest();
    xhr.open('POST', '/ajax/switch', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.send(value);
    alert('AJAX turned off!');
    location.replace(loc);
}

function ajaxLogin() {
    var login = document.getElementById('login').value;
    var password = document.getElementById('password').value;
    var user = "login=" + encodeURIComponent(login) +
        "&" + "password=" + encodeURIComponent(password) +
        "&" + "do_login=";

    var xhr = new XMLHttpRequest();
    xhr.open('POST', '/ajax/login', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function() {
        if (xhr.readyState==4 && xhr.status==200) {
            var data = JSON.parse(xhr.responseText);
            if (data['error']) {
                document.getElementById('notice').innerHTML = data['error'];
            } else {
                alert('Welcome, ' + data['user'] + '!');
                location.replace('http://php.fw');
            }
        }
    };
    xhr.send(user);
}

function ajaxRegister() {
    var login = document.getElementById('login').value;
    var email = document.getElementById('email').value;
    var password = document.getElementById('password').value;
    var password_2 = document.getElementById('password_2').value;
    var user = "login=" + encodeURIComponent(login) +
        "&" + "email=" + encodeURIComponent(email) +
        "&" + "password=" + encodeURIComponent(password) +
        "&" + "password_2=" + encodeURIComponent(password_2) +
        "&" + "do_sign_up=";

    var xhr = new XMLHttpRequest();
    xhr.open('POST', '/ajax/register', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function() {
        if (xhr.readyState==4 && xhr.status==200) {
            var data = JSON.parse(xhr.responseText);
            if (data['error']) {
                document.getElementById('notice').innerHTML = data['error'];
            } else {
                alert('Welcome, on Board, ' + data['user'] + '!');
                location.replace('http://php.fw');
            }
        }
    };
    xhr.send(user);
}

function ajaxToken() {
    var user = "get_token=";
    var xhr = new XMLHttpRequest();
    xhr.open('POST', '/ajax/token', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function() {
        if (xhr.readyState==4 && xhr.status==200) {
            var data = JSON.parse(xhr.responseText);
            if (data['error']) {
                document.getElementById('notice').innerHTML = data['error'];
            } else {
                document.getElementById('notice').style.color = "green";
                document.getElementById('notice').innerHTML = 'Save your Token: ' + data['token'];
            }
        }
    };
    xhr.send(user);
}