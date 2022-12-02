
const username = document.getElementById('txtUserName');
const password = document.getElementById('txtPassword');
const btnSubmit = document.getElementById('btnSubmit');
const showPassToggle = document.getElementById('btnShowPass');

let showPassword = false;

$(document).ready( () => {
    checkLogin();
});
var waitlogin = null;
async function checkLogin() {
    await fetch(checkLoginUrl)
    .then(res => res.json())
    .then((res) => {
        // console.log(res);
        if (!res) {
            if (!$('#loginModal').hasClass('show')) {

                // $('#loginModal').modal('show');
                $('#loginModal').modal({
                    backdrop: 'static',
                    keyboard: false
                });
            }
        } else {
            if ($('#loginModal').hasClass('show')) {
                $('#loginModal').modal('hide');
            }
        }
        if (waitlogin )  clearTimeout(waitlogin);
        waitlogin= window.setTimeout(() => {
            checkLogin();
            waitlogin = null;
        }, 10000);
    });

}

showPassToggle.addEventListener('click', () => {
    if (showPassword == false){
        password.setAttribute("type", "text");
        showPassToggle.style.background = '#aaa'
        showPassword = true;
    } else {
        password.setAttribute("type", "password");
        showPassToggle.style.background = 'transparent'
        showPassword = false;
    }
})


btnSubmit.addEventListener('click', async (e) => {
    console.log("Clicked", username, password);

    await fetch(loginCheckUrl, {
        method: 'post',
        headers: {
            'Content-Type' : 'application/json'
        },
        body: JSON.stringify({
            Username: username.value,
            Password: password.value
        })
    })
    .then(response => response.json())
    .then(async (res) => {
        console.log(res);
        if (res.includes("Error")) {
            e.preventDefault();
            alert("An error occured: " + res)
        }

        await fetch(loginAJAXUrl,  {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                Username: username.value,
                Password: password.value
            })
        }).then(res => res.json())
        .then((res) => {
            console.log(res);
            if (res) {
                $('#loginModal').modal('hide');
                checkLogin();
            } else {
                alert('Incorrect details have been used.');
            }
        });
    })
});
