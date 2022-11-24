//validation log in
const formLogin = document.querySelector('#form-log-in');
const email = document.querySelector('#email');
const password = document.querySelector('#password');
formLogin.addEventListener('submit', e => {
    let isSend = true;
    const emailValue = email.value;
    const passwordValue = password.value;

    if (emailValue === '') {
        setErrorFor(email, 'Chưa có thông tin tên đăng nhập!!!');
        isSend = false;
    } else {
        setSuccessFor(email);
    }

    if (passwordValue === '') {
        setErrorFor(password, 'Chưa có thông tin mật khẩu!!!');
        isSend = false;
    } else {
        setSuccessFor(password);
    }
    if (!isSend) {
        e.preventDefault()
    }

})

let setErrorFor = (input, message) => {
    const formControl = input.parentElement;
    const small = formControl.querySelector('small');
    formControl.classList = 'form-control error';
    small.innerText = message;
}

let setSuccessFor = (input) => {
    const formControl = input.parentElement;
    formControl.classList = 'form-control success';
}