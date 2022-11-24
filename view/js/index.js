    //drop menu vertical

    let checkProduct = document.querySelectorAll('.menu-collection input[type="checkbox"]');
    for (let i = 0; i < checkProduct.length; i++) {
        checkProduct[i].addEventListener('change', function(event) {
            let subMenuMobile = event.target.nextElementSibling.nextElementSibling;
            if (this.checked) {
                subMenuMobile.style.maxHeight = subMenuMobile.scrollHeight + "px";
            } else
                subMenuMobile.style.maxHeight = '0px'
        })
    }

    //

    //


    //display list sharing and site header when scroll
    let listSharing = document.querySelector('#addThis_ListSharing');
    let siteHeader = document.querySelector('#site-header');
    window.onscroll = () => {
        if (document.body.scrollTop > 60 || document.documentElement.scrollTop > 60) {
            listSharing.style.opacity = '1';
            listSharing.style.transform = 'translateX(0)';
            siteHeader.classList.add('header-on-top')
        } else {
            listSharing.style.opacity = '0';
            listSharing.style.transform = 'translateX(15px)';

            siteHeader.classList.remove('header-on-top')

        }
    }

    //on scroll animation
    let scroll = window.requestAnimationFrame || function(callback) {
        window.setTimeout(callback, 1000 / 60)
    }

    let elToShow = document.querySelectorAll('.play-on-scroll')

    isElInViewPort = (el) => {
        let rect = el.getBoundingClientRect()
        return (
            (rect.top <= 0 && rect.bottom >= 0) ||
            (rect.bottom >= (window.innerHeight || document.documentElement.clientHeight) && rect.top <= (window.innerHeight || document.documentElement.clientHeight)) ||
            (rect.top >= 0 && rect.bottom <= (window.innerHeight || document.documentElement.clientHeight))
        )
    }

    loop = () => {
        elToShow.forEach((item, index) => {
            if (isElInViewPort(item)) {
                item.classList.add('start')
            } else {
                item.classList.remove('start')
            }
        })
        scroll(loop)
    }

    loop()


    //search 


    const formSearch = document.getElementById('search-top-bar');
    const dataSearch = formSearch.querySelector('#data-search');


    formSearch.addEventListener('submit', (e) => {
        valueSearch = dataSearch.value;
        valueSearch = valueSearch.replace(/[^0-9a-zàáạảãâầấậẩẫăằắặẳẵèéẹẻẽêềếệểễìíịỉĩòóọỏõôồốộổỗơờớợởỡùúụủũưừứựửữỳýỵỷỹđ\s]/gi, "");
        dataSearch.value = valueSearch;
    })



    // console.log(document.getElementById("myModal"))
    // var modal = document.getElementById("myModal");

    // var btn = document.getElementById("btn-login");
    // console.log(modal);

    // var span = document.getElementsByClassName("close")[0];

    // btn.onclick = function() {
    //     modal.style.display = "block";
    // }

    // span.onclick = function() {
    //     modal.style.display = "none";
    // }

    // window.onclick = function(event) {
    //     if (event.target == modal) {
    //         modal.style.display = "none";
    //     }
    // }