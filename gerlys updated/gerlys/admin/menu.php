<?php
$connection = mysqli_connect("localhost", "root", "", "gerlysdatabase");

if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    exit();
}

// Insert or update menu item if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $menuName = mysqli_real_escape_string($connection, $_POST['menuName']);
    $description = mysqli_real_escape_string($connection, $_POST['description']);
    $price = mysqli_real_escape_string($connection, $_POST['price']);
    $menuId = isset($_POST['menuId']) ? mysqli_real_escape_string($connection, $_POST['menuId']) : null;

    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $imageName = $_FILES['image']['name'];
        $imageTmp = $_FILES['image']['tmp_name'];
        $uploadDir = 'images/'; // Update the directory path

        // Check if directory exists, if not, create it
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $uploadFile = $uploadDir . basename($imageName);
        
        // Validate the file type
        $allowedExtensions = array('jpg', 'jpeg', 'png', 'gif');
        $fileExtension = pathinfo($imageName, PATHINFO_EXTENSION);
        if (!in_array($fileExtension, $allowedExtensions)) {
            echo "Invalid file type.";
            exit;
        }

        // Move the uploaded file to the final location
        if (move_uploaded_file($imageTmp, $uploadFile)) {
            if ($menuId) {
                // Update the database
                $sql = "UPDATE menu SET menu_name='$menuName', menu_description='$description', menu_price='$price', images='$uploadFile' WHERE menu_id='$menuId'";
            } else {
                // Insert new record
                $sql = "INSERT INTO menu (menu_name, menu_description, menu_price, images) VALUES ('$menuName', '$description', '$price', '$uploadFile')";
            }

            if (!mysqli_query($connection, $sql)) {
                echo "Error: " . mysqli_error($connection);
            }
        } else {
            echo "Error uploading image.";
        }
    } elseif ($menuId) {
        // If no image is uploaded, update without changing the image
        $sql = "UPDATE menu SET menu_name='$menuName', menu_description='$description', menu_price='$price' WHERE menu_id='$menuId'";
        if (!mysqli_query($connection, $sql)) {
            echo "Error: " . mysqli_error($connection);
        }
    }
}

// Delete menu item
if (isset($_GET['delete_id'])) {
    $menuId = mysqli_real_escape_string($connection, $_GET['delete_id']);
    $sql = "DELETE FROM menu WHERE menu_id='$menuId'";
    if (!mysqli_query($connection, $sql)) {
        echo "Error: " . mysqli_error($connection);
    }
}

// Fetch existing menu items
$menuItems = mysqli_query($connection, "SELECT * FROM menu");

mysqli_close($connection);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            display: flex;
        }
        .sidebar {
            width: 250px;
            background-color: #2c3e50;
            color: white;
            padding: 15px;
            height: 100vh;
            position: fixed;
        }
        .sidebar h2 {
            text-align: center;
        }
        .sidebar a {
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center; 
            padding: 10px;
            margin: 15px 0;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        .sidebar a:hover {
            background-color: #34495e;
        }
        .sidebar i {
            margin-right: 8px; 
        }
        .content {
            margin-left: 270px; 
            padding: 20px;
            flex: 1;
        }
        .table-container {
            margin-top: 20px;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 10px;
            text-align: center;
            border: 1px solid #ddd;
        }
        th {
            background-color: #2c3e50;
            color: white;
        }
    </style>
</head>
<body>

<div class="sidebar">
    <h2>Admin Panel</h2>
    <a href="#dashboard"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
    <a href="user.php"><i class="fas fa-user"></i> Manage User</a>
    <a href="menu.php"><i class="fas fa-utensils"></i> Manage Menu</a>
    <a href="reservation.php"><i class="fas fa-calendar-check"></i> Manage Reservation</a>
    <a href="payment.php"><i class="fas fa-credit-card"></i> Manage Payment</a>
    <a href="#logout" class="logout"><i class="fas fa-sign-out-alt"></i> Logout</a>
</div>

<div class="content">
    <div class="table-container">
    <h1>Menu Management</h1>
    <button class="btn btn-primary" id="openModal" data-toggle="modal" data-target="#myModal">Add Menu Item</button>
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Image</th>
                    <th>Menu Name</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($menuItems as $index => $item): ?>
                <tr>
                    <td><?php echo $index + 1; ?></td>
                    <td><img src="<?php echo htmlspecialchars($item['images']); ?>" alt= "<?php echo htmlspecialchars($item['menu_name']); ?>" style="width: 100px; height: auto;"></td>
                    <td><?php echo htmlspecialchars($item['menu_name']); ?></td>
                    <td><?php echo htmlspecialchars($item['menu_description']); ?></td>
                    <td>$<?php echo htmlspecialchars($item['menu_price']); ?></td>
                    <td>
                        <button class='btn btn-warning btn-sm' onclick='editItem(<?php echo $item['menu_id']; ?>, "<?php echo htmlspecialchars($item['menu_name']); ?>", "<?php echo htmlspecialchars($item['menu_description']); ?>", <?php echo $item['menu_price']; ?>, "<?php echo htmlspecialchars($item['images']); ?>")'>Edit</button>
                        <a href='?delete_id=<?php echo $item['menu_id']; ?>' class='btn btn-danger btn-sm' onclick='return confirm("Are you sure you want to delete this item?");'>Delete</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Bootstrap Modal -->
<div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add/Edit Menu Item</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="POST" enctype="multipart/form-data" id="menuForm">
                    <input type="hidden" name="menuId" id="menuId">
                    <div class="form-group">
                        <label for="menuName">Menu Name:</label>
                        <input type="text" class="form-control" id="menuName" name="menuName" required>
                    </div>
                    <div class="form-group">
                        <label for="description">Description:</label>
                        <textarea class="form-control" id="description" name="description" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="price">Price:</label>
                        <input type="number" class="form-control" id="price" name="price" required>
                    </div>
                    <div class="form-group">
                        <label for="image">Upload Image:</label>
                        <input type="file" class="form-control-file" id="image" name="image" accept="image/*">
                    </div>
                    <button type="submit" class="btn btn-primary">Save Item</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    $(document).ready(function() {
        $("#openModal").click(function() {
            $("#menuId").val(''); // Clear form for adding new item
            $("#menuName").val('');
            $("#description").val('');
            $("#price").val('');
            $("#image").val(''); // Clear the file input
        });
    });

    function editItem(id, name, description, price, image) {
        $("#menuId").val(id);
        $("#menuName").val(name);
        $("#description").val(description);
        $("#price").val(price);
        $("#myModal").modal("show");
    }
</script>
</body>
</html>
