//validation sign up
const formSignUp = document.querySelector('#form-sign-up');
const phoneNumber = document.querySelector('#phone-number');
const nameUser = document.querySelector('#name');

const password = document.querySelector('#password');
const email = document.querySelector('#email');


formSignUp.addEventListener('submit', e => {
    let isSend = true;

    const phoneNumberValue = phoneNumber.value;
    const nameUserValue = nameUser.value;
    const passwordValue = password.value;
    const emailValue = email.value;

    if (phoneNumberValue === '') {
        setErrorFor(phoneNumber, 'Chưa có thông tin số điện thoại!!!');
        isSend = false;
    } else {
        if (!phoneNumberValue.match(/^0(\d{9}|\d{10})$/)) {
            setErrorFor(phoneNumber, 'Số điện thoại không phù hợp!!!');
            isSend = false;
        } else {
            setSuccessFor(phoneNumber);
        }
    }
    if (nameUserValue === '') {
        setErrorFor(nameUser, 'Chưa có thông tin họ tên!!!');
        isSend = false;
    } else {
        setSuccessFor(nameUser);
    }
    if (emailValue === '') {
        setErrorFor(email, 'Chưa có thông tin email!!!');
        isSend = false;
    } else {
        if (!validateEmail(emailValue)) {
            setErrorFor(email, 'Email không phù hợp!!!');
            isSend = false;

        } else {
            setSuccessFor(email);
        }
    }




    if (passwordValue === '') {
        setErrorFor(password, 'Chưa có thông tin mật khẩu!!!');
        isSend = false;
    } else {
        setSuccessFor(password);
    }

    if (!isSend) {
        e.preventDefault();
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

function validateEmail(email) {
    const re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(String(email).toLowerCase());
}