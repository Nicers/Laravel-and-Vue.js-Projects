<?php
session_start();

if (!isset($_SESSION["loggedIn"])) {
    header("location: /Quotation_Management_System/account/signIn.php");
    exit;
}

include('../include/conn.php');

$user_id = $_SESSION['user_id'];
$showError = '';


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $cust_id = $_POST['customer_id'];
    $quote_date = $_POST['quotation_date'];
    $validate_date = $_POST['validity_date'];
    $notes = $_POST['note'];

    if (!empty($cust_id) && !empty($quote_date) && !empty($validate_date)) {
        $sql = "INSERT INTO quotations (customer_id, user_id, quotation_date, validity_date, note) 
                VALUES ('$cust_id', '$user_id', '$quote_date', '$validate_date', '$notes')";

        $result = mysqli_query($conn, $sql);
        if ($result) {
            $_SESSION['quotation_id'] = mysqli_insert_id($conn);
            header("location: add_items.php");
            exit;
        } else {
            $showError = "Something wrong in saving.";
        }
    } else {
        $showError = "All fields required.";
    }
}

include('../sidebar/sidebar_header.php');
?>

<div class="container mt-5 w-50">
    <h3>Create New Quotation</h3>

    <?php 
    if (!empty($showError)) {
        echo "<div class='alert alert-danger'>$showError</div>";
    }
    ?>

    <form method="POST" action="addQuote.php">
        <div class="mb-3">
            <label>Customer</label>
            <select name="customer_id" class="form-control" required>
                <option value="">select</option>
                <?php 
// all customers
$all_customers = mysqli_query($conn, "SELECT * FROM customers WHERE user_id = '$user_id'");
                while ($customer = mysqli_fetch_assoc($all_customers)) 
                { ?>
                    <option value="<?php echo $customer['id']; ?>">
                        <?php echo $customer['name'] . " (" . $customer['email'] . ")"; ?>
                    </option>
                <?php 
            } ?>
            </select>
        </div>

        <div class="mb-3">
            <label>Quotation Date</label>
            <input type="date" name="quotation_date" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Validity Date</label>
            <input type="date" name="validity_date" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Note</label>
            <textarea name="note" class="form-control" rows="3"></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Next= Add Items</button>
    </form>
</div>
<?php include('../sidebar/sidebar_footer.php'); ?>
