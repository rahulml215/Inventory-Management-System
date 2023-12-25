<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "inventory";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Add a new product
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["add_product"])) {
    $id = $_POST["id"];
    $name = $_POST["name"];
    $quantity = $_POST["quantity"];
    $price = $_POST["price"];

    $sql = "INSERT INTO products (id,name, quantity, price) VALUES ('$id', '$name', '$quantity', '$price')";

    if ($conn->query($sql) === TRUE) {
        header("Location: index.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Edit product details
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["edit_product"])) {
    $id = $_POST["edit_id"];
    $name = $_POST["edit_name"];
    $quantity = $_POST["edit_quantity"];
    $price = $_POST["edit_price"];

    $sql = "UPDATE products SET name='$name', quantity='$quantity', price='$price' WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        header("Location: index.php");
    } else {
        echo "Error updating record: " . $conn->error;
    }
}

// Delete product
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["delete_id"])) {
    $id = $_GET["delete_id"];

    $sql = "DELETE FROM products WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        header("Location: index.php");
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}

// Fetch all products
$sql = "SELECT * FROM products";
$result = $conn->query($sql);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Management System</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        h1,
        h2 {
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table,
        th,
        td {
            border: 1px solid #ddd;
        }

        th,
        td {
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #4caf50;
            color: #fff;
        }

        tr:hover {
            background-color: #f5f5f5;
        }

        form {
            max-width: 400px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #333;
        }

        input {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            box-sizing: border-box;
        }

        button {
            background-color: #4caf50;
            color: #fff;
            padding: 10px 15px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }
    </style>
</head>

<body>
    <h1>Inventory Management System</h1>

    <!-- Display product list -->
    <h2>Product List</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Quantity</th>
            <th>Price</th>
            <th>Action</th>
        </tr>
        <?php
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>{$row['id']}</td>";
            echo "<td>{$row['name']}</td>";
            echo "<td>{$row['quantity']}</td>";
            echo "<td>{$row['price']}</td>";
            echo "<td><a href='edit.php?id={$row['id']}'>Edit</a> | <a href='index.php?delete_id={$row['id']}'>Delete</a></td>";
            echo "</tr>";
        }
        ?>
    </table>

    <!-- Add new product form -->
    <h2>Add New Product</h2>
    <form method="POST" action="index.php">
        <label>id:</label>
        <input type="number" name="id" required>
        <label>Name:</label>
        <input type="text" name="name" required>
        <label>Quantity:</label>
        <input type="number" name="quantity" required>
        <label>Price:</label>
        <input type="text" name="price" required>
        <button type="submit" name="add_product">Add Product</button>
    </form>
</body>

</html>