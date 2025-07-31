<?php
session_start();

if (!isset($_SESSION["loggedIn"])) {
    header("location: /Quotation_Management_System/account/signIn.php");
    exit;
}

include('../include/conn.php');

if (isset($_SESSION['quotation_id'])) {
    $quotation_id = $_SESSION['quotation_id'];
} else {
    $quotation_id = null;
}

if (!$quotation_id) {
    header("location: addQuote.php");
    exit;
}


// Add items of quotation to quotation_items
$item_query = mysqli_query($conn, 'SELECT * from quotation_items');
while ($row = mysqli_fetch_assoc($item_query)) {
    if ($quotation_id != $row['quotation_id']) {
        $item_id = $row['item_id'];
        $quantity = $row['quantity'];
        $price = $row['price'];
        $check_qoute_item = mysqli_query($conn, "SELECT * from quotation_items WHERE item_id='".$item_id."' and quotation_id='".$quotation_id."'");
      if(mysqli_num_rows($check_qoute_item) == 0){
          $sql_insert = "INSERT INTO quotation_items (quotation_id, item_id, quantity, price)
                       VALUES ('$quotation_id', '$item_id', '$quantity', '$price')";
        mysqli_query($conn, $sql_insert);
      }
    }

}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $_SESSION['quotation_terms'] = $_POST['terms'];
    $_SESSION['custom_terms'] = $_POST['custom_terms'];

    $id = $_POST['id'];
    $query = "UPDATE quotations SET
    term_id ='" . $id . "'
    WHERE id='" . $quotation_id . "'";
    mysqli_query($conn, $query);
    header("location: finalize.php");
    exit;
}

include('../sidebar/sidebar_header.php');
?>

<div class="container mt-5 w-50">
    <h3>Select Terms & Conditions</h3>
    <form method="POST" action="select_terms.php">
        <?php
        // all terms
        $user_id = $_SESSION['user_id'];
        $terms_result = mysqli_query($conn, "SELECT * FROM terms WHERE user_id = '$user_id'");
        while ($term = mysqli_fetch_assoc($terms_result)) {
            $term_text = $term['term'];
            $term_name = $term['name'];
            $term_id = $term['id'];
            ?>
            <div class="form-check border rounded p-2 mb-2">
                <input class="form-check-input" type="checkbox" name="terms[]" value="<?php echo $term_text; ?>"
                    id="term<?php echo $term_id; ?>">
                <label class="form-check-label" for="term<?php echo $term_id; ?>">
                    <strong><?php echo $term_name; ?>:</strong> <?php echo $term_text; ?>
                </label>
                <input type="hidden" name="id" value="<?php echo $term_id ?>">
            </div>
            <?php
        }
        ?>

        <div class="mt-4">
            <label>Add Custom Terms</label>
            <textarea name="custom_terms" class="form-control" rows="4"></textarea>
        </div>

        <button type="submit" class="btn btn-primary mt-3">Next= Finalize</button>
    </form>
</div>

<?php include('../sidebar/sidebar_footer.php'); ?>