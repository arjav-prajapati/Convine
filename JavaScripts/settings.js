window.addEventListener('DOMContentLoaded', () => {
  const tabs = document.querySelectorAll('[role="tab"]');
  const tabList = document.querySelector('[role="tablist"]');


  // Add a click event handler to each tab
  tabs.forEach(tab => {
    tab.addEventListener('click', changeTabs);
    if (tab.getAttribute('aria-selected') == 'true') {
      tab.style.color = 'black';
      tab.style.borderBottom = '2px solid #3d5afd';
    }
  });
});

function changeTabs(e) {
  const target = e.target;
  const parent = target.parentNode;
  const grandparent = parent.parentNode;

  // console.log(grandparent);
  // Remove all current selected tabs
  parent
    .querySelectorAll('[aria-selected="true"]').forEach(element => {
      element.setAttribute('aria-selected', false);
      element.style.color = '#7c7c7c';
      element.style.borderBottom = 'none';
    });

  // Set this tab as selected
  target.setAttribute('aria-selected', true);

  // Hide all tab panels
  grandparent
    .querySelectorAll('[role="tabpanel"]')
    .forEach(p => p.setAttribute('hidden', true));

  // Show the selected panel
  grandparent.parentNode
    .querySelector(`#${target.getAttribute('aria-controls')}`)
    .removeAttribute('hidden');


  let tabi = target.getAttribute('tabindex');

  if (target.getAttribute('aria-selected') == 'true') {
    target.style.color = 'black';
    target.style.borderBottom = '2px solid #4f45d3';
    console.log();
  }
}

document.getElementById('name').addEventListener('input', function () {
  let str = document.getElementById('name').value;
  let setremaining = '';

  let length = 30 - str.length;

  if (length < 0) {
    setremaining = 'Your name is greater than 30 characters only accept 30 characters!';
  } else {
    setremaining = length + ' characters remaining';
  }

  document.getElementById('remaining').innerText = setremaining;
})

document.getElementById('about').addEventListener('input', function () {
  let str = document.getElementById('about').value;
  let setremaining = '';

  let length = 255 - str.length;

  if (length < 0) {
    setremaining = 'Your desc. is greater than 255 characters only accept 30 characters!';
  } else {
    setremaining = length + ' characters remaining';
  }

  document.getElementById('about_remaining').innerText = setremaining;
})


let input_block_user = document.getElementById('block_user');

input_block_user.addEventListener('input', function () {
  let input_block_user_length = input_block_user.value.length;

  if (input_block_user_length > 0) {
    document.getElementById('block_user_btn').disabled = false;
    document.getElementById("block_user_btn").style.color = '#4f45d3';
  } else if (input_block_user_length === 0) {
    document.getElementById("block_user_btn").disabled = true;
    document.getElementById("block_user_btn").style.color = '#7c7c7c';
  }
});



let inputimg = document.getElementById('myfile');

let img_input_form = document.getElementById('#imgform');

inputimg.addEventListener('input', function (e) {
  e.preventDefault();

  let imgProperty = this.files[0];
  let img_name = imgProperty.name;
  let img_extention = img_name.split('.').pop().toLowerCase();

  let formData = new FormData(document.getElementById('img_form'));

  formData.append("myfile", imgProperty);

  let xhr = new XMLHttpRequest();
  xhr.open('POST', 'PhpScripts/setImg.php', true);

  xhr.onload = function () {
    let data = this.response;
    document.getElementById('profile_img').src = data;
    document.getElementById('nav_profile_img').src = data;
    // console.log(data);
  }

  xhr.send(formData);

});



document.getElementById('name').addEventListener('focusout', function (e) {
  e.preventDefault();
  let namev = document.getElementById('name').value;



  let xhr = new XMLHttpRequest();

  let params = "Name=" + namev;

  xhr.open('POST', './PhpScripts/settings_changes_script.php', true);
  xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

  xhr.send(params);
});


document.getElementById('about').addEventListener('focusout', function (e) {
  e.preventDefault();
  let aboutv = document.getElementById('about').value;

  let xhr = new XMLHttpRequest();

  let params = "about=" + aboutv;

  xhr.open('POST', './PhpScripts/settings_changes_script.php', true);
  xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

  xhr.send(params);
})

//this code is for changing Email
let modal1 = document.getElementById("myModal1");

