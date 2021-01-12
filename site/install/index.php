<?php

error_reporting(0); //Setting this to E_ALL showed that that cause of not redirecting were few blank lines added in some php files.

$db_config_path = '../application/config/database.php';

// Only load the classes in case the user submitted the form
if($_POST) {

	// Load the classes and create the new objects
	require_once('includes/core_class.php');
	require_once('includes/database_class.php');

	$core = new Core();
	$database = new Database();

    function delete_files($target) {
        if(is_dir($target)){
            $files = glob( $target . '*', GLOB_MARK ); //GLOB_MARK adds a slash to directories returned

            foreach( $files as $file ){
                delete_files( $file );
            }

            rmdir( $target );
        } elseif(is_file($target)) {
            unlink( $target );
        }
    }
	// Validate the post data
	if($core->validate_post($_POST) == true)
	{
		// First create the database, then create tables, then write config file
		if($database->create_database($_POST) == false) {
			$message = $core->show_message('error',"The database could not be created, please verify your settings.");
		} else if ($database->create_tables($_POST) == false) {
			$message = $core->show_message('error',"The database tables could not be created, please verify your settings.");
        } else if ($database->create_user($_POST) == false) {
            $message = $core->show_message('error',"The user account could not be created, please verify your settings.");
		} else if ($core->write_config($_POST) == false) {
			$message = $core->show_message('error',"The database configuration file could not be written, please chmod application/config/database.php file to 777");
		}

		// If no errors, redirect to registration page
		if(!isset($message)) {
		    $redir = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ? "https" : "http");
            $redir .= "://".$_SERVER['HTTP_HOST'];
            $redir .= str_replace(basename($_SERVER['SCRIPT_NAME']),"",$_SERVER['SCRIPT_NAME']);
            $redir = str_replace('install/','',$redir);

            delete_files('../install');

			header( 'Location: ' . $redir . 'login' ) ;
		}

	}
	else {
		$message = $core->show_message('error','Not all fields have been filled in correctly. The host, username, password, and database name are required.');
	}
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PulseISP - Installation Wizard</title>

    <!-- CSS -->
    <link rel="stylesheet" href="../assets/plugins/bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="../assets/plugins/fontawesome-free/css/fontawesome.min.css">
    <link rel="stylesheet" href="assets/css/form-elements.css">
    <link rel="stylesheet" href="assets/css/style.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

<!-- Top content -->
<div class="top-content">
    <div class="container">

        <div class="divElement">
            <div class="form-box" style="width: 500px">
                <?php if(is_writable($db_config_path)){?>

                    <?php if(isset($message)) {echo '<p class="error">' . $message . '</p>';}?>

                    <form id="install_form" role="form" class="f1" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <h3>Setup Wizard</h3>
                    <p></p>
                    <div class="f1-steps">
                        <div class="f1-progress">
                            <div class="f1-progress-line" data-now-value="16.66" data-number-of-steps="3" style="width: 16.66%;"></div>
                        </div>
                        <div class="f1-step active">
                            <div class="f1-step-icon"><i class="fa fa-database"></i></div>
                            <p>database</p>
                        </div>
                        <div class="f1-step">
                            <div class="f1-step-icon"><i class="fa fa-key"></i></div>
                            <p>account</p>
                        </div>
                        <div class="f1-step">
                            <div class="f1-step-icon"><i class="fa fa-eye"></i></div>
                            <p>readme</p>
                        </div>
                    </div>

                    <fieldset>
                        <h4>Database Settings</h4>
                        <div class="form-group">
                            <label class="sr-only" for="hostname">Hostname</label>
                            <input type="text" id="hostname" value="localhost" class="f1-first-name form-control" name="hostname" placeholder="Database URL" />
                        </div>
                        <div class="form-group">
                            <label class="sr-only" for="username">Username</label>
                            <input type="text" id="username" class="f1-last-name form-control" name="username" placeholder="Username" />
                        </div>
                        <div class="form-group">
                            <label class="sr-only" for="password">Password</label>
                            <input type="password" id="password" class="f1-password form-control" name="password" placeholder="Password" />
                        </div>
                        <div class="form-group">
                            <label class="sr-only" for="database">Database name</label>
                            <input type="text" id="database" class="f1-last-name form-control" name="database" placeholder="Database Name" />
                        </div>
                        <div class="f1-buttons">
                            <button type="button" class="btn btn-next">Next</button>
                        </div>
                    </fieldset>

                    <fieldset>
                        <h4>Set up your account:</h4>
                        <div class="form-group">
                            <label class="sr-only" for="firstname">Name</label>
                            <input type="text" name="firstname" placeholder="Name..." class="f1-name form-control" id="firstname">
                        </div>
                        <div class="form-group">
                            <label class="sr-only" for="lastname">Surname</label>
                            <input type="text" name="lastname" placeholder="Surname..." class="f1-surname form-control" id="lastname">
                        </div>

                        <div class="form-group">
                            <label class="sr-only" for="email">Email</label>
                            <input type="text" name="email" placeholder="Email..." class="f1-email form-control" id="email">
                        </div>
                        <div class="form-group">
                            <label class="sr-only" for="usr-password">Password</label>
                            <input type="password" name="usr-password" placeholder="Password..." class="f1-password form-control" id="usr-password">
                        </div>
                        <div class="f1-buttons">
                            <button type="button" class="btn btn-previous">Previous</button>
                            <button type="button" class="btn btn-next">Next</button>
                        </div>
                    </fieldset>

                    <fieldset>
                        <h4>Terms and Conditions</h4>

                        <div class="form-group">
                            <p>
                                Disclaimer: Testing Phase</br></br>
                                TODO : rework the detection mode for installation redirect -</br>
                                Check if database exists</br>
                                Check if config variable exists "app_installed = false"</br>
                                Check if installation directory exists</br>
                                REDIRECT TO INSTALL
                            </p>
                        </div>

                        <div class="f1-buttons">
                            <button type="button" class="btn btn-previous">Previous</button>
                            <button type="submit" id="submit" class="btn btn-submit">Start Install</button>
                        </div>
                    </fieldset>



                    </form>


                <?php } else { ?>
                    <p class="error">Please make the application/config/database.php file writable. <strong>Example</strong>:<br /><br /><code>chmod 777 application/config/database.php</code></p>
                <?php } ?>
            </div>
        </div>

    </div>
</div>


<!-- Javascript -->
<script src="../assets/plugins/fontawesome-free/js/all.min.js"></script>
<script src="../assets/plugins/jquery/jquery.min.js"></script>
<script src="../assets/plugins/bootstrap/js/bootstrap.min.js"></script>
<script src="assets/js/jquery.backstretch.min.js"></script>
<script src="assets/js/scripts.js"></script>

<!--[if lt IE 10]>
<script src="assets/js/placeholder.js"></script>
<![endif]-->

</body>

</html>
