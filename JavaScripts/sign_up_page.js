let sign_up_btn = document.getElementById('signup_button');
sign_up_btn.addEventListener('click',community_list);   //click event listner to covert inputs(text) to input(checkbox)
 
let inputs = document.getElementsByTagName('input');


function community_list() {                    
    let logincontainer = document.querySelector('div.login_container');   //  this 
    logincontainer.removeChild(sign_up_btn);                              //  code 
    console.log('hello');                                                 //  will delete 
                                                                          //  all 
    while (logincontainer.firstChild) {                                   //  child
        logincontainer.removeChild(logincontainer.lastChild);             //  elements
    }

    createChildElements();          //this function will add checkbox in a same html doc.
}

function createChildElements(){
    
}
 