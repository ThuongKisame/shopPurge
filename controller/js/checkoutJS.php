<script src="view/js/dataAddress.js"></script>
    <script>
    // console.log(dataAddress["01"]["name"]);
    window.onload = function() {
            let indexProvince = 0;
            let indexDistrict = 0;
            const province = document.querySelector('#province');
            const district = document.querySelector('#district');
            const village = document.querySelector('#village');
            const provinceHidden = document.querySelector('input[name=province-hidden]');
            const districtHidden = document.querySelector('input[name=district-hidden]');
            const villageHidden = document.querySelector('input[name=village-hidden]');
            console.log(villageHidden);
            
            for (let i in dataAddress) {
                province.options[province.options.length] = new Option(dataAddress[i]["name"], i);
            }
            province.onchange = function() {
                let indexProvince = province.value;
                provinceHidden.value = dataAddress[indexProvince]['name'];
                const dataDistrict = dataAddress[indexProvince]["QuanHuyen"];
                // console.log(dataProvince);
                district.length = 1; // remove all options bar first
                village.length = 1; // remove all options bar first
                if (this.selectedIndex < 1) return; // done
                for (let i in dataDistrict) {
                    district.options[district.options.length] = new Option(dataDistrict[i]["name"], i);

                }
            }
            // province.onchange(); // reset in case page is reloaded
            district.onchange = function() {

                let indexProvince = province.value;
                let indexDistrict = district.value;
                districtHidden.value = dataAddress[indexProvince]["QuanHuyen"][indexDistrict]['name'];
                const dataVillage = dataAddress[indexProvince]["QuanHuyen"][indexDistrict]["XaPhuong"];
                // console.log(dataVillage);

                village.length = 1; // remove all options bar first
                if (this.selectedIndex < 1) return; // done

                for (let i in dataVillage) {
                    village.options[village.options.length] = new Option(dataVillage[i]["name"], i);
                }

            }

            village.onchange = function() {
                let indexProvince = province.value;
                let indexDistrict = district.value;
                let indexVillage = village.value;
                villageHidden.value = dataAddress[indexProvince]["QuanHuyen"][indexDistrict]["XaPhuong"][indexVillage]['name'];
            }
            
        }


        //validate
        const name = document.querySelector('#name');
        const phoneNum = document.querySelector('#phoneNum');
        const addressDetail = document.querySelector('#addressDetail');
        const province = document.querySelector('#province');
        const district = document.querySelector('#district');
        const village = document.querySelector('#village');
        const formCheckOut = document.querySelector('.form-check-out');
        formCheckOut.addEventListener('submit',(e)=>{
            let isSend = true;
            name.value =  validateInput(name.value);
            addressDetail.value =  validateInput(addressDetail.value);

            if(name.value === ''){
                setErrorFor(name, "Ch??a c?? th??ng tin h??? t??n!");
                isSend = false;

            }
            else{
                setSuccessFor(name);                 
            }
            if (phoneNum.value === '') {
                setErrorFor(phoneNum, 'Ch??a c?? th??ng tin s??? ??i???n tho???i!!!');
                isSend = false;
            } else {
                 if (!phoneNum.value.match(/^0(\d{9}|\d{10})$/)) {
                 setErrorFor(phoneNum, 'S??? ??i???n tho???i kh??ng ph?? h???p!!!');
                isSend = false;
                } else {
                    setSuccessFor(phoneNum);
                 }
            }
            if(addressDetail.value === ''){
                setErrorFor(addressDetail, 'Vui l??ng nh???p ?????a ch??? chi ti???t!');
                isSend = false;

            }
            else{
                setSuccessFor(addressDetail);
            }

            if(province.value===''){
                setErrorFor(province, 'Vui l??ng ch???n t???nh/th??nh!');
                isSend = false;

            }
            else{
                setSuccessFor(province);
            }
            if(district.value===''){
                setErrorFor(district, 'Vui l??ng ch???n qu???n/huy???n!');
                isSend = false;

            }
            else{
                setSuccessFor(district);
            }
            if(village.value===''){
                setErrorFor(village, 'Vui l??ng ch???n x??/ph?????ng!');
                isSend = false;

            }
            else{
                setSuccessFor(village);
            }

            if (!isSend) {
                e.preventDefault()
            }

        })


//     let setErrorFor = (input, message) => {
//     const formControl = input.parentElement;
//     const small = formControl.querySelector('small');
//     formControl.classList = 'form-control error';
//     small.innerText = message;
// }

//     let setSuccessFor = (input) => {
//     const formControl = input.parentElement;
//     formControl.classList = 'form-control';
// }

    function validateInput(string){
        return string.replace(/[^0-9a-z/,.???????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????\s]/gi, "");
    }



    </script>