let appful_login_loading = false;
let appful_logout_loading = false;

const TOKEN_PREFIX = "Bearer ";

function login() {
    if (axios && !appful_login_loading) {
        show_login_loading();
        axios.post(appful_api_url + '/appfulUsers/login', {
            username: document.getElementById('username').value,
            password: document.getElementById('password').value
        })
            .then(response => {
                if (response && response.headers && response.headers.authorization) {
                    let authToken = response.headers.authorization;
                    if (authToken.startsWith(TOKEN_PREFIX)) {
                        let realToken = authToken.substring(TOKEN_PREFIX.length)
                        submit_login(realToken, response.data.username);
                    }
                }
            })
            .catch(error => {
                if (error) {
                    if (error.response && error.response.data) {
                        show_error(error.response.data);
                    } else if (error.message) {
                        show_error(error.message);
                    }
                }
            })
            .finally(() => hide_login_loading());
    }
}

function logout() {
    if (axios && !appful_logout_loading) {
        show_logout_loading();
        submit_logout();
    }
}

function submit_login(token, username) {
    document.getElementById('appful_submit_token').value = token;
    document.getElementById('appful_submit_username').value = username;
    document.getElementById('appful_submit_token_form').submit();
}

function submit_logout() {
    document.getElementById('appful_submit_logout_form').submit();
}

function hide_error() {
    document.getElementById('appful_error_container').style.display = "none";
    document.getElementById('appful_error').textContent = "";
}

function show_error(error) {
    document.getElementById('appful_error_container').style.display = "block";
    document.getElementById('appful_error').textContent = error;
}

function show_login_loading() {
    appful_login_loading = true;
    document.getElementById('appful_login_loading').style.display = "block";
}

function hide_login_loading() {
    document.getElementById('appful_login_loading').style.display = "none";
    appful_login_loading = false;
}

function show_logout_loading() {
    appful_logout_loading = true;
    document.getElementById('appful_logout_loading').style.display = "block";
}

function hide_logout_loading() {
    document.getElementById('appful_logout_loading').style.display = "none";
    appful_logout_loading = false;
}