//function Add equipement modal -> addEquipement button
export function addEquipementModal(categoryObj, modal) {

    try {
        // MODAL FORM

        let parentForm = '';
        if (modal == 'modalForm-edit') {
            parentForm = document.getElementById(modal);
        } else if (modal == 'modalForm-add') {
            parentForm = document.getElementById(modal);
        }

        let divGeneral = document.createElement('div');
        divGeneral.id = 'formModal';
        let newFormDiv1 = document.createElement('div');
        newFormDiv1.classList = 'form-group';

        //input name of new equipement (child of newFormDiv1)
        let newFormLabel1 = document.createElement('label');
        newFormLabel1.for = 'equipementName';
        newFormLabel1.textContent = 'Ajouter le nom de l\'équipement';
        let newInput1 = document.createElement('input');
        newInput1.classList = 'form-control input1';
        newInput1.id = 'equipementName';
        newInput1.type = 'text';
        newInput1.maxLength = '25';
        newInput1.required = true;
        let newSpan1 = document.createElement('span');
        newSpan1.classList = 'hidden';
        newSpan1.id = 'equipementName';
        newSpan1.textContent = 'Veuillez remplir ce champs';

        //Container of select category 
        let newFormDiv2 = document.createElement('div');
        newFormDiv2.classList = 'form-group';

        //Select a category (child of newFormDiv2)
        let newFormLabel2 = document.createElement('label');
        newFormLabel2.for = 'selectCategory'
        newFormLabel2.id = 'selectLabelCategory';
        newFormLabel2.textContent = 'Selectionner une catégorie';

        let newSelectCategory = document.createElement('select');
        newSelectCategory.name = 'category';
        newSelectCategory.classList = 'form-control';
        newSelectCategory.id = 'selectCategory';

        let newOptionCategorie = document.createElement('option');
        newOptionCategorie.value = '';
        newOptionCategorie.textContent = 'Sélectionnez une catégorie';
        newSelectCategory.appendChild(newOptionCategorie, newSelectCategory);
        let newSpan2 = document.createElement('span');
        newSpan2.classList = 'hidden';
        newSpan2.id = 'category';
        newSpan2.textContent = 'Veuillez selectionner une catégorie';


        //Retrieve categories using categories.json (list)
        categoryObj.forEach(function (category) {
            let newOption = document.createElement('option');
            newOption.textContent = category.name;
            newOption.value = category.id;
            newSelectCategory.appendChild(newOption, newSelectCategory);
        });

        //container of checkboxes
        let newFormDiv3 = document.createElement('div');
        newFormDiv3.classList = 'form-group radioE';
        newFormDiv3.textContent = 'Cet équipement est-il disponible ?'

        //checkbox Yes (child of newFormDiv3)
        let newCheckDiv1 = document.createElement('div');
        newCheckDiv1.classList = 'form-check form-check-inline';
        let newCheckInput1 = document.createElement('input');
        newCheckInput1.classList = 'form-check-input';
        newCheckInput1.for = 'inlineRadio1';
        newCheckInput1.type = 'radio';
        newCheckInput1.name = 'inlineRadioOptions';
        newCheckInput1.id = 'false';
        newCheckInput1.value = 'false';
        let newCheckLabel1 = document.createElement('label');
        newCheckLabel1.classList = 'form-check-label';
        newCheckLabel1.for = 'inlineRadio1';
        newCheckLabel1.textContent = 'Non';

        //checkbox no (child of newFormDiv3)
        let newCheckDiv2 = document.createElement('div');
        newCheckDiv2.classList = 'form-check form-check-inline';
        let newCheckInput2 = document.createElement('input');
        newCheckInput2.classList = 'form-check-input';
        newCheckInput2.for = 'inlineRadio2';
        newCheckInput2.type = 'radio';
        newCheckInput2.name = 'inlineRadioOptions';
        newCheckInput2.id = 'true';
        newCheckInput2.value = 'true';
        let newCheckLabel2 = document.createElement('label');
        newCheckLabel2.classList = 'form-check-label';
        newCheckLabel2.for = 'inlineRadio2';
        newCheckLabel2.textContent = 'Yes';

        let newSpan3 = document.createElement('span');
        newSpan3.classList = 'hidden';
        newSpan3.id = 'loaned';
        newSpan3.textContent = 'Veuillez séléctionner une disponibilité';

        //create container for input URL
        let newFormDiv4 = document.createElement('div');
        newFormDiv4.classList = 'form-group url';

        //Add url of the equipement (child of newFormDiv4)
        let newFormLabel4 = document.createElement('label');
        newFormLabel4.for = 'addURLImage';
        newFormLabel4.textContent = 'Ajouter l\'URL de l\'image';
        let newInputImage = document.createElement('input');
        newInputImage.classList = 'form-control';
        newInputImage.id = 'addURLImage';
        newInputImage.type = 'text';
        newInputImage.required = true;
        let newSpan4 = document.createElement('span');
        newSpan4.id = 'url';
        newSpan4.classList = 'hidden';
        newSpan4.textContent = 'Veuillez entrer une URL';

        parentForm.appendChild(divGeneral, parentForm);
        //input addEquipement
        divGeneral.appendChild(newFormDiv1, divGeneral);
        newFormDiv1.appendChild(newFormLabel1, newFormDiv1);
        newFormDiv1.appendChild(newInput1, newFormDiv1);
        newFormDiv1.appendChild(newInput1, newFormDiv1);
        newFormDiv1.appendChild(newSpan1, newFormDiv1);

        //select a category
        divGeneral.appendChild(newFormDiv2, divGeneral);
        newFormDiv2.appendChild(newFormLabel2, newFormDiv2);
        newFormDiv2.appendChild(newSelectCategory, newFormDiv2);
        newFormDiv2.appendChild(newSpan2, newFormDiv2);

        //loaned y/n checkboxes
        divGeneral.appendChild(newFormDiv3, divGeneral);
        newFormDiv3.appendChild(newCheckDiv1, newFormDiv3);
        newCheckDiv1.appendChild(newCheckInput1, newCheckDiv1);
        newCheckDiv1.appendChild(newCheckLabel1, newCheckDiv1);
        newFormDiv3.appendChild(newCheckDiv2, newFormDiv3);
        newCheckDiv2.appendChild(newCheckInput2, newCheckDiv2);
        newCheckDiv2.appendChild(newCheckLabel2, newCheckDiv2);
        newFormDiv3.appendChild(newSpan3, newFormDiv3);

        //input URL
        divGeneral.appendChild(newFormDiv4, divGeneral);
        newFormDiv4.appendChild(newFormLabel4, newFormDiv4);
        newFormDiv4.appendChild(newInputImage, newFormDiv4);
        newFormDiv4.appendChild(newSpan4, newFormDiv4);

    } catch (err) {
        console.log('AddModal' + err);
    }
}

