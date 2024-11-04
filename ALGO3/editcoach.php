<?php require_once 'core/handleForms.php'; ?>
<?php require_once 'core/models.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Coach</title>
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
        form {
            background-color: #ffffff;
            border-radius: 8px;
            padding: 20px;
            width: 100%;
            max-width: 400px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
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
        input[type="text"],
        input[type="date"] {
            width: calc(100% - 20px); /* Adjusting width to ensure padding */
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box; /* Ensure padding is included in width */
        }
        input[type="submit"] {
            width: 100%;
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
    <?php $getCoachByID = getCoachByID($pdo, $_GET['coach_id']); ?>
    <h1>Edit the coach!</h1>
    <form action="core/handleForms.php?coach_id=<?php echo $_GET['coach_id']; ?>" method="POST">
        <p>
            <label for="firstName">First Name</label> 
            <input type="text" name="firstName" value="<?php echo $getCoachByID['first_name']; ?>" required>
        </p>
        <p>
            <label for="lastName">Last Name</label> 
            <input type="text" name="lastName" value="<?php echo $getCoachByID['last_name']; ?>" required>
        </p>
        <p>
            <label for="dateOfBirth">Date of Birth</label> 
            <input type="date" name="dateOfBirth" value="<?php echo $getCoachByID['date_of_birth']; ?>" required>
        </p>
        <p>
            <label for="specialization">Specialization</label> 
            <input type="text" name="specialization" value="<?php echo $getCoachByID['specialization']; ?>" required>
        </p>
        <input type="submit" name="editCoachBtn" value="Save Changes">
    </form>
</body>
</html>
