<?php  

function insertCoach($pdo, $username, $first_name, $last_name, 
	$date_of_birth, $specialization, $added_by) {

	$sql = "INSERT INTO coaches (username, first_name, last_name, 
		date_of_birth, specialization, added_by, last_updated) VALUES(?,?,?,?,?,?, null)";

	$stmt = $pdo->prepare($sql);
	$executeQuery = $stmt->execute([$username, $first_name, $last_name, 
		$date_of_birth, $specialization, $added_by]);

	if ($executeQuery) {
		return true;
	}
}



function updateCoach($pdo, $first_name, $last_name, 
	$date_of_birth, $specialization, $edited_by, $coach_id) {

	$sql = "UPDATE coaches
				SET first_name = ?,
					last_name = ?,
					date_of_birth = ?, 
					specialization = ?,
					last_updated = now(),
					edited_by = ?
				WHERE coach_id = ?
			";
	$stmt = $pdo->prepare($sql);
	$executeQuery = $stmt->execute([$first_name, $last_name, 
		$date_of_birth, $specialization, $edited_by, $coach_id]);
	
	if ($executeQuery) {
		return true;
	}

}


function deleteWebDev($pdo, $coach_id, $deleted_by) {
    $deleteClientQuery = "DELETE FROM clients WHERE coach_id = ?";
    $deleteStmt = $pdo->prepare($deleteClientQuery);
    $executeDeleteQuery = $deleteStmt->execute([$coach_id]);

    if ($executeDeleteQuery) {
        $sql = "DELETE FROM coaches WHERE coach_id = ?";
        $stmt = $pdo->prepare($sql);
        $executeQuery = $stmt->execute([$coach_id]);

        if ($executeQuery) {
            // Log the deletion
            logAction($pdo, 'delete', $coach_id, 'coach', $deleted_by);
            return true;
        }
    }
    return false;
}


function getAllCoach($pdo) {
	$sql = "SELECT * FROM coaches";
	$stmt = $pdo->prepare($sql);
	$executeQuery = $stmt->execute();

	if ($executeQuery) {
		return $stmt->fetchAll();
	}
}

function getCoachByID($pdo, $coach_id) {
	$sql = "SELECT * FROM coaches WHERE coach_id = ?";
	$stmt = $pdo->prepare($sql);
	$executeQuery = $stmt->execute([$coach_id]);

	if ($executeQuery) {
		return $stmt->fetch();
	}
}

function getClientsByCoach($pdo, $coach_id) {
	
	$sql = "SELECT 
				clients.client_id AS client_id,
				clients.first_name AS first_name,
				clients.last_name AS last_name,
				clients.date_added AS date_added,
                clients.added_by AS added_by,
                clients.last_updated AS last_updated,
                clients.edited_by AS edited_by,
				CONCAT(coaches.first_name,' ',coaches.last_name) AS coach_name
			FROM clients
			JOIN coaches ON clients.coach_id = coaches.coach_id
			WHERE clients.coach_id = ? 
			GROUP BY clients.first_name;
			";

	$stmt = $pdo->prepare($sql);
	$executeQuery = $stmt->execute([$coach_id]);
	if ($executeQuery) {
		return $stmt->fetchAll();
	}
}

function getAllInfoByCoachID($pdo, $coach_id) {
	$sql = "SELECT * FROM coaches WHERE coach_id = ?";
	$stmt = $pdo->prepare($sql);
	$executeQuery = $stmt->execute([$coach_id]);
	if ($executeQuery) {
		return $stmt->fetch();
	}
}

function insertClient($pdo, $first_name, $last_name, $coach_id, $added_by) {
	$sql = "INSERT INTO clients (first_name, last_name, coach_id, added_by, last_updated) VALUES (?,?,?,?, NULL)";
	$stmt = $pdo->prepare($sql);
	$executeQuery = $stmt->execute([$first_name, $last_name, $coach_id, $added_by]);
	if ($executeQuery) {
		return true;
	}

}

