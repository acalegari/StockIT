import {addEquipementModal, isUrlImage } from './modal.js';

//button addEquipement -> Add text when mouse is over + button and remove effect button
$(document).ready(function () {

    let btnText = document.querySelector('.home');
    btnText.addEventListener('mouseover', addText);
    btnText.addEventListener('mouseleave', removeAddText);

    function addText() {
        btnText.textContent = 'Ajouter équipement';
    }

    function removeAddText() {
        btnText.textContent = '';
        let iBtn = document.createElement('i');
        iBtn.classList = 'fa fa-plus';
        iBtn.ariaHidden = 'true';
        const parentBtn = document.querySelector('.home');
        parentBtn.appendChild(iBtn, parentBtn);
    }
});

                                    //   NAV FILTER //
// Uses the name of equipement added on class and checks the name with the nav class id
$(document).ready(function () {
    //click on nav to filter selected category
    try {
        $('.nav-link').click(function (e) {
            $('div#gallery > div').removeClass('hidden');
            let href = e.target.id;
            let divCard = $('div#gallery > div');
            $(divCard).each(function () {
                let cardName = $(this).attr('class').split(' ').pop();
                if (href !== cardName && href !== 'Accueil') {
                    $('div.' + cardName).addClass('hidden');
                } else if (href == 'Accueil') {
                    $('div#gallery > div').removeClass('hidden');
                }
            });
        });
    } catch (err) {
        console.log('filter' + err);
    }
});

//Opens modal for add new equipement and add verifications field.
$(document).ready(function () {
    try {
        $('button#addEquipement').click(function (e) {
            $.ajax({
                url : '/home',
                data : {"données" : []},
                type : "POST",
                success : function(data){
                    $('.modal-add').modal('show');
                    console.log($('.modal-add').modal('show'));
                }
            });
            return false;


           
            //checks on change inputs
            $('.modalFormAdd :input').on('change', function (e) {
                let selectLoaned = e.target.checked;
                
                if (e.target.id == 'modal_form_name' && !e.target.value == '') {
                    $($(this)).css('border', '');
                    $('span#equipementName').addClass('hidden');
                    $('span#equipementName').removeClass('errorMsgShow');
                }

                if (e.target.id == 'modal_form_name' && e.target.value == '') {
                    $($(this)).css('border', '3px solid red');
                    $('span#equipementName').removeClass('hidden');
                    $('span#equipementName').addClass('errorMsgShow');
                }

                if (e.target.id == 'selectCategory' && e.target.value != 0) {
                    $($(this)).css('border', '');
                    $('span#category').addClass('hidden');
                    $('span#category').removeClass('errorMsgShow');
                }
                if (e.target.id == 'selectCategory' && e.target.value == 0) {
                    $($(this)).css('border', '3px solid red');
                    $('span#category').removeClass('hidden');
                    $('span#category').addClass('errorMsgShow');
                }
                if (e.target.name == 'inlineRadioOptions' && selectLoaned != true) {
                    $('span#loaned').addClass('errorMsgShow');
                    $('span#loaned').removeClass('hidden');
                }
                if (selectLoaned == true) {
                    $('span#loaned').removeClass('errorMsgShow');
                    $('span#loaned').addClass('hidden');
                }

                if (e.target.id == 'modal_form_image') {
                    if (isUrlImage(e.target.value) == false && e.target.value != '') {
                        $($(this)).css('border', '3px solid red');
                        $('span#urlInput').removeClass('hidden');
                        $('span#urlInput').addClass('errorMsgShow');
                        $('span#urlInput').html('Veuillez entrer une url valide. ex: https://www.xxxxx.jpg');
                    }
                    if (e.target.value == '') {
                        $($(this)).css('border', '3px solid red');
                        $('span#urlInput').removeClass('hidden');
                        $('span#urlInput').addClass('errorMsgShow');
                        $('span#urlInput').html('Veuillez entrer une url');
                    }
                    if (e.target.value != '' && isUrlImage(e.target.value) == true) {
                        $($(this)).css('border', '');
                        $('span#urlInput').addClass('hidden');
                        $('span#urlInput').removeClass('errorMsgShow');
                    }
                }
            });
        });

        //reset fields data + verifications information if existing, in the case the close button is clicked for addEquipementForm
        $('.close').click(function () {
            $('.modal-add').off();
            $('.modal-add').modal('hide');
            $('.modal-add').on('hidden.bs.modal', function () {
                $('span#equipementName, span#category, span#loaned, span#urlInput').removeClass('errorMsgShow').addClass('hidden');
                $('#modal_form_name, #selectCategory, #inlineRadioOptions, #modal_form_image').css('border', '' );
                $(this).find('form').trigger('reset');
            });
        });
    } catch (err) {
        console.log('addEquipementModal' + err);
    }
});

