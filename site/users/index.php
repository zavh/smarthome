<?php
	include("../../config/serverconfig.php");
	include(TEMPLATEDIR."/header.php");
	include(TEMPLATEDIR."/mainmenu.php");
?>
<div class="w3-gray w3-row" style="min-height:100vh">
	<!-- Top Menu Starts-->
	<?php
		$pagetitle = "User Management";
		include(TEMPLATEDIR."/topmenu.php");
	?>
	<!-- Top Menu Ends-->
	<div class="w3-row w3-center w3-margin">
		<div class="w3-col m12 l4 w3-tiny">
		<!-- New User Creation Form Starts-->
		<?php if($_SESSION['level']>9) {?>
			<form
				class="w3-margin w3-card w3-round-xxlarge w3-white"
				style="overflow:hidden"
				method="POST"
				action="userpost.php"
				onsubmit="return userAjaxFunction('newUserPost', '', '')">
			<div class="w3-container w3-sand w3-center">
			  <p>Create New User</p>
			</div>
			  <input type='hidden' id='uid-flag' value=0>
				<div class="w3-row form-group" id='uiddiv'>
					<div class='w3-col' style='width: calc(100% - 34px);'>
						<label class="form-label" for="uid">Insert Username</label>
					  <input
							class="form-input"
							type="email"
							name="uid"
							id="uid"
							onkeyup="validateEmail(this)"
							onfocus='inputFocus(this)'
							onblur ='inputBlur(this)'
							style='outline: none;'
							required>
					</div>
					<div class='w3-col' style='width:34px;display:none' id='uid-success'>
							<span class='w3-text-green w3-tiny w3-center dot-large' style='vertical-align:middle;'>&#10004;</span>
					</div>
				</div>
			  <div class="w3-row form-group">
					<div class='w3-col' style='width: calc(100% - 34px);'>
						<label class="form-label" for="newUserPass">Insert Password</label>
						<input
							class="form-input"
							type="password"
							name="pwd"
							id="pwd"
							onkeyup = 'validatePassCriteria(this)'
							pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
							onfocus='passCriteriaVars("new");showMsgDiv("passwordDetector-1");inputFocus(this)'
							onblur = 'hideMsgDiv("passwordDetector-1");inputBlur(this)'
							required
							>
					</div>
					<div class='w3-col' style='width:34px;display:none' id='pwd-success'>
							<span class='w3-text-green w3-tiny w3-center dot-large' style='vertical-align:middle;'>&#10004;</span>
					</div>
				</div>
				<div class='w3-row' style='display:none;top:0' id='passwordDetector-1'>
					<div id='new-capital' class='w3-quarter invalid'>1 Uppercase</div>
					<div id='new-letter' class='w3-quarter invalid'>1 Lowercase</div>
					<div id='new-number' class='w3-quarter invalid'>1 Number</div>
					<div id='new-length' class='w3-quarter invalid'>8 characters</div>
				</div>

				<input type='hidden' id='newUserPassRetype-flag' value=0>
				<div class="w3-row form-group" id='newPassRetypeDiv'>
					<div class='w3-col' style='width: calc(100% - 34px);'>
						<label class="form-label" for="newUserPassRetype">Re-type Password</label>
						<input
							class="form-input"
							type="password"
							id="newUserPassRetype"
							onkeyup = 'passChangeValidate(this, "pwd","newUserPassRetype")'
							onfocus='inputFocus(this)'
							onblur ='inputBlur(this)'
							required>
					</div>
					<div class='w3-col' style='width:34px;display:none' id='newUserPassRetype-success'>
							<span class='w3-text-green w3-tiny w3-center dot-large' style='vertical-align:middle;'>&#10004;</span>
					</div>
			  </div>
			  <div class="w3-row form-group">
					<div class='w3-col' style='width: calc(100% - 34px);'>
						<label class="form-label" for="level">Insert User Level</label>
						<input
							class="form-input"
							type="number"
							id="level"
							name="level"
							min='1' max='10'
							onkeyup = 'levelValidate(this)'
							onfocus='inputFocus(this)'
							onblur ='inputBlur(this)'
							required>
					</div>
					<div class='w3-col' style='width:34px;display:none' id='level-success'>
							<span class='w3-text-green w3-tiny w3-center dot-large' style='vertical-align:middle;'>&#10004;</span>
					</div>
				</div>
			  <p class="w3-row w3-center w3-tiny"><button type="submit">GO</button></p>
			  <input type='hidden' name='command' value='newuser'>
			</form>
		<?php }?>
		<!-- New User Creation Form Ends-->
		<!-- Change Password Form Starts-->
			<form
				class="w3-margin w3-card w3-round-xxlarge w3-white"
				style="overflow:hidden"
				id='changePassForm'
				onsubmit="return userAjaxFunction('postPassChange', '', '')">
			<div class="w3-container w3-sand w3-center">
			  <p>Change Password</p>
			</div>
			  <!-- <label>Username</label></p> -->
				<div class="w3-row form-group">
						<label class="form-label" for="existing_password">Insert Current Password</label>
						<input
							class="form-input"
							type="password"
							name="existing_password"
							id="existing_password"
							onfocus='inputFocus(this)'
							onblur ='inputBlur(this)'
							required
							>
				</div>
				<div class="w3-row form-group">
					<div class='w3-col' style='width: calc(100% - 34px);'>
						<label class="form-label" for="newpassword">Insert Password</label>
						<input
							class="form-input"
							type="password"
							name="newpassword"
							id="newpassword"
							onkeyup = 'validatePassCriteria(this)'
							pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
							onfocus='passCriteriaVars("change");showMsgDiv("passwordDetector-2");inputFocus(this)'
							onblur = 'hideMsgDiv("passwordDetector-2");inputBlur(this)'
							required
							>
					</div>
					<div class='w3-col' style='width:34px;display:none' id='newpassword-success'>
							<span class='w3-text-green w3-tiny w3-center dot-large' style='vertical-align:middle;'>&#10004;</span>
					</div>
				</div>
				<div class='w3-row' style='display:none;top:0' id='passwordDetector-2'>
					<div id='change-capital' class='w3-quarter invalid'>1 Uppercase</div>
					<div id='change-letter' class='w3-quarter invalid'>1 Lowercase</div>
					<div id='change-number' class='w3-quarter invalid'>1 Number</div>
					<div id='change-length' class='w3-quarter invalid'>8 characters</div>
				</div>
				<!-- <label>Password</label> -->
				<input type='hidden' id='verifynew-flag' value=0>
				<div class="w3-row form-group" id='vndiv'>
					<div class='w3-col' style='width: calc(100% - 34px);'>
						<label class="form-label" for="verifynew">Re-enter New Password</label>
						<input
							class="form-input"
							type="password"
							name="newpassword"
							id="verifynew"
							onkeyup = 'passChangeValidate(this, "newpassword","verifynew")'
							onfocus='passCriteriaVars("change");inputFocus(this)'
							onblur = 'inputBlur(this)'
							required
							>
					</div>
					<div class='w3-col' style='width:34px;display:none' id='verifynew-success'>
							<span class='w3-text-green w3-tiny w3-center dot-large' style='vertical-align:middle;'>&#10004;</span>
					</div>
				</div>
			  <p class="w3-row w3-center w3-tiny"><button type='submit'>GO</button></p>
			</form>
			<!-- Change Password Form Ends-->
		</div>
		<?php if($_SESSION['level']>9){?>
		<div class="w3-col m12 l4 w3-tiny">
			<div class="w3-margin w3-card w3-round-xxlarge" style="overflow:hidden">
					<div class="w3-container w3-pale-red w3-center">
					  <p>Manage Users</p>
					</div>
				<div id='userlist'>
					<?php include("userlist.php")?>
				</div>
			</div>
		</div>
	<?php }?>
	</div>
	<input type='hidden' id='errmsg' value='0'>
	<div id="snackbar"></div>
</div>
<?php
	include(TEMPLATEDIR."/footer.php");
?>
<script src="<?php echo JSDIR;?>/snackbar.js?version=1.0"></script>
<script src="<?php echo JSDIR;?>/users.js?version=0.1"></script>
<style>
/* Style all input fields */

/* The message box is shown when the user clicks on the password field */
/* Add a green text color and a checkmark when the requirements are right */
.valid {
    color: green;
}

.valid:before {
    position: relative;
    left: -10px;
    content: "✔";
}

/* Add a red text color and an "x" when the requirements are wrong */
.invalid {
    color: red;
}

.invalid:before {
    position: relative;
    left: -10px;
    content: "✖";
}
</style>
