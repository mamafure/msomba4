<?php 
include('db.php'); 

// Check if admin is logged in (Simple check for this example)
// In a real system, you'd check if $_SESSION['role'] == 'admin'




// SECURITY SHIELD: Check if user is logged in AND is an admin
if(!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php"); // Kick them out
    exit();
}

// ... rest of your admin.php code ...











// Handle Product Deletion
if(isset($_GET['delete'])){
    $id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM products WHERE id=$id");
    header('location:admin.php');
}

// Handle Product Upload
if(isset($_POST['add_product'])){
    $name = $_POST['name'];
    $category = $_POST['category'];
    $old_p = $_POST['old_price'];
    $new_p = $_POST['new_price'];
    
    // Image Upload Logic
    $image = $_FILES['image']['name'];
    $target = "images/".basename($image);
    
    if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
        $sql = "INSERT INTO products (name, category, old_price, new_price, image) VALUES ('$name', '$category', '$old_p', '$new_p', '$image')";
        mysqli_query($conn, $sql);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>MSOMBA Admin Panel</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root { --primary: #ff4757; --dark: #2f3542; --light: #f1f2f6; }
        body { font-family: 'Poppins', sans-serif; background: var(--light); margin: 0; }
        
        /* Sidebar/Tab Styling */
        .admin-container { display: flex; min-height: 100vh; }
        .sidebar { width: 250px; background: var(--dark); color: white; padding: 20px; }
        .sidebar h2 { text-align: center; font-size: 1.2rem; margin-bottom: 30px; color: var(--primary); }
        
        .tab-btn { 
            width: 100%; padding: 15px; border: none; background: none; color: white; 
            text-align: left; font-size: 1rem; cursor: pointer; transition: 0.3s;
            border-radius: 5px; margin-bottom: 5px;
        }
        .tab-btn:hover, .tab-btn.active { background: var(--primary); }
        .tab-btn i { margin-right: 10px; }

        .main-content { flex: 1; padding: 30px; }
        .tab-content { display: none; animation: fadeIn 0.5s; }
        .tab-content.active { display: block; }

        /* Forms & Tables */
        .card { background: white; padding: 20px; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.05); margin-bottom: 30px; }
        input, select { width: 100%; padding: 10px; margin: 10px 0; border: 1px solid #ddd; border-radius: 5px; }
        .btn-save { background: var(--primary); color: white; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer; }
        
        table { width: 100%; border-collapse: collapse; background: white; }
        th, td { padding: 12px; border-bottom: 1px solid #eee; text-align: left; }
        th { background: #f8f9fa; }
        .prod-img { width: 50px; height: 50px; object-fit: cover; border-radius: 5px; }
        .category-header { background: #e2e2e2; padding: 10px; font-weight: bold; margin-top: 20px; }

        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
    </style>
</head>
<body>

<div class="admin-container">
    <!-- Sidebar -->
    <div class="sidebar">
        <h2>MSOMBA ADMIN</h2>
        <button class="tab-btn active" onclick="openTab(event, 'productsTab')"><i class="fas fa-box"></i> Products</button>
        <button class="tab-btn" onclick="openTab(event, 'ordersTab')"><i class="fas fa-shopping-bag"></i> Orders List</button>
        <button class="tab-btn" onclick="openTab(event, 'customersTab')"><i class="fas fa-users"></i> Customers</button>
        <a href="logout.php" style="text-decoration:none;"><button class="tab-btn"><i class="fas fa-sign-out-alt"></i> Logout</button></a>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        
        <!-- Tab 1: Products -->
        <div id="productsTab" class="tab-content active">
            <div class="card">
                <h3>Add New Product</h3>
                <form method="POST" enctype="multipart/form-data">
                    <select name="category" required>
                        <option value="">Select Category</option>
                        <option>Smartphones</option>
                        <option>Phone Covers</option>
                        <option>Chargers</option>
                        <option>Other Accessories</option>
                    </select>
                    <input type="text" name="name" placeholder="Product Name" required>
                    <input type="number" name="old_price" placeholder="Old Price (TSh)">
                    <input type="number" name="new_price" placeholder="New Price (TSh)" required>
                    <input type="file" name="image" accept="image/*" required>
                    <button type="submit" name="add_product" class="btn-save">Upload Product</button>
                </form>
            </div>

            <h3>Available Products (Grouped)</h3>
            <?php
            $categories = ['Smartphones', 'Phone Covers', 'Chargers', 'Other Accessories'];
            foreach($categories as $cat) {
                echo "<div class='category-header'>$cat</div>";
                echo "<table>";
                $res = mysqli_query($conn, "SELECT * FROM products WHERE category='$cat'");
                while($row = mysqli_fetch_assoc($res)) {
                    echo "<tr>
                            <td><img src='images/{$row['image']}' class='prod-img'></td>
                            <td>{$row['name']}</td>
                            <td><strike>{$row['old_price']}</strike> / <b>{$row['new_price']}</b></td>
                            <td><a href='admin.php?delete={$row['id']}' style='color:red'><i class='fas fa-trash'></i></a></td>
                          </tr>";
                }
                echo "</table>";
            }
            ?>
        </div>

        <!-- Tab 2: Orders -->
        <div id="ordersTab" class="tab-content">
            <div class="card">
                <h3>Customer Orders</h3>
                <table>
                    <tr><th>ID</th><th>User ID</th><th>Amount</th><th>Location</th><th>Status</th></tr>
                    
                    
                    
                 
                 <?php
$orders = mysqli_query($conn, "SELECT orders.*, users.username FROM orders JOIN users ON orders.user_id = users.id ORDER BY orders.id DESC");
while($o = mysqli_fetch_assoc($orders)) {
    echo "<tr>
        <td>#{$o['id']}</td>
        <td>{$o['username']}</td>
        <td>TSh ".number_format($o['total_amount'])."</td>
        <td>
            <b>Address:</b> {$o['address']} <br>
            <!-- CLICKABLE GOOGLE MAPS LINK -->
            <a href='https://www.google.com/maps?q={$o['coordinates']}' target='_blank' style='color: #007bff; font-weight: bold; text-decoration: none;'>
                <i class='fas fa-map-marked-alt'></i> Open in Google Maps
            </a>
            <br><small>{$o['coordinates']}</small>
        </td>
    





            <td>
                <details>
                    <summary style='cursor:pointer; color:#ff4757;'>View Items</summary>
                    <ul style='font-size:0.8rem; padding-left:15px;'>";
                    $oid = $o['id'];
                    $items = mysqli_query($conn, "SELECT * FROM order_items WHERE order_id=$oid");
                    while($it = mysqli_fetch_assoc($items)) {
                        echo "<li>{$it['quantity']}x {$it['product_name']} (TSh ".number_format($it['price']).")</li>";
                    }
    echo "          </ul>
                </details>
            </td>
          </tr>";
}
?>
                    
                    
                    
                    
                    
                    
                    
                    
                    
                </table>
            </div>
        </div>

        <!-- Tab 3: Customers -->
        <div id="customersTab" class="tab-content">
            <div class="card">
                <h3>Registered Customers</h3>
                <table>
                    <tr><th>Username</th><th>Email</th><th>Contact</th><th>Joined Date</th></tr>
                    <?php
                    $users = mysqli_query($conn, "SELECT * FROM users");
                    while($u = mysqli_fetch_assoc($users)) {
                        echo "<tr>
                                <td>{$u['username']}</td>
                                <td>{$u['email']}</td>
                                <td>{$u['contact']}</td>
                                <td>{$u['created_at']}</td>
                              </tr>";
                    }
                    ?>
                </table>
            </div>
        </div>

    </div>
</div>

<script>
function openTab(evt, tabName) {
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tab-content");
    for (i = 0; i < tabcontent.length; i++) { tabcontent[i].style.display = "none"; }
    tablinks = document.getElementsByClassName("tab-btn");
    for (i = 0; i < tablinks.length; i++) { tablinks[i].className = tablinks[i].className.replace(" active", ""); }
    document.getElementById(tabName).style.display = "block";
    evt.currentTarget.className += " active";
}
</script>
</body>
</html>