// edit equipement
$(document).ready(function () {
    try {
        $('button#editEquipement').click(function (e) {

            $.ajax({
                url : '/home',
                data : {"données" : []},
                type : "POST",
                success : function(data){
                    $('.modal-edit').modal('show');
                }
            });
            return false;

            //modal to use
            let btnName = e.target.name;
            //retrieve json information
            let storageName = e.target.id;
            //retrieve equipement object
            // let equipement = objEquipement(storageName, categoryObj);
            // let cardEquipement = equipement[0];
            // let equipementId = equipement[1];
            // let equipementName = equipement[2];
            // let categoryId = equipement[3];
            // let loanedValue;
            // let url = equipement[5];
            // addEquipementModal(categoryObj, btnName);
            let loaned;
            // if (equipement[4] == false) {
            //     loaned = 0;
            //     loanedValue = 'false';
            // } else if (equipement[4] == true) {
            //     loaned = 1;
            //     loanedValue = 'true';
            // }
            //display json information
            // $('h5#equipementNameEdit').html(equipementName);
            // $('input.input1').val(equipementName);
            // $('select option[value="' + categoryId + '"').attr('selected', true);
            // $('input:radio[name=inlineRadioOptions]')[loaned].checked = true;
            // $('input#addURLImage').val(url);
            //open modal
            $('.modal-edit').modal('show');

            //check inputs after changes before submit
            $('form.editForm :input').on('change', function (e) {
                if (e.target.id == 'equipementName' && !e.target.value == '') {
                    $($(this)).css('border', '3px solid green');
                    $('span#equipementName').addClass('hidden');
                    $('span#equipementName').removeClass('errorMsgShow');
                } else if (e.target.id == 'equipementName' && e.target.value == '') {
                    $($(this)).css('border', '3px solid red');
                    $('span#equipementName').removeClass('hidden');
                    $('span#equipementName').addClass('errorMsgShow');
                }

                if (e.target.id == 'selectCategory' && e.target.value != 0) {
                    $($(this)).css('border', '3px solid green');
                    $('span#category').addClass('hidden');
                    $('span#category').removeClass('errorMsgShow');
                } else if (e.target.id == 'selectCategory' && e.target.value == 0) {
                    $($(this)).css('border', '3px solid red');
                    $('span#category').removeClass('hidden');
                    $('span#category').addClass('errorMsgShow');
                }

                if (e.target.name == 'inlineRadioOptions' && e.target.id == 'false') {
                    $('input#false').css('background-color', 'green');
                    $('input#true').css('background-color', '');
                } else if (e.target.name == 'inlineRadioOptions' && e.target.id == 'true') {
                    $('input#true').css('background-color', 'green');
                    $('input#false').css('background-color', '');
                }

                if (e.target.id == 'addURLImage') {
                    if (isUrlImage(e.target.value) == false && e.target.value != '') {
                        $($(this)).css('border', '3px solid red');
                        $('span#url').removeClass('hidden');
                        $('span#url').addClass('errorMsgShow');
                        $('span#url').html('Veuillez entrer une url valide. ex: https://xxxxx.jpg');
                    } else if (e.target.value == '') {
                        $($(this)).css('border', '3px solid red');
                        $('span#url').removeClass('hidden');
                        $('span#url').addClass('errorMsgShow')
                        $('span#url').html('Veuillez entrer une url');
                    } else {
                        $($(this)).css('background-color', 'green');
                        $('span#url').addClass('hidden');
                        $('span#url').removeClass('errorMsgShow')
                    }
                }
            });

            //modified button clicked
            $('.modify').click(function () {

                //retrieve input data
                let newEquipementName = document.getElementById('equipementName').value;
                let newCategoryValue = $('#selectCategory :selected').val();
                let selectLoaned = undefined;
                selectLoaned = $('.form-check-input:checked').val();
                let newUrl = document.getElementById('addURLImage').value;

                if (newEquipementName == '' && newUrl == false && (parseInt(newCategoryValue) == 0 || parseInt(newCategoryValue) == '') && newRadioOptions == undefined) {
                    $('.modal-edit').off();
                    $('.modify').off();
                    $('.modal-edit').modal('hide');
                    $('.modal-edit').on('hidden.bs.modal', function () {
                        $('#formModal').remove();
                        $(this).find('form').trigger('reset');
                    });
                } else if (newEquipementName == equipementName && newUrl == url && parseInt(newCategoryValue) == categoryId && selectLoaned == loanedValue) {
                    $('.modal-edit').off();
                    $('.modify').off();
                    $('.modal-edit').modal('hide');
                    $('.modal-edit').on('hidden.bs.modal', function () {
                        $('#formModal').remove();
                        $(this).find('form').trigger('reset');
                    });
                } else if (!isStrSpaces(newEquipementName)) {
                    $('input.input1').css('border', '3px solid red');
                    $('span#equipementName').removeClass('hidden');
                    $('span#equipementName').addClass('errorMsgShow');
                } else if (newEquipementName == '') {
                    $('input.input1').css('border', '3px solid red');
                    $('span#equipementName').addClass('errorMsgShow');
                    $('span#equipementName').removeClass('hidden');
                } else if (newCategoryValue == '' || newCategoryValue == 0) {
                    $('select#selectCategory').css('border', '3px solid red');
                    $('span#category').removeClass('hidden');
                    $('span#category').addClass('errorMsgShow');
                } else if (selectLoaned == undefined) {
                    $('span#loaned').addClass('errorMsgShow');
                    $('span#loaned').removeClass('hidden');
                } else if (isUrlImage(newUrl) == false) {
                    $('input#addURLImage').css('border', '3px solid red');
                    $('span#url').removeClass('hidden');
                    $('span#url').addClass('errorMsgShow');
                } else if (newEquipementName != equipementName || parseInt(newCategoryValue) != categoryId || selectLoaned != loanedValue || newUrl != url) {
                    let boolValue = (selectLoaned === 'true');
                    //remove old card equipement
                    localStorage.removeItem(cardEquipement);
                    //save edited card equipement
                    const cardObj = { equipementId: equipementId, equipementName: newEquipementName, categoryId: parseInt(newCategoryValue), loaned: boolValue, equipementUrl: newUrl };
                    const cardJSON = JSON.stringify(cardObj);
                    localStorage.setItem(cardEquipement, cardJSON);
                    $('span#empty').addClass('hidden');
                    $('span#empty').removeClass('errorMsgShow');
                    $('.modal-edit').off();
                    $('.modify').off();
                    $('.modal-edit').modal('hide');
                    $('.modal-edit').on('hidden.bs.modal', function () {
                        $('#formModal').remove();
                        $(this).find('form').trigger('reset');
                        location.reload();
                    });
                } else {
                    $('span#equipementName').addClass('hidden');
                    $('span#equipementName').removeClass('errorMsgShow');
                    $('span#category').addClass('hidden');
                    $('span#category').removeClass('errorMsgShow');
                    $('span#radio').removeClass('errorMsgShow');
                    $('span#radio').addClass('hidden');
                    $('span#url').addClass('hidden');
                    $('span#url').removeClass('errorMsgShow');
                }
            });
        });
        $('.close').click(function () {
            $('.modal-edit').off();
            $('.modal-edit').modal('hide');
            $('.modal-edit').on('hidden.bs.modal', function () {
                $('span#equipementName, span#category, span#loaned, span#urlInput').removeClass('errorMsgShow').addClass('hidden');
                $('#modal_form_name, #selectCategory, #inlineRadioOptions, #modal_form_image').css('border', '' );
                $(this).find('form').trigger('reset');
            });
        });
    } catch (err) {
        console.log('editEquiementModal' + err);
    }
});

//remove equipement
$(document).ready(function () {
    $('.btn-trash').click(function (e) {
        //retrieve id of the selected equipement
        let storageName = e.target.id;
        let equipement = //add obj of database
        $('h5#equipementNameTrash').html(equipement[2]);
        $('.modal-trash').modal('show');
        $('.yes').click(function (e) {
            //retrieve id (id = localStorageKey of equipement)
            let id = '';
            id = '#' + equipement[0];
            $(id).remove();
            //remove localStorage
            localStorage.removeItem(equipement[0]);
            $('.modal-trash').off();
            $('.yes').off();
            $('.modal-trash').modal('hide');
            $('.modal-trash').on('hidden.bs.modal', function () {
                $(this).find('form').trigger('reset');
            });
        });
    });

    $('.close').click(function () {
        $('.modal-trash').off();
        $('.yes').off();
        $('.modal-trash').modal('hide');
        $('.modal-trash').on('hidden.bs.modal', function () {
            $(this).find('form').trigger('reset');
        });
    });
});