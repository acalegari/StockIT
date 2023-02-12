/*
Check
input type="text" id="username" name="username"
&
input type="password" id="password" name="password"
*/

let userN;
let pwd;

//Check password validity
function verifyPassword() {

    //pwd value
    pwd = document.getElementById('password').value;
    //check if input is empty
    if(pwd == "") {
        document.getElementById("message").innerHTML="Veuillez entrer un password.";
        return false;
    }
    
    //RegExp password
    let checkChar = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9])(?!.*\s).{8,}$/;
    //check if password policy is respected
    if (pwd.search(checkChar)) {
        document.getElementById("message").innerHTML="The password must contain at least 8 characters, 1 uppercase, 1 lowercase and 1 special character.";
        return false;
    }
}

function verifyUserName() {
    //userName value
    userN = document.getElementById('username').value;
    console.log(userN);
    //check if input is empty
    if(userN == "") {
        document.getElementById("message").innerHTML="Veuillez entrer un username.";
        return false;
    }
}

/* FIND SOLUTION FOR EMPTY FIELD FUNCTION
function checkEmptyInput(input,message) {
    
    let pwdMessage = "Veuillez entrer un password.";
    checkEmptyInput(pwd,pwdMessage); 

    if (input == "") {
        document.getElementByclassName("#message").innerHTML=message;
        return false;
    }
}
*/


