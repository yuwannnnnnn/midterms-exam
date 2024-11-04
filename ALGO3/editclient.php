<?php require_once 'core/models.php'; ?>
<?php require_once 'core/dbConfig.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Client</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7fa;
            color: #333;
            display: flex;
            flex-direction: column;
            align-items: center;
            margin: 0;
            padding: 20px;
        }
        h1 {
            color: #2c3e50;
            margin-bottom: 20px;
        }
        a {
            color: #3498db;
            text-decoration: none;
            margin: 15px;
            font-weight: bold;
        }
        a:hover {
            color: #2980b9;
        }
        form {
            background-color: #ffffff;
            border-radius: 8px;
            padding: 20px;
            width: 100%;
            max-width: 400px; /* Ensures the form is not too wide */
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
            box-sizing: border-box; /* Include padding and border in width */
        }
        form p {
            margin: 10px 0;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #34495e;
        }
        input[type="text"] {
            width: 100%; /* Full width to prevent overflow */
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box; /* Include padding and border in width */
        }
        input[type="submit"] {
            width: 100%; /* Full width */
            padding: 10px;
            margin-top: 10px;
            background-color: #3498db;
            color: white;
            cursor: pointer;
            font-weight: bold;
            border: none;
            border-radius: 4px;
            transition: background-color 0.3s ease;
        }
        input[type="submit"]:hover {
            background-color: #2980b9;
        }
    </style>
</head>
<body>
    <a href="viewclients.php?coach_id=<?php echo $_GET['coach_id']; ?>">View The Clients</a>
    <h1>Edit the client!</h1>
    <?php $getClientByID = getClientByID($pdo, $_GET['client_id']); ?>
    <form action="core/handleForms.php?client_id=<?php echo $_GET['client_id']; ?>&coach_id=<?php echo $_GET['coach_id']; ?>" method="POST">
        <p>
            <label for="firstName">First Name</label> 
            <input type="text" name="firstName" value="<?php echo $getClientByID['first_name']; ?>" required>
        </p>
        <p>
            <label for="lastName">Last Name</label> 
            <input type="text" name="lastName" value="<?php echo $getClientByID['last_name']; ?>" required>
        </p>
        <input type="submit" name="editClientBtn" value="Save Changes">
    </form>
</body>
</html>
