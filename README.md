# CCB API Authentication for Craft CMS 3.x

A session-based login for Craft CMS 3.X that authenticates users via the Church Community Builder API.

![Screenshot](resources/img/plugin-logo.png)

## Requirements

This plugin requires Craft CMS 3.0.0-beta.23 or later.

## Installation

To install the plugin, follow these instructions.

1. Open your terminal and go to your Craft project:

        cd /path/to/project

2. Then tell Composer to load the plugin:

        composer require countrysidebible/craft-ccb-login

3. In the Control Panel, go to Settings → Plugins and click the “Install” button for craft-ccb-login.

## Configuration

In the Craft Control Panel, enter your CCB API User Credentials.  These will be used to make the necessary API requests.

## Overview

- User submits a username and password through a form on the front end of your site.
- The plugin passes those creds to the "individual_profile_from_login_password" service of the CCB API.
- If the user exists in CCB, the plugin then fetches the groups this person is a part of, their name, and profile picture.
- The plugin sets the authentication status and the user information as session variables.

#### Successful Login
```php
$_SESSION = [
	'authenticated':true,
	'id'=>1,
	'name'=>'Firstname McLastnamerson',
	'image'=>'https://https://ccbchurch.s3.amazonaws.com/r09r823098230948etcetcetc',
	'groups'=>[1,5,34,388]
];
```

#### Unsuccessful Login
```php
$_SESSION = [
	'authenticated':false,
	'error'=>'Whatever error the CCB API throws'
];
```

#### Session Vars
Access the session vars in your template using the included plugin twig var:
```html
{{ dump(craft.craftccblogin.userSession) }}
```
This gives you access to a user's authentication status and group memberships.  You can use these as conditions when determining what gets rendered in the twig template. 


## Twig Templates

Here are some templates to get you started:

#### Login
```html
<form id="craftLogin" method="post" accept-charset="UTF-8">
	{{ csrfInput() }}
	<input type="hidden" name="action" value="craft-ccb-login/default/">
	<label>Username</label>
	<input type="text" name="formLogin" value="">
	<br />
	<label>Password</label>
	<input type="password" name="formPassword" value="">
	<br />
	<input type="submit" value="Login">
</form>
	
<a href="https://yourChurchName.ccbchurch.com/w_password.php">Forgot Password?</a>
<a href="https://yourChurchName.ccbchurch.com/w_sign_up.php">Sign Up</a>
```

#### Logout
```html
<form method="post" accept-charset="UTF-8">
	{{ csrfInput() }}
	<input type="hidden" name="action" value="craft-ccb-login/default/">
	<input type="hidden" name="formLogout" value="true">
	<input type="submit" value="Logout">
</form>
```

## Login Synchronization
If you like, you can include the CCB login form alongside the session login:

```html
<h1>Session</h1>
{{ dump(craft.craftccblogin.userSession) }}


<h1>Login</h1>

<form id="craftLogin" method="post" accept-charset="UTF-8">
	{{ csrfInput() }}
	<input type="hidden" name="action" value="craft-ccb-login/default/">
	<label>Username</label>
	<input type="text" name="formLogin" value="">
	<br />
	<label>Password</label>
	<input type="password" name="formPassword" value="">
	<br />
	<label>Log me in to Community too.</label>
	<input type="checkbox" name="formCCB" value="1"><br />
	Checking this box will open a new tab and automatically log you in to Church Community Builder.
	<br />
	<input type="submit" value="Login">
</form>

<a href="https://yourChurchName.ccbchurch.com/w_password.php">Forgot Password?</a>
<a href="https://yourChurchName.ccbchurch.com/w_sign_up.php">Sign Up</a>


<h1>Log Out</h1>

<form method="post" accept-charset="UTF-8">
	{{ csrfInput() }}
	<input type="hidden" name="action" value="craft-ccb-login/default/">
	<input type="hidden" name="formLogout" value="true">
	<input type="submit" value="Logout">
</form>

<form style="display:none" id="ccbLogin" action="https://yourChurchName.ccbchurch.com/login.php" method="post" target="_blank">
	<input type="hidden" name="ax" value="login">
	<input type="text" name="form[login]" value="">
	<input type="password" name="form[password]" value="">
	<input type="submit" value="Login">
</form>

{% js %}

// get the forms
const craftLogin = document.getElementById('craftLogin');
const cbbLogin = document.getElementById('ccbLogin');

// on craft form submit, prevent the default behavior
craftLogin.addEventListener('submit', function(e){
	e.preventDefault();

	// get login input values from the craft form
	let login = craftLogin.querySelector('input[name="formLogin"]').value;
	let password = craftLogin.querySelector('input[name="formPassword"]').value;
	
	if(craftLogin.querySelector('input[name="formCCB"]').checked == true){
		// give a little bit of time for the ccb form submission
		let time = 1000;
		ccbLogin.querySelector('input[name="form[login]"]').value = login;
		ccbLogin.querySelector('input[name="form[password]"]').value = password;
		ccbLogin.submit();
	}else{
		let time = 0;
	}
	setTimeout(function(){ 
		craftLogin.submit(); 
	}, time);
	
});

{% endjs %}
```




## craft-ccb-login Roadmap

Some things to do, and ideas for potential features:

* Release it

Brought to you by [Andrew Hale](thisanimus.com)
