function msg(msg) {
    alert(msg);
}

function logout() {
    document.cookie = "player" + '=;expires=Thu, 01 Jan 1970 00:00:01 GMT;path=/';
    location.reload();
}

function setCursorToLast(input) {
    if (typeof input.selectionStart == "number") {
        input.selectionStart = input.selectionEnd = input.value.length;
    } else if (typeof input.createTextRange != "undefined") {
        input.focus();
        var range = input.createTextRange();
        range.collapse(false);
        range.select();
    }

}