// Get the button that opens the modal
document.getElementById("change_email").addEventListener('click', email_change);



function email_change() {
  modal1.style.display = "block";
  modal1.innerHTML = `<div class="modal-header">
  <span id="email_close" class="close">&times;</span>
  <p>Change E-mail</p>
  </div>

  <div class="modal-content">
  <p>Make sure your E-mail is correct.</p>
  <input type="email" name="new_email" id="new_email" required>
  <button type="submit" id="send-otp">Send OTP</button>
  <p id="alert_email"></p>
  </div>`;
  let span = document.querySelector('.close');

  // When the user clicks on <span> (x), close the modal
  span.onclick = function () {
    console.log('click');
    modal1.style.display = "none";
    document.querySelectorAll('input').values = '';
  }

  // When the user clicks anywhere outside of the modal, close it
  window.onclick = function (event) {
    if (event.target == modal1) {
      modal1.style.display = "none";
    }
  }



  document.getElementById('send-otp').addEventListener('click', function (e) {
    e.preventDefault();

    var new_email = document.getElementById('new_email').value;

    if (new_email == '') {
      document.getElementById('alert_email').innerText = 'Email expected!!';
      document.getElementById('alert_email').style.display = 'block';
      console.log('this');
    } else {
      let params = "new-email=" + new_email;

      let xhr = new XMLHttpRequest();
      xhr.open('POST', 'PhpScripts/email_verification_settings.php', true);
      xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
      document.getElementById('alert_email').innerText = 'Please wait!! We are attempting to send you OTP!';
      document.getElementById('alert_email').style.display = 'flex';

      xhr.onload = function () {
        let data = this.responseText;
        document.getElementById('alert_email').style.display = 'block';
        document.getElementById('alert_email').innerText = data;

        if (data == 'Successfull') {
          modal1.innerHTML = `<div class="modal-header">
                                <span id= "email_close" class="close">&times;</span>
                                <p>Change Email</p>
                              </div>

      <div class="modal-content">
          <p>We send you OTP ,please enter OTP here</p>
          <input type="number" name="otp" id="otp" placeholder="Write OTP here to change E-mail" required>
          <button type="submit" id="submit_otp">Change E-mail</button>
          <p id="alert_otp"></p>
      </div>`;



          document.getElementById('submit_otp').addEventListener('click', function (e) {

            if (document.getElementById('otp').value != '') {
              e.preventDefault();
              let get_otp = document.getElementById('otp').value;

              let paramsotp = "userEnter_otp=" + get_otp;

              let xhr = new XMLHttpRequest();
              xhr.open('POST', 'PhpScripts/email_verification_settings.php', true);
              xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

              xhr.onload = function () {
                let data = this.responseText;
                document.getElementById('alert_otp').display = 'block';
                document.getElementById('alert_otp').innerText = data;

                if (data == 'Email Change Successfully!') {
                  document.getElementById('email_hardcorded').innerText = new_email;
                  modal1.style.display = 'none';
                  modal1.innerHTML = `<div class="modal-header">
                  <span id = 'email_close' class="close">&times;</span>
                  <p>Change E-mail</p>
              </div>
      
              <div class="modal-content">
                  <p>Make sure your E-mail is correct.</p>
                  <input type="email" name="new_email" id="new_email" required>
                  <button type="submit" id="send-otp">Send OTP</button>
                  <p id="alert_email">hello</p>
              </div>`
                }
              }

              xhr.send(paramsotp);
            }

          });

        }
      }

      xhr.send(params);
    }


  });



}





//this code is for changing password



document.getElementById("change_pass").addEventListener('click', pass_change);

