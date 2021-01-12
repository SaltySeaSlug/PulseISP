<?php

class Database {

	// Function to the database and tables and fill them with the default data
	function create_database($data)
	{
		// Connect to the database
		$mysqli = new mysqli($data['hostname'],$data['username'],$data['password'],'');

		// Check for errors
		if(mysqli_connect_errno())
			return false;

		// Create the prepared statement
		$mysqli->query("CREATE DATABASE IF NOT EXISTS ".$data['database']);

		// Close the connection
		$mysqli->close();

		return true;
	}

	// Function to create the tables and fill them with the default data
	function create_tables($data)
	{
		// Connect to the database
		$mysqli = new mysqli($data['hostname'],$data['username'],$data['password'],$data['database']);

		// Check for errors
		if(mysqli_connect_errno())
			return false;

		// Open the default SQL file
		$query = file_get_contents('config/install.sql');
        $new  = str_replace("%DATABASE%", $data['database'], $query);

		// Execute a multi query
		$mysqli->multi_query($new);

		// Close the connection
		$mysqli->close();

		return true;
	}

	// Function to create the user within the user table
	function create_user($data)
    {
        $mysqli = new mysqli($data['hostname'],$data['username'],$data['password'],$data['database']);

        // Check for errors
        if(mysqli_connect_errno())
            return false;

        // Prepare statement
        $sql = "INSERT INTO users (role_id, name, surname, username, password) VALUES ('1', '" . $data['firstname'] . "', '" . $data['lastname'] . "', '". $data['email'] ."', '" . password_hash($data['usr-password'], PASSWORD_BCRYPT) . "')";
        $mysqli->query($sql);
        $user_id = $mysqli->insert_id;

        $sql1 = "INSERT INTO contact_info (type, value) VALUES ('email', '" . $data['email'] . "')";
        $mysqli->query($sql1);
        $contact_id = $mysqli->insert_id;

        $sql2 = "INSERT INTO users_contact_info (user_id, contact_info_id) VALUES ('".$user_id."', '" . $contact_id . "')";
        $mysqli->query($sql2);

        // Close the connection
        $mysqli->close();

        return true;
    }
}