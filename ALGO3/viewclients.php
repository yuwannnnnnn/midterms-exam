<?php require_once 'core/models.php'; ?>
<?php require_once 'core/dbConfig.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client Management</title>
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
            margin-bottom: 10px;
        }
        a {
            color: #3498db;
            text-decoration: none;
            margin: 15px;
        }
        a:hover {
            color: #2980b9;
        }
        form {
            background-color: #ffffff;
            border-radius: 8px;
            padding: 20px;
            width: 100%;
            max-width: 400px; /* Set max width to keep it centered */
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
        input[type="submit"] {
            width: 100%; /* Full width */
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box; /* Ensures padding is included in width */
        }
        input[type="submit"] {
            background-color: #3498db;
            color: white;
            cursor: pointer;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }
        input[type="submit"]:hover {
            background-color: #2980b9;
        }
        table {
            width: 100%;
            margin-top: 50px;
            border-collapse: collapse;
            background-color: #ffffff;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        .action-links a {
            color: #3498db;
            margin-right: 10px;
            text-decoration: none;
            font-weight: bold;
        }
        .action-links a:hover {
            color: #2980b9;
        }
    </style>
</head>
<body>
    <a href="index.php">Return to home</a>
    <?php $getAllInfoByCoachID = getAllInfoByCoachID($pdo, $_GET['coach_id']); ?>
    <h1>Username: <?php echo $getAllInfoByCoachID['username']; ?></h1>
    <h1>Add New Client</h1>
    <form action="core/handleForms.php?coach_id=<?php echo $_GET['coach_id']; ?>" method="POST">
        <p>
            <label for="firstName">First Name</label> 
            <input type="text" name="firstName" required>
        </p>
        <p>
            <label for="lastName">Last Name</label> 
            <input type="text" name="lastName" required>
        </p>
        <input type="submit" name="insertNewClientBtn" value="Add Client">
    </form>

    <table>
      <tr>
        <th>Client ID</th>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Coach</th>
        <th>Date Added</th>
        <th>Added By</th>
        <th>Last Updated</th>
        <th>Edited By</th>
        <th>Action</th>
      </tr>
      <?php 
      $getClientsByCoach = getClientsByCoach($pdo, $_GET['coach_id']); 
      foreach ($getClientsByCoach as $row) { ?>
          <tr>
              <td><?php echo $row['client_id']; ?></td>     
              <td><?php echo $row['first_name']; ?></td>     
              <td><?php echo $row['last_name']; ?></td>     
              <td><?php echo $row['coach_name']; ?></td>     
              <td><?php echo $row['date_added']; ?></td>
              <td><?php echo $row['added_by']; ?></td>
              <td><?php echo $row['last_updated']; ?></td>
              <td><?php echo $row['edited_by']; ?></td>
              <td class="action-links">
                  <a href="editclient.php?client_id=<?php echo $row['client_id']; ?>&coach_id=<?php echo $_GET['coach_id']; ?>">Edit</a>
                  <a href="deleteclient.php?client_id=<?php echo $row['client_id']; ?>&coach_id=<?php echo $_GET['coach_id']; ?>">Delete</a>
              </td>     
          </tr>
      <?php } ?>
    </table>
</body>
</html>