export function sendEquipement() {

    try {
        let equipementName = document.getElementById('equipementName').value;
        let equipementUrl = document.getElementById('addURLImage').value;
        let maxEquipement = checkIdEquipement();
        let cardName = 'cardJSON' + maxEquipement;
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

            let boolValue = (selectLoaned === 'true');
            //save submit data (localStorage)
            const cardObj = { equipementId: equipementId, equipementName: equipementName, categoryId: parseInt(selectIndex), loaned: boolValue, equipementUrl: equipementUrl };
            const cardJSON = JSON.stringify(cardObj);
            localStorage.setItem(cardName, cardJSON);
            location.reload();
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

//function used to determine equipementId of new card added depending cards already created
function checkIdEquipement() {

    var equipementId = [];
    for (var i = 0; i < localStorage.length; i++) {
        var key = localStorage.key(i);
        var value = localStorage.getItem(key);
        let obj = JSON.parse(value);
        //retrieve the max of value to create
        equipementId.push(obj.equipementId);
    }
    //retrieve the max equipementId
    var equipementMaxId = Math.max.apply(null, equipementId);
    //if no equipement (pre-created equipement = 1 to 5) (btn-trash)
    if (localStorage.length === 0) { equipementMaxId = 6; return equipementMaxId; }
    else if (localStorage.length <= 5 && localStorage.length > 0) { equipementMaxId++; return equipementMaxId; }
    else { equipementMaxId++; return equipementMaxId; }
}