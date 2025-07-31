<?php
session_start();

if (!isset($_SESSION["loggedIn"])) {
    header("location: /Quotation_Management_System/account/signIn.php");
    exit;
}
include '../../include/conn.php';
$me = mysqli_fetch_assoc(mysqli_query($conn, 'SELECT * from quotations'));
// echo '<pre>' , var_dump($me) , '</pre>';

if (isset($_GET['uid'])) {
    $quotation_id = $_GET['uid'];
} else {
    $quotation_id = null;
}

if (!$quotation_id) {
    echo "Quotation not found!";
    exit;
}

// Delete quotation_item_customer_cart
mysqli_query($conn, "TRUNCATE TABLE quotation_item_customer_cart");

// Delete customer_items
mysqli_query($conn, "TRUNCATE TABLE customer_items");
unset($_SESSION['quotation_item_id']);

// quotation and customer
$sql = "
    SELECT quotations.id, quotations.quotation_date, quotations.validity_date, quotations.note, customers.name, customers.email, customers.phone, customers.address
    FROM quotations
    JOIN customers ON quotations.customer_id = customers.id
    WHERE quotations.id = '$quotation_id'
";
$quotation_result = mysqli_query($conn, $sql);
$quotation = mysqli_fetch_assoc($quotation_result);

// get terms from session
if (isset($_SESSION['quotation_terms'])) {
    $terms = $_SESSION['quotation_terms'];
} else {
    $terms = [];
}

if (isset($_SESSION['custom_terms'])) {
    $custom_terms = $_SESSION['custom_terms'];
} else {
    $custom_terms = '';
} ?>

<!DOCTYPE html>
<html>

<head>
    <title>Quotation #<?php echo $quotation_id; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        @media print {
            .no-print {
                display: none;
            }
        }

        body {
            padding: 30px;
            font-family: Arial;
        }

        .invoice-box {
            border: 1px solid #ccc;
            padding: 20px;
        }
    </style>
</head>

<body>

    <div class="invoice-box">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Quotation</h2>
            <button class="btn btn-primary no-print" onclick="window.print()">Print</button>
        </div>

        <p><strong>Quotation ID:</strong> <?php echo $quotation['id']; ?></p>
        <p><strong>Date:</strong> <?php echo $quotation['quotation_date']; ?></p>
        <p><strong>Valid Until:</strong> <?php echo $quotation['validity_date']; ?></p>

        <hr>

        <h5>Customer Details</h5>
        <p>
            <strong>Name:</strong> <?php echo $quotation['name']; ?><br>
            <strong>Email:</strong> <?php echo $quotation['email']; ?><br>
            <strong>Phone:</strong> <?php echo $quotation['phone']; ?><br>
            <strong>Address:</strong> <?php echo $quotation['address']; ?>
        </p>

        <hr>

        <h5>Quotation Items</h5>
        <table class="table table-bordered">
            <tr>
                <th>Item</th>
                <th>Qty</th>
                <th>Price</th>
                <th>Total</th>
            </tr>

            <?php
            $item_query = mysqli_query($conn, "SELECT * from quotation_items WHERE quotation_id='" . $quotation_id . "'");
            $grand_total = 0;
            $previous_quotation_item_id = '';
            while ($row = mysqli_fetch_assoc($item_query)) {
                if ($previous_quotation_item_id != $row['id']) {

                    $item_id = $row['item_id'];
                    $quantity = $row['quantity'];
                    $price = $row['price'];

                    $total = $quantity * $price;
                    $grand_total += $total;
                    $previous_quotation_item_id = $row['id'];
                    ?>
                    <tr>
                        <td><?php echo $item_id; ?></td>
                        <td><?php echo $quantity; ?></td>
                        <td><?php echo $price; ?></td>
                        <td><?php echo $grand_total; ?></td>
                    </tr>
                <?php }
            } ?>

            <tr>
                <td colspan="3"><strong>Grand Total</strong></td>
                <td><strong><?php echo $grand_total; ?></strong></td>
            </tr>
        </table>

        <hr>

        <h5>Terms & Conditions</h5>
        <ul>
            <?php
            foreach ($terms as $term) {
                echo "<li>" . htmlspecialchars($term) . "</li>";
            }
            ?>
        </ul>

        <?php if (!empty($custom_terms)) { ?>
            <p><?php echo nl2br(htmlspecialchars($custom_terms)); ?></p>
        <?php } ?>

        <hr>

        <p><strong>Note:</strong> <?php echo nl2br(htmlspecialchars($quotation['note'])); ?></p>
    </div>

</body>

</html>