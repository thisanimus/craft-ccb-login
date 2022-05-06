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

        composer require thisanimus/craft-ccb-login

3. In the Control Panel, go to Settings → Plugins and click the “Install” button for craft-ccb-login.

## Configuration

In the Craft Control Panel, enter your CCB API User Credentials.  These will be used to make the necessary API requests.

## Overview

- User submits a username and password through a form on the front end of your site.
- The plugin passes those creds to the "individual_profile_from_login_password" service of the [CCB API](https://designccb.s3.amazonaws.com/helpdesk/files/official_docs/api.html).
- If the user exists in CCB, the plugin then fetches the user's profile, and the IDs of the groups this person is a part of.
- The plugin sets the authentication status and the user information as session variables.

#### Successful Login
```php
$_SESSION = [
	'ccb_authenticated':true,
	'ccb_individual'=>[/* The whole CCB Individual Response */],
	'ccb_groups'=>[1,5,34,388]
];
```

#### Unsuccessful Login
```php
$_SESSION = [
	'ccb_authenticated':false,
	'ccb_error'=>'Whatever error the CCB API throws'
];
```

#### Session Vars
Access the session vars in your template using the included plugin twig var:
```html
{{ dump(craft.ccblogin.userSession) }}
```
This gives you access to a user's authentication status, profile info, and group memberships.  You can use these as conditions when determining what gets rendered in the twig template. 


## Twig Templates

Here are some templates to get you started:

#### Login
```html
<form id="craftLogin" method="post" accept-charset="UTF-8">
	{{ csrfInput() }}
	<input type="hidden" name="action" value="ccb-login/default/">
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
	<input type="hidden" name="action" value="ccb-login/default/">
	<input type="hidden" name="formLogout" value="true">
	<input type="submit" value="Logout">
</form>
```


#### Conditional Markup with CCB Login Sync

```html
{% set session = craft.ccblogin.userSession %}

{% if session.ccb_authenticated == false %}
	{% if session.error is defined %}
		<div class="alert">
			{{ session.error }}
		</div>
	{% endif %}
	<form id="craftLogin" method="post" accept-charset="UTF-8">
		{{ csrfInput() }}
		<input type="hidden" name="action" value="ccb-login/default/">
		<label>Username</label>
		<input type="text" name="formLogin" value="" placeholder="username">
		<label>Password</label>
		<input type="password" name="formPassword" value="" placeholder="password">
		<input type="checkbox" name="formCCB" value="1">
		<label style="display:inline-block;">Log me in to Community.</label>
		<p>
			This will open a new tab and log you in to Church Community Builder at the same time you are being logged into this website.
		</p>
		<input type="submit" value="Login">
	</form>
	{% if session.ccb_error is defined %}
		<div class="alert warning">
			<p>{{ session.ccb_error }}</p>
		</div>
	{% endif %}
	<br>
	<a href="https://yourChurchName.ccbchurch.com/w_password.php">Forgot Password?</a><br>
	<a href="https://yourChurchName.ccbchurch.com/w_sign_up.php">Sign Up</a>

	<form style="display:none" id="ccbLogin" action="https://yourChurchName.ccbchurch.com/login.php" method="post" target="_blank">
		<input type="hidden" name="ax" value="login">
		<input type="text" name="form[login]" value="">
		<input type="password" name="form[password]" value="">
		<input type="submit" value="Login">
	</form>

{% elseif session.ccb_authenticated == true %}

	<img src="{{ session.ccb_individual.image }}"/>
	<h1>{{ session.ccb_individual.full_name }}</h1>
	{% if session.ccb_groups|length > 0 %}
		<h3>Group IDs:</h3>
		<ul>
			{% for group in session.ccb_groups %}
				<li>{{ group }}</li>
			{% endfor %}
		</ul>
	{% endif %}

	<form method="post" accept-charset="UTF-8">
		{{ csrfInput() }}
		<input type="hidden" name="action" value="ccb-login/default/">
		<input type="hidden" name="formLogout" value="true">
		<input type="submit" value="Logout">
	</form>

{% endif %}

{% js at endBody %}

// get the forms
const craftLogin = document.getElementById('craftLogin');
const cbbLogin = document.getElementById('ccbLogin');
var time = 0;

// on craft form submit, prevent the default behavior
craftLogin.addEventListener('submit', function(e){
	e.preventDefault();

	// get login input values from the craft form
	let login = craftLogin.querySelector('input[name="formLogin"]').value;
	let password = craftLogin.querySelector('input[name="formPassword"]').value;
	
	if(craftLogin.querySelector('input[name="formCCB"]').checked == true){
		// give a little bit of time for the ccb form submission
		var time = 1000;
		ccbLogin.querySelector('input[name="form[login]"]').value = login;
		ccbLogin.querySelector('input[name="form[password]"]').value = password;
		ccbLogin.submit();
	}
	setTimeout(function(){ 
		craftLogin.submit(); 
	}, time);
	
});

{% endjs %}
```




## Credits

Praise and rotten tomatoes alike may be lobbed at [Andrew Hale](https://thisanimus.com).
