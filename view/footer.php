<link rel="stylesheet" href="view/css/login.css">

<style>
body {font-family: Arial, Helvetica, sans-serif;}

/* The Modal (background) */
.modal {
  display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 1; /* Sit on top */
  padding-top: 100px; /* Location of the box */
  left: 0;
  top: 0;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  overflow: auto; /* Enable scroll if needed */
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
}

/* Modal Content */
.modal-content {
  background-color: #fefefe;
  margin: auto;
  padding: 20px;
  border: 1px solid #888;
  width: 80%;
}

/* The Close Button */
.close {
  color: #aaaaaa;
  float: right;
  font-size: 28px;
  font-weight: bold;
}

.close:hover,
.close:focus {
  color: #000;
  text-decoration: none;
  cursor: pointer;
}
</style>

<!-- Trigger/Open The Modal -->


<!-- The Modal -->
<div id="myModal" class="modal">

  <!-- Modal content -->
  <div class="modal-content">
    <span class="close">&times;</span>
    <div  id="form-log-in" class="col-6 col-tb-8 col-xs-12" >
            <h1>Đăng nhập</h1>
            <div class="form-control <?php if(!empty($error)):?> error<?php endif ?>">
                <input type="text" placeholder="Email" id="email" name="email" value="<?php echo $email;?>">
                <i id="icon-error" class="bx bxs-error-circle"></i>
                <i id="icon-success" class="bx bxs-check-circle"></i>
                <br>
                <small><?php echo $error;?></small>
            </div>
            <div class="form-control <?php if(!empty($error)):?> error<?php endif ?>">
                <input type="password" placeholder="Password" id="password" name="password">
                <i id="icon-error" class="bx bxs-error-circle"></i>
                <i id="icon-success" class="bx bxs-check-circle"></i>
                <br>
                <small></small>
            </div>
            <button type="submit" name="login-btn" id="btn-send-login">Đăng nhập</button>
            <a href="restorePassword.php">Quên mật khẩu</a>
            <span>Nếu bạn chưa có tài khoản thì đăng ký tại đây <a href="signUp.php">Đăng ký</a></span>
        </div>
  </div>

</div>

<script>
$modal = $("#myModal");
$btn = $("#btn-login");
$span = $(".close");
$btn.on('click', function(){
    $modal.css('display', 'block') ;
}) 
$span.on('click', function(){
    $modal.css('display', 'none') ;
}) 
const btnSendLogin = document.querySelector('#btn-send-login');