//this script will change password
function pass_change() {
  modal1.style.display = "block";
  modal1.innerHTML = `<div class="modal-header">
    <span class="close" id = "close">&times;</span>
    <p>Change Password</p>
    </div>

    <div class="modal-content">
    <p>Create New Password.</p>
    <input type="password" name="old_password" id="old_password" placeholder="Write your old Password here" maxlength="8" required>
    <input type="password" name="new_password" id="new_password" placeholder="Write your New Password here" maxlength="8" required>
    <button type="submit" id="new_password_btn">Change Password</button>
    <p id="alert_pass"></p>`;

  let span = document.getElementsByClassName("close")[0];

  // When the user clicks on <span> (x), close the modal
  span.onclick = function () {
    modal1.style.display = "none";
    document.querySelectorAll('input').values = '';
  }

  // When the user clicks anywhere outside of the modal, close it
  window.onclick = function (event) {
    if (event.target == modal1) {
      modal1.style.display = "none";
    }
  }

  document.getElementById('new_password_btn').addEventListener('click', function (e) {
    e.preventDefault();
    console.log('inside');

    let new_pass = document.getElementById('new_password').value;
    let old_pass = document.getElementById('old_password').value;

    if (new_pass != '' && old_pass != '') {
      let params = "new-pass=" + new_pass + "&old-pass=" + old_pass;

      let xhr = new XMLHttpRequest();
      xhr.open('POST', 'PhpScripts/change_pass_script.php', true);
      xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

      xhr.onload = function () {
        let data = this.responseText;
        document.getElementById('alert_pass').style.display = 'block';
        document.getElementById('alert_pass').innerText = data;
        console.log(data);

        if (data == 'Password Change Successfully!') {
          setTimeout(() => {
            modal1.style.display = 'none';
            document.getElementById('alert_pass').style.display = 'none';
          }, 2000);
        }
        document.getElementById('new_password').value = '';
        document.getElementById('old_password').value = '';
      }

      xhr.send(params);
    } else {
      document.getElementById('alert_pass').style.display = 'block';
      document.getElementById('alert_pass').innerText = 'Fields can\'t be empty!';
    }



  });

}


//this script for changing gender

document.getElementById('gender').addEventListener('change', function () {
  let selected_gender = document.getElementById('gender').value;
  let paramsGender = "selected_gender=" + selected_gender;

  let xhr = new XMLHttpRequest();
  xhr.open('POST', 'PhpScripts/settings_changes_script.php', true);
  xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

  xhr.send(paramsGender);
});


//this script for changing country

document.getElementById('country').addEventListener('change', function () {
  let selected_country = document.getElementById('country').value;
  let paramsCountry = "selected_country=" + selected_country;

  let xhr = new XMLHttpRequest();
  xhr.open('POST', 'PhpScripts/settings_changes_script.php', true);
  xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

  xhr.send(paramsCountry);
});


//this is for unblocking users 

let unblock_buttons = document.querySelectorAll('button[name="unblock_user_btn"]');


// let unblock_buttons = document.querySelectorAll('button[name="unblock_user_btn"]');

unblock_buttons.forEach(element => {
  element.addEventListener('click', function () {
    console.log('btn click');
    parent_div = element.parentNode;
    username = parent_div.querySelector('p').innerText;
    let params = "unblocked_username=" + username;

    let xhr = new XMLHttpRequest();
    xhr.open('POST', 'PhpScripts/settings_changes_script.php', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

    xhr.onload = function () {
      let data = this.responseText;

      if (data == "success") {
        parent_div.remove();
      }
    }

    xhr.send(params);
  })
});


document.getElementById('block_user_btn').addEventListener('click', function () {
  let inputval = document.getElementById('block_user').value;
  let blockuser_list_block = document.getElementById('blockuser_list_block');

  let params = "blocked_username=" + inputval;

  let xhr = new XMLHttpRequest();
  xhr.open('POST', 'PhpScripts/settings_changes_script.php', true);
  xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

  xhr.onload = function () {
    let data = this.responseText;

    if(data == "No user found" || data== "Ahh!! you are trying to block yourself!"){
      console.log(data);
      modal1.style.display = "block";
      modal1.innerHTML = `
      <div class="modal-content">
      <p id="alert"></p>
      </div>`;
      document.getElementById('alert').innerText = data;
      setTimeout(() => {
        modal1.style.display = 'none';
      }, 1000);
    }
    
    else{
      let new_block_user = document.createElement('div');
      new_block_user.className = 'block_users';
      new_block_user.innerHTML = data;

      blockuser_list_block.appendChild(new_block_user);
    }
  }

  xhr.send(params);

});


//set or change DOB;

document.getElementById('birthday').addEventListener('change',function(){
  let dob = document.getElementById('birthday').value;
  
  let params = "DOB=" + dob;

  let xhr = new XMLHttpRequest();
  xhr.open('POST', 'PhpScripts/settings_changes_script.php', true);
  xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

  xhr.onload = function () {
    let data = this.responseText;

    console.log(data);
  }

  xhr.send(params);

})

