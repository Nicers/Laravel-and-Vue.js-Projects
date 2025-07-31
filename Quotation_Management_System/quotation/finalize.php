<?php
session_start();

if (!isset($_SESSION["loggedIn"])) {
    header("location: /Quotation_Management_System/account/signIn.php");
    exit;
}

include('../include/conn.php');

if(isset($_SESSION['quotation_id'])){
    $quotation_id = $_SESSION['quotation_id'];
}else{
    $quotation_id = null;
}

if (!$quotation_id) {
    header("location: addQuote.php");
    exit;
}

// quotation + customer
$get_quotation = mysqli_query($conn, "
    SELECT quotations.quotation_date, quotations.validity_date, quotations.note, customers.name, customers.email 
    FROM quotations 
    JOIN customers ON quotations.customer_id = customers.id 
    WHERE quotations.id = '$quotation_id'
");
$quotation = mysqli_fetch_assoc($get_quotation);


//terms from session
$terms = isset($_SESSION['quotation_terms']) ? $_SESSION['quotation_terms'] : [];
$custom_terms = isset($_SESSION['custom_terms']) ? $_SESSION['custom_terms'] : '';

include('../sidebar/sidebar_header.php');
?>

<div class="container mt-5 w-50 mb-5">
    <h3>Quotation Summary</h3>

    <p><strong>Customer:</strong> <?php echo $quotation['name']; ?> (<?php echo $quotation['email']; ?>)</p>
    <p><strong>Quotation Date:</strong> <?php echo $quotation['quotation_date']; ?></p>
    <p><strong>Valid Until:</strong> <?php echo $quotation['validity_date']; ?></p>
    <p><strong>Note:</strong> <?php echo $quotation['note']; ?></p>

    <h5>Items:</h5>
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

    <h5>Terms & Conditions</h5>
    <ul>
        <?php 
        foreach ($terms as $t) {
            echo "<li>" . htmlspecialchars($t) . "</li>";
        }
        ?>
    </ul>

    <p><?php echo nl2br(htmlspecialchars($custom_terms)); ?></p>

    <a href="print.php?id=<?php echo $quotation_id; ?>" class="btn btn-success mb-5" target="_blank">Print Quotation</a>
</div>

<?php include('../sidebar/sidebar_footer.php'); ?>
