function msg(msg) {
    alert(msg);
}

function logout() {
    document.cookie = "player" + '=;expires=Thu, 01 Jan 1970 00:00:01 GMT;';
    location.reload();
}