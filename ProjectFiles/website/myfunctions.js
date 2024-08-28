
function logout() {
    var r = confirm('Do you really want to log out?');
    if (r) {
        window.location.href = 'logout.php';
        session_destroy();
    }
}


function updateTextInput(val) {
    document.getElementById('textInput').innerHTML = val;
}

