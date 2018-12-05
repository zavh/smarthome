
var letter = null;
var capital = null;
var number = null;
var length =  null;

function passCriteriaVars(prefix){
  letter = document.getElementById(prefix+"-letter");
  capital = document.getElementById(prefix+"-capital");
  number = document.getElementById(prefix+"-number");
  length = document.getElementById(prefix+"-length");
}

function showMsgDiv(divid){
	document.getElementById(divid).style.display = "block";
}
function hideMsgDiv(divid){
	document.getElementById(divid).style.display = "none";
}

function deleteUser(table_id, user_name){

	// var r = confirm("Confirm deletion of user "+user_name);
	// if (r == true) {
		userAjaxFunction('deleteuser', table_id, 'userlist');
	//}
	//else return;
}

function changeLevel(input, originput, table_id, e){
	var x = e.which;
	if(x == 13){
		origval = parseInt(document.getElementById(originput).value);
		newval = parseInt(document.getElementById(input).value);
		if(origval == newval) {
			alert('No change in User Level!');
			return;
		}
		else if(newval<1 || newval>10 || !Number.isInteger(newval)){
			alert('User Level should be between 1 and 10');
			return;
		}
		else {
			userAjaxFunction('changelevel', newval+"|"+table_id+"|"+input, 'userlist');
		}
	}
}

function userAjaxFunction(instruction, execute_id, divid){
	var ajaxRequest;  // The variable that makes Ajax possible!
		try{
				ajaxRequest = new XMLHttpRequest();
		} catch (e){
				try{
						ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
				} catch (e) {
						try{
								ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
						} catch (e){
								alert("Your browser broke!");
								return false;
						}
				}
		}
		ajaxRequest.onreadystatechange = function(){
				if(ajaxRequest.readyState == 4 && ajaxRequest.status == 200){
          if(instruction=="changelevel"){
						document.getElementById("errmsg").value = ajaxRequest.responseText;
						msgInASnackbar();
						var status = ajaxRequest.responseText.split("|");
						if(parseInt(status[1])<100){
							document.getElementById(config[2]).value = document.getElementById("orig-"+config[2]).value;
							return;
						}
						else userAjaxFunction('refreshList', '', 'userlist');
          }
					if(instruction=="deleteuser"){
						document.getElementById("errmsg").value = ajaxRequest.responseText;
						msgInASnackbar();
						userAjaxFunction('refreshList', '', 'userlist');
          }
					if(instruction=="resetpass"){
						document.getElementById("errmsg").value = ajaxRequest.responseText;
						msgInASnackbar();
						return;
					}
          if(instruction=="postPassChange"){
						document.getElementById("errmsg").value = ajaxRequest.responseText;
						msgInASnackbar();
            var status = ajaxRequest.responseText.split("|");
            if(parseInt(status[1])>100){
              setTimeout(function(){
                window.location.assign("../../logout.php") },
                2000);
            }
						else return;
					}
          if(instruction=="newUserPost"){
            document.getElementById("errmsg").value = ajaxRequest.responseText;
            msgInASnackbar();
            var status = ajaxRequest.responseText.split("|");
            if(parseInt(status[1])>100){
              userAjaxFunction('refreshList', '', 'userlist');
            }
            else return;
          }
            if(divid!=''){
              var ajaxDisplay = document.getElementById(divid);
              ajaxDisplay.innerHTML = ajaxRequest.responseText;
            }
				}
	   	}
      if(instruction == "newUserPost"){
        var uidflag = document.getElementById('uid-flag').value;
        var passverflag = document.getElementById('newUserPassRetype-flag').value;
        if(uidflag==0){
          alert("No valid email address format detected");
          document.getElementById('uiddiv').classList.remove('form-group');
          document.getElementById('uiddiv').classList.add('form-group-erred');
          setTimeout(
            function(){
              document.getElementById('uiddiv').classList.remove('form-group-erred');
              document.getElementById('uiddiv').classList.add('form-group');
            }, 3000);
          return false;
        }
        if(passverflag==0){
          alert("Retyped password does not match the user password");
          document.getElementById('newPassRetypeDiv').classList.remove('form-group');
          document.getElementById('newPassRetypeDiv').classList.add('form-group-erred');
          setTimeout(
            function(){
              document.getElementById('newPassRetypeDiv').classList.remove('form-group-erred');
              document.getElementById('newPassRetypeDiv').classList.add('form-group');
            }, 3000);
          return false;
        }
        var level = document.getElementById("level").value;
        var uid = document.getElementById("uid").value;
        var pwd = document.getElementById("pwd").value;
        ajaxRequest.open("POST", "userpost.php", true);
        ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        ajaxRequest.send("command=newuser&level="+level+"&uid="+uid+"&pwd="+pwd);
        return false;
			}
	    if(instruction == "changelevel"){
				var config = execute_id.split("|");
				execute_id = config[0]+"|"+config[1];
        ajaxRequest.open("POST", "userpost.php", true);
        ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        ajaxRequest.send("command=changelevel&config="+execute_id);
			}
	    if(instruction == "resetpass"){
        ajaxRequest.open("POST", "userpost.php", true);
        ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        ajaxRequest.send("command=resetpass&table_id="+execute_id);
    	}
			if(instruction == "refreshList"){
				ajaxRequest.open("POST", "userlist.php", true);
				ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
				ajaxRequest.send();
			}
			if(instruction == "deleteuser"){
        ajaxRequest.open("POST", "userpost.php", true);
        ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        ajaxRequest.send("command=deleteuser&table_id="+execute_id);
    	}
      if(instruction == "postPassChange"){
        var dec1 = document.getElementById('verifynew-flag').value;
        if(dec1==0){
          alert("New password and Re-entered password didn't match.");
          document.getElementById('vndiv').classList.remove('form-group');
          document.getElementById('vndiv').classList.add('form-group-erred');
          setTimeout(
            function(){
              document.getElementById('vndiv').classList.remove('form-group-erred');
              document.getElementById('vndiv').classList.add('form-group');
            }, 3000);
          return false;
        }
        else {
          var existing_password = document.getElementById("existing_password").value;
          var newpassword = document.getElementById("newpassword").value;
          ajaxRequest.open("POST", "userpost.php", true);
          ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
          ajaxRequest.send("command=changepasswd&existing_password="+existing_password+"&newpassword="+newpassword);
          return false;
        }
      }
}
function validateEmail(el) {
	var emailsuccess = document.getElementById(el.id+"-success")
  var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
	var status = re.test(String(el.value).toLowerCase());
  if(status)
    document.getElementById(el.id+"-flag").value=1;
  else
    document.getElementById(el.id+"-flag").value=0;
	inputValidationStatus("uid", status);
}

function validatePassCriteria(passfield) {
	var smallLetterCriteria = false;
  var upLetterCriteria = false;
	var numberCriteria = false;
	var lengthCriteria = false;

  // Validate lowercase letters
  var lowerCaseLetters = /[a-z]/g;
  if(passfield.value.match(lowerCaseLetters)) {
    letter.classList.remove("invalid");
    letter.classList.add("valid");
		smallLetterCriteria = true;
  } else {
    letter.classList.remove("valid");
    letter.classList.add("invalid");
		smallLetterCriteria = false;
  }

  // Validate capital letters
  var upperCaseLetters = /[A-Z]/g;
  if(passfield.value.match(upperCaseLetters)) {
    capital.classList.remove("invalid");
    capital.classList.add("valid");
		upLetterCriteria = true;
  } else {
    capital.classList.remove("valid");
    capital.classList.add("invalid");
		upLetterCriteria = false;
  }

  // Validate numbers
  var numbers = /[0-9]/g;
  if(passfield.value.match(numbers)) {
    number.classList.remove("invalid");
    number.classList.add("valid");
		numberCriteria = true;
  } else {
    number.classList.remove("valid");
    number.classList.add("invalid");
		numberCriteria = false;
  }

  // Validate length
  if(passfield.value.length >= 8) {
    length.classList.remove("invalid");
    length.classList.add("valid");
		lengthCriteria = true;
  } else {
    length.classList.remove("valid");
    length.classList.add("invalid");
		lengthCriteria = false;
  }

	var status = false;
	if(smallLetterCriteria && upLetterCriteria && numberCriteria && lengthCriteria)
		status = true;
	inputValidationStatus(passfield.id, status);
}
function levelValidate(el){
  var level = parseInt(el.value);
  var status = false;
  if(level>1 && level<11)
    status = true;
  inputValidationStatus(el.id, status);
}
function passChangeValidate(el, pass, verifier){
	status = reEnterVerify(pass, verifier);
	if(status==1){
    inputValidationStatus(el.id, true);
    document.getElementById(el.id+"-flag").value=1;
  }
	else{
    inputValidationStatus(el.id, false);
    document.getElementById(el.id+"-flag").value=0;
  }

}

function inputValidationStatus(inputid, status){
	var statusId = inputid+'-success';
	if(status)
		document.getElementById(statusId).style.display = "";
	else
		document.getElementById(statusId).style.display = "none";
}

function reEnterVerify(pass, verifier){
	var newpass = document.getElementById(pass).value;
	var verpass = document.getElementById(verifier).value;

	var status = 0;
	if(newpass == verpass){
		status = 1;
	}
	return status;
}
