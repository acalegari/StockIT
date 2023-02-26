export function sendEquipement() {

    try {
        let equipementName = document.getElementById('equipementName').value;
        let equipementUrl = document.getElementById('addURLImage').value;
        let maxEquipement = checkIdEquipement();
        //let cardName = 'cardJSON' + maxEquipement;
        let equipementId = maxEquipement;
        let isUrl = isUrlImage(equipementUrl);

        //Retrieve option of the category sent during submission
        let selectIndex = $('#selectCategory :selected').val();

        //retrieve loaned value sent during submission --> if no check radio = undefined else true:false
        let selectLoaned = undefined;
        selectLoaned = $('.form-check-input:checked').val();

        //check if click on semd before fill all fields; y = display all error message
        if (equipementName == '' && isUrl == false && (parseInt(selectIndex) == 0 || parseInt(selectIndex) == '') && selectLoaned == undefined) {
            $('input.input1').css('border', '3px solid red');
            $('span#equipementName').addClass('errorMsgShow');
            $('span#equipementName').removeClass('hidden');
            $('select#selectCategory').css('border', '3px solid red');
            $('span#category').removeClass('hidden');
            $('span#category').addClass('errorMsgShow');
            $('span#loaned').addClass('errorMsgShow');
            $('span#loaned').removeClass('hidden');
            $('input#addURLImage').css('border', '3px solid red');
            $('span#url').removeClass('hidden');
            $('span#url').addClass('errorMsgShow');
        }
        else if (!isStrSpaces(equipementName)) {
            $('input.input1').css('border', '3px solid red');
            $('span#equipementName').removeClass('hidden');
            $('span#equipementName').addClass('errorMsgShow');
        }
        else if (equipementName == '') {
            $('input.input1').css('border', '3px solid red');
            $('span#equipementName').addClass('errorMsgShow');
            $('span#equipementName').removeClass('hidden');
        } else if (parseInt(selectIndex) == '' || parseInt(selectIndex) == 0) {
            $('select#selectCategory').css('border', '3px solid red');
            $('span#category').removeClass('hidden');
            $('span#category').addClass('errorMsgShow');
        }
        else if (selectLoaned == undefined) {
            $('span#loaned').addClass('errorMsgShow');
            $('span#loaned').removeClass('hidden');
        }
        else if (isUrl == false) {
            $('input#addURLImage').css('border', '3px solid red');
            $('span#url').removeClass('hidden');
            $('span#url').addClass('errorMsgShow');
        }
        else if (!equipementName == '' && isUrl == true && (!parseInt(selectIndex) == '' || !parseInt(selectIndex) == 0) && selectLoaned != undefined) {

            // let boolValue = (selectLoaned === 'true');
            // //save submit data (localStorage)
            // const cardObj = { equipementId: equipementId, equipementName: equipementName, categoryId: parseInt(selectIndex), loaned: boolValue, equipementUrl: equipementUrl };
            // const cardJSON = JSON.stringify(cardObj);
            // localStorage.setItem(cardName, cardJSON);
            // location.reload();
        }
        else {
            $('span#equipementName').addClass('hidden');
            $('span#equipementName').removeClass('errorMsgShow');
            $('span#category').addClass('hidden');
            $('span#category').removeClass('errorMsgShow');
            $('span#radio').removeClass('errorMsgShow');
            $('span#radio').addClass('hidden');
            $('span#url').addClass('hidden');
            $('span#url').removeClass('errorMsgShow');
        }
    } catch (err) {
        console.log('sendEquipement' + err);
    }
}

//Check the format of the URL input
export function isUrlImage(url) {
    return /^https?:\/\/.+\.(jpg|jpeg|png|webp|avif|gif|svg)$/.test(url);
}

export function isStrSpaces(txt) {
    return txt.replace(/\s/g, '').length;
}