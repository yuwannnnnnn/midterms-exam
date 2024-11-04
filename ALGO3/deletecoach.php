<?php require_once 'core/models.php'; ?>
<?php require_once 'core/dbConfig.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Delete Coach Confirmation</title>
	<link rel="stylesheet" href="styles.css">
	<style>
		body {
			font-family: Arial, sans-serif;
			background-color: #eef2f7;
			color: #333;
			display: flex;
			flex-direction: column;
			align-items: center;
			padding: 20px;
			margin: 0;
		}

		h1 {
			color: #e74c3c; /* Red color for warning */
			margin-bottom: 20px;
		}

		.container {
			background-color: #ffffff;
			border-radius: 8px;
			box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
			padding: 20px;
			width: 100%;
			max-width: 500px;
			text-align: left;
		}

		h2 {
			color: #34495e; /* Dark blue for headings */
			margin: 10px 0;
		}

		.deleteBtn {
			margin-top: 20px;
			text-align: right;
		}

		input[type="submit"] {
			background-color: #e74c3c; /* Red color for the delete button */
			color: white;
			border: none;
			border-radius: 5px;
			padding: 10px 20px;
			font-size: 16px;
			cursor: pointer;
			transition: background-color 0.3s ease;
		}

		input[type="submit"]:hover {
			background-color: #c0392b; /* Darker red on hover */
		}
	</style>
</head>
<body>
	<h1>Are you sure you want to delete this coach?</h1>
	<?php $getCoachByID = getCoachByID($pdo, $_GET['coach_id']); ?>
	<div class="container">
		<h2>Username: <?php echo $getCoachByID['username']; ?></h2>
		<h2>First Name: <?php echo $getCoachByID['first_name']; ?></h2>
		<h2>Last Name: <?php echo $getCoachByID['last_name']; ?></h2>
		<h2>Date Of Birth: <?php echo $getCoachByID['date_of_birth']; ?></h2>
		<h2>Specialization: <?php echo $getCoachByID['specialization']; ?></h2>
		<h2>Date Added: <?php echo $getCoachByID['date_added']; ?></h2>

		<div class="deleteBtn">
			<form action="core/handleForms.php?coach_id=<?php echo $_GET['coach_id']; ?>" method="POST">
				<input type="submit" name="deleteCoachBtn" value="Delete">
			</form>			
		</div>	
	</div>
</body>
</html>