//validation log in
const email = document.querySelector('#email');
const password = document.querySelector('#password');
btnSendLogin.addEventListener('click', e => {
    let isSend = true;
    const emailValue = email.value;
    const passwordValue = password.value;

    if (emailValue === '') {
        setErrorFor(email, 'Chưa có thông tin tên đăng nhập!!!');
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
    if (isSend) {
        sendData(emailValue,passwordValue );
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


function sendData($email, $password){
    $headerWrapIcon = $('#header-wrap-icon');
    $.ajax({
    type: 'GET',
    url: 'controller/ajaxLogin.php',
    data:{
        email: $email,
        password: $password
    },
    success: function(data){
        if(data!=''){
            alert("Đăng nhập thành công");
            $span.click();
            $headerWrapIcon.html(`
                    <a href="account.php" id="icon-account" data=${data}>
                        <i class='bx bx-user'></i>
                        <span class="h-xs h-tb">
                            Xin chào!!
                        </span>
                    </a>      
                            
                    <a href="cart.php" id="icon-cart-handle">
                        <i class='bx bx-shopping-bag'></i>
                        <span id="quantity-cart">0</span>
                    </a>`)

            
        }
        else{
            setErrorFor(password, "Tên đăng nhập hoặc mật khẩu không đúng");
            setErrorFor(email, "");
            email.focus();
        }
        

    },
    error: function(){

    }
})
}



// window.onclick = function(event) {
//   if (event.target == modal) {
//     modal.style.display = "none";
//   }
// }
</script>
<footer>
        <!-- <div id="footer-mobile" class="show-xs">
            <h1>Thông tin khác <span><i class="bx bx-down-arrow"></i></span> </h1>
        </div> -->
        <div class="container ">
            <div class="row">
                <div class="col-4 col-tb-8 col-xs-12">
                    <div class="footer-content-1 footer-content">
                        <h3>Giới thiệu</h3>
                        <p>purgesg The Shirt You Need - PURGE được thành lập vào năm 2016, tất cả sản phẩm của PURGE đều được tự thiết kế và sản xuất dựa theo tiêu chí chất lượng. Tất cả sản phẩm của TSUN đều thuộc bản quyền của PURGE</p>
                        <div id="logo-footer"><img src="view/img/logoPurge.png" alt=""></div>
                    </div>
                </div>
                <div class="col-2 col-tb-4 col-xs-12">
                    <div class="footer-content-2 footer-content">
                        <h3>Liên kết</h3>
                        <ul>
                            <li><a href="">Trang chủ</a></li>
                            <li><a href="">Sản phẩm</a></li>
                            <li><a href="">Hướng dẫn</a></li>
                            <li><a href="">Đang giảm giá</a></li>
                            <li><a href="">Bảng size</a></li>
                            <li><a href="">Giới thiệu PURGE</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-3 col-tb-6 col-xs-12">
                    <div class="footer-content-2 footer-content">
                        <h3>Thông tin liên hệ</h3>
                        <ul>
                            <li><i class="bx bxs-location-plus"></i>
                                <ul>
                                    <li>🔥HCM| 350 Điện Biên Phủ,Q.Bình Thạnh.----------------------------------</li>
                                    <li>🔥HCM| 350 Điện Biên Phủ,Q.Bình Thạnh.----------------------------------</li>
                                    <li>🔥HCM| 350 Điện Biên Phủ,Q.Bình Thạnh.----------------------------------</li>
                                    <li>🔥HCM| 350 Điện Biên Phủ,Q.Bình Thạnh.----------------------------------</li>
                                    <li>🔥HCM| 350 Điện Biên Phủ,Q.Bình Thạnh.----------------------------------</li>
                                </ul>
                            </li>
                            <li><i class="bx bxs-phone"></i> 0377738029</li>
                            <li><i class="bx bx-mail-send"></i> purge@gmail.com</li>
                        </ul>
                    </div>
                </div>
                <div class="col-3 col-tb-6 col-xs-12">
                    <div class="footer-content-2 footer-content">
                        <h3>Fanpage</h3>
                        <iframe src="https://www.facebook.com/plugins/page.php?href=https%3A%2F%2Fwww.facebook.com%2FDirtyCoins.VN&tabs&width=340&height=214&small_header=false&adapt_container_width=true&hide_cover=false&show_facepile=true&appId" width="340" height="214" style="border:none;overflow:hidden"
                            scrolling="no" frameborder="0" allowTransparency="true" allow="encrypted-media"></iframe>
                    </div>
                </div>
            </div>
        </div>

    </footer>
    <!-- END FOOTER -->


    <!-- END SECTION MAIN -->
    <!-- LIST SHARING -->
    <div id="addThis_ListSharing" class="h-xs">
        <ul>
            <li>
                <a href="">
                    <svg width="44" height="44" viewBox="0 0 44 44" fill="none" xmlns="http://www.w3.org/2000/svg"> <circle cx="22" cy="22" r="22" fill="url(#paint2_linear)"></circle> <path fill-rule="evenodd" clip-rule="evenodd" d="M14.0087 9.35552C14.1581 9.40663 14.3885 9.52591 14.5208 9.61114C15.3315 10.148 17.5888 13.0324 18.3271 14.4726C18.7495 15.2949 18.8903 15.9041 18.758 16.3558C18.6214 16.8415 18.3953 17.0971 17.384 17.9109C16.9786 18.239 16.5988 18.5756 16.5391 18.6651C16.3855 18.8866 16.2617 19.3212 16.2617 19.628C16.266 20.3395 16.7269 21.6305 17.3328 22.6232C17.8021 23.3944 18.6428 24.3828 19.4749 25.1413C20.452 26.0361 21.314 26.6453 22.2869 27.1268C23.5372 27.7488 24.301 27.9064 24.86 27.6466C25.0008 27.5826 25.1501 27.4974 25.1971 27.4591C25.2397 27.4208 25.5683 27.0202 25.9268 26.5772C26.618 25.7079 26.7759 25.5674 27.2496 25.4055C27.8513 25.201 28.4657 25.2563 29.0844 25.5716C29.5538 25.8145 30.5779 26.4493 31.2393 26.9095C32.1098 27.5187 33.9703 29.0355 34.2221 29.3381C34.6658 29.8834 34.7427 30.5821 34.4439 31.3534C34.1281 32.1671 32.8992 33.6925 32.0415 34.3444C31.2649 34.9323 30.7145 35.1581 29.9891 35.1922C29.3917 35.222 29.1442 35.1709 28.3804 34.8556C22.3893 32.3887 17.6059 28.7075 13.8081 23.65C11.8239 21.0084 10.3134 18.2688 9.28067 15.427C8.67905 13.7696 8.64921 13.0495 9.14413 12.2017C9.35753 11.8438 10.2664 10.9575 10.9278 10.4633C12.0288 9.64524 12.5365 9.34273 12.9419 9.25754C13.2193 9.19787 13.7014 9.24473 14.0087 9.35552Z" fill="white"></path> <defs> <linearGradient id="paint2_linear" x1="22" y1="-7.26346e-09" x2="22.1219" y2="40.5458" gradientUnits="userSpaceOnUse"> <stop stop-color="#0f991d"></stop> <stop offset="1" stop-color="#0fd647"></stop> </linearGradient> </defs> </svg>
                </a>
            </li>
            <li>
                <a href="">
                    <svg width="44" height="44" viewBox="0 0 44 44" fill="none" xmlns="http://www.w3.org/2000/svg"> <circle cx="22" cy="22" r="22" fill="url(#paint1_linear)"></circle> <path fill-rule="evenodd" clip-rule="evenodd" d="M11.4589 11.6667H32.5414C33.1621 11.6667 33.6993 11.8861 34.153 12.3245C34.6062 12.7634 34.8332 13.2904 34.8332 13.9064C34.8332 14.6435 34.599 15.3481 34.1319 16.0197C33.6639 16.6914 33.0816 17.2655 32.3846 17.7413C30.0672 19.3131 28.3185 20.4998 27.1311 21.3061C26.4785 21.7489 25.9931 22.0787 25.6817 22.2905C25.6355 22.3222 25.5634 22.3723 25.4675 22.4396C25.3643 22.5117 25.2337 22.6037 25.0729 22.7174C24.7625 22.9368 24.5048 23.114 24.2994 23.2495C24.0938 23.3846 23.8457 23.5363 23.5545 23.7043C23.2631 23.8724 22.9887 23.9983 22.7309 24.0823C22.4731 24.1661 22.2344 24.2082 22.0148 24.2082H22.0006H21.9863C21.7667 24.2082 21.5281 24.1661 21.2702 24.0823C21.0125 23.9983 20.7378 23.8721 20.4466 23.7043C20.1552 23.5363 19.9068 23.385 19.7017 23.2495C19.4964 23.114 19.2386 22.9368 18.9284 22.7174C18.7672 22.6037 18.6366 22.5118 18.5334 22.4393L18.5233 22.4323C18.4325 22.3688 18.3638 22.3208 18.3195 22.2905C17.9197 22.0157 17.4354 21.6846 16.8739 21.3022C16.2152 20.8532 15.4486 20.3329 14.5671 19.7359C12.9342 18.6303 11.9554 17.9654 11.6308 17.7413C11.0388 17.3494 10.4802 16.8107 9.95513 16.1248C9.43011 15.4387 9.16748 14.8018 9.16748 14.214C9.16748 13.4864 9.36539 12.8796 9.76184 12.3944C10.158 11.9095 10.7234 11.6667 11.4589 11.6667ZM33.4002 19.2392C31.4494 20.5296 29.7913 21.6405 28.4258 22.5725L34.8324 28.8337V18.0213C34.4217 18.4695 33.9443 18.8752 33.4002 19.2392ZM9.1665 18.0214C9.58659 18.4788 10.0691 18.8848 10.6132 19.2393C12.6414 20.5863 14.2935 21.6952 15.5757 22.5701L9.1665 28.8335V18.0214ZM34.0421 30.8208C33.6172 31.1883 33.1173 31.3745 32.5403 31.3745H11.4578C10.8809 31.3745 10.3807 31.1883 9.95575 30.8208L17.2287 23.7122C17.4107 23.8399 17.5789 23.9592 17.7306 24.0679C18.2751 24.4597 18.7165 24.7654 19.0556 24.9845C19.3944 25.2041 19.8455 25.4279 20.4091 25.6564C20.9726 25.8853 21.4976 25.9993 21.9847 25.9993H21.9989H22.0132C22.5002 25.9993 23.0253 25.8852 23.5888 25.6564C24.152 25.4279 24.6032 25.2041 24.9423 24.9845C25.2814 24.7654 25.7231 24.4597 26.2672 24.0679C26.427 23.955 26.5961 23.8362 26.7705 23.7141L34.0421 30.8208Z" fill="white"></path> <defs> <linearGradient id="paint1_linear" x1="22" y1="0" x2="22" y2="44" gradientUnits="userSpaceOnUse"> <stop stop-color="#2618ba"></stop> <stop offset="1" stop-color="#0c00f2"></stop> </linearGradient> </defs> </svg>
                </a>
            </li>
            <li>
                <a href="">
                    <svg width="44" height="44" viewBox="0 0 44 44" fill="none" xmlns="http://www.w3.org/2000/svg"> <circle cx="22" cy="22" r="22" fill="url(#paint5_linear)"></circle> <path d="M22 10C17.0374 10 13 13.7367 13 18.3297C13 24.0297 21.0541 32.3978 21.397 32.7512C21.7191 33.0832 22.2815 33.0826 22.603 32.7512C22.9459 32.3978 31 24.0297 31 18.3297C30.9999 13.7367 26.9626 10 22 10ZM22 22.5206C19.5032 22.5206 17.4719 20.6406 17.4719 18.3297C17.4719 16.0188 19.5032 14.1388 22 14.1388C24.4968 14.1388 26.528 16.0189 26.528 18.3297C26.528 20.6406 24.4968 22.5206 22 22.5206Z" fill="white"></path> <defs> <linearGradient id="paint5_linear" x1="22" y1="0" x2="22" y2="44" gradientUnits="userSpaceOnUse"> <stop stop-color="#f5ae16"></stop> <stop offset="1" stop-color="#d99009"></stop> </linearGradient> </defs> </svg>
                </a>
            </li>
        </ul>
    </div>
    <!-- <div class="addThis_ListSharing-mb show-xs-flex">
        <a class="col-xs-4" style="text-align: center;"><i class="bx bxs-phone"></i> </a>
        <a class="col-xs-4" style="text-align: center;"><i class="bx bx-mail-send"></i> </a>
        <a class="col-xs-4" style="text-align: center;"><i class="bx bxs-location-plus"></i></a>
    </div> -->