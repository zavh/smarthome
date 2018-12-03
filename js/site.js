function w3_open() {
    document.getElementById("mySidebar").style.display = "block";
    document.getElementById("myOverlay").style.display = "block";
}
function w3_close() {
    document.getElementById("mySidebar").style.display = "none";
    document.getElementById("myOverlay").style.display = "none";
}

function upActivityCounter(){
    var d = new Date();
    document.getElementById("lastActiveTime").value=d.getTime();
}
//var myVar = setInterval(checkActivity, 300000);

function checkActivity(){
    var lastActivity = document.getElementById("lastActiveTime").value;
    var d = new Date();
    var nowTimeStamp = d.getTime();
    var diff = nowTimeStamp - lastActivity;
    if(diff>600000){
        if (typeof iam !== 'undefined') {
            window.close();
        }
    }
    if(diff>900000){
        window.location.assign("http://localhost:8080/emapp/logout.php")}
    console.log(lastActivity+" - "+nowTimeStamp+" And difference is "+diff);
}
function inputFocus(el){
	el.parentElement.classList.add('focused');
}
function inputBlur(el){
	var inputVal = el.value;
	if(inputVal == '')
		el.parentElement.classList.remove('focused');
}