function getClientByID($pdo, $client_id) {
	$sql = "SELECT 
				clients.client_id AS client_id,
				clients.first_name AS first_name,
				clients.last_name AS last_name,
				clients.date_added AS date_added,
                clients.added_by AS added_by,
                clients.last_updated AS last_updated,
                clients.edited_by AS edited_by,
				CONCAT(coaches.first_name,' ',coaches.last_name) AS client_owner
			FROM clients
			JOIN coaches ON clients.coach_id = coaches.coach_id
			WHERE clients.client_id  = ? 
			GROUP BY clients.first_name";

	$stmt = $pdo->prepare($sql);
	$executeQuery = $stmt->execute([$client_id]);
	if ($executeQuery) {
		return $stmt->fetch();
	}
}

function updateClient($pdo, $first_name, $last_name, $edited_by, $client_id) {
	$sql = "UPDATE clients
			SET first_name = ?,
				last_name = ?,
                last_updated = now(),
                edited_by = ?
			WHERE client_id = ?
			";
	$stmt = $pdo->prepare($sql);
	$executeQuery = $stmt->execute([$first_name, $last_name, $edited_by, $client_id]);

	if ($executeQuery) {
		return true;
	}
}


function deleteClient($pdo, $client_id, $deleted_by) {
    $sql = "DELETE FROM clients WHERE client_id = ?";
    $stmt = $pdo->prepare($sql);
    $executeQuery = $stmt->execute([$client_id]);

    if ($executeQuery) {
    
        logAction($pdo, 'delete', $client_id, 'client', $deleted_by);
        return true;
    }
    return false;
}

function logAction($pdo, $action_type, $affected_id, $affected_type, $user) {
    $sql = "INSERT INTO action_logs (action_type, affected_id, affected_type, user) VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$action_type, $affected_id, $affected_type, $user]);
}

function getAllActionLogs($pdo) {
    $sql = "SELECT * FROM action_logs ORDER BY timestamp DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    
    return $stmt->fetchAll();
}


function insertNewUser($pdo, $username, $password) {

	$checkUserSql = "SELECT * FROM user_passwords WHERE username = ?";
	$checkUserSqlStmt = $pdo->prepare($checkUserSql);
	$checkUserSqlStmt->execute([$username]);

	if ($checkUserSqlStmt->rowCount() == 0) {

		$sql = "INSERT INTO user_passwords (username,password) VALUES(?,?)";
		$stmt = $pdo->prepare($sql);
		$executeQuery = $stmt->execute([$username, $password]);

		if ($executeQuery) {
			$_SESSION['message'] = "User successfully inserted";
			return true;
		}

		else {
			$_SESSION['message'] = "An error occured from the query";
		}

	}
	else {
		$_SESSION['message'] = "User already exists";
	}

	
}



function loginUser($pdo, $username, $password) {
	$sql = "SELECT * FROM user_passwords WHERE username=?";
	$stmt = $pdo->prepare($sql);
	$stmt->execute([$username]); 

	if ($stmt->rowCount() == 1) {
		$userInfoRow = $stmt->fetch();
		$usernameFromDB = $userInfoRow['username']; 
		$passwordFromDB = $userInfoRow['password'];

		if ($password == $passwordFromDB) {
			$_SESSION['username'] = $usernameFromDB;
			$_SESSION['message'] = "Login successful!";
			return true;
		}

		else {
			$_SESSION['message'] = "Password is invalid, but user exists";
		}
	}

	
	if ($stmt->rowCount() == 0) {
		$_SESSION['message'] = "Username doesn't exist from the database. You may consider registration first";
	}

}

function getAllUsers($pdo) {
	$sql = "SELECT * FROM user_passwords";
	$stmt = $pdo->prepare($sql);
	$executeQuery = $stmt->execute();

	if ($executeQuery) {
		return $stmt->fetchAll();
	}

}

function getUserByID($pdo, $user_id) {
	$sql = "SELECT * FROM user_passwords WHERE user_id = ?";
	$stmt = $pdo->prepare($sql);
	$executeQuery = $stmt->execute([$user_id]);
	if ($executeQuery) {
		return $stmt->fetch();
	}
}


?>