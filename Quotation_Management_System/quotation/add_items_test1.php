<?php
session_start();

if (!isset($_SESSION["loggedIn"])) {
    header("location: /Quotation_Management_System/account/signIn.php");
    exit;
}

include '../include/conn.php';
include '../sidebar/sidebar_header.php';

$showAlert = false;
$alertContent = '';
$showError = false;
$errorContent = '';
$quotation_id = isset($_SESSION['quotation_id']) ? $_SESSION['quotation_id'] : null;

if (!$quotation_id) {
    header("location: addQuote.php");
    exit;
}

// Add item to quotation
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['quotationItem'])) {
        $item_id = $_POST['item_id'];
        $quantity = $_POST['quantity'];
        $price = $_POST['price'];

        $checkItem = mysqli_query($conn, "SELECT * from quotation_items WHERE quotation_id='$quotation_id' and item_id = '$item_id'");

        if (mysqli_num_rows($checkItem) == 0) {
            echo "<script>console.log('Entering')</script>";
            $sql_check = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from quotations WHERE id= '$quotation_id'"));
            $customer_id = $sql_check['customer_id'];

            if (!empty($_POST['item_id']) && !empty($_POST['quantity']) && !empty($_POST['price'])) {

                $checkItem = mysqli_query($conn, "SELECT * from customer_items WHERE item_id = '$item_id' and customer_id = '$customer_id'");
                if (mysqli_num_rows($checkItem) == 0) {
                    $sql1 = "INSERT INTO quotation_items (quotation_id, item_id, quantity, price)
                       VALUES ('$quotation_id', '$item_id', '$quantity', '$price')";
                    mysqli_query($conn, $sql1);

                    $sql4 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from quotation_items WHERE quotation_id= '$quotation_id'"));
                    $quotation_item_id = $sql4['id'];

                    $customer_item = "INSERT INTO customer_items (customer_id, quotation_id, quotation_item_id, item_id)
                       VALUES ('$customer_id', '$quotation_id', '$quotation_item_id', '$item_id')";
                    mysqli_query($conn, $customer_item);

                    $_SESSION['quotation_item_id'] = $quotation_item_id;
                    echo "<script>console.log('" . $_SESSION['quotation_item_id'] . "ME')</script>";

                    // if(!empty($sql4)){
                    //     echo "<script>console.log('Calling')</script>";
                    // }
                    // echo "<script>console.log('" . $sql4['note'] . "')</script>";

                    // $sql3 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from quotations WHERE id= '$quotation_id'"));
                    // $customer_id = $sql3['customer_id'];

                    $sql2 = "INSERT INTO quotation_item_customer_cart (quotation_item_id, item_id, customer_id)
                       VALUES ('$quotation_item_id', '$item_id', '$customer_id')";
                    mysqli_query($conn, $sql2);

                    // if(!empty($sql4)){
                    //     $quotation_item_id = $sql4['id'];
                    // }
                } else {
                    $showError = true;
                    $errorContent = "Selected Item already added!";

                    $check_quotation_item = mysqli_query($conn, "SELECT * from quotation_items WHERE item_id = '$item_id' and quotation_id = '$quotation_id'");
                    if (mysqli_num_rows($check_quotation_item) == 0) {
                        $sql1 = "INSERT INTO quotation_items (quotation_id, item_id, quantity, price)
                       VALUES ('$quotation_id', '$item_id', '$quantity', '$price')";
                        mysqli_query($conn, $sql1);
                    }
                }
            }
        } else {
            $showError = true;
            $errorContent = "Item already added!";
        }
    } else if (isset($_POST['quotationItemUpdate'])) {
        if (!empty($_POST['quotation_item']) && !empty($_POST['quotation_qty']) && !empty($_POST['quotation_price'])) {
            echo "<script>console.log('Called');</script>";
            $item_id = $_POST['quotation_item'];
            $update_quotation_item_id = $_POST['quotation_item_id'];
            $quantity = $_POST['quotation_qty'];
            $price = $_POST['quotation_price'];
            $qry = "UPDATE quotation_items SET
            item_id ='" . $item_id . "',
            quantity ='" . $quantity . "',
            price ='" . $price . "'
            WHERE id='" . $update_quotation_item_id . "'";
            if (mysqli_query($conn, $qry)) {
                $showAlert = true;
                $alertContent = "Item successfully updated!";
            } else {
                $showError = true;
                $errorContent = "Items not updated!";
            }
        }
    }
}

// Delete item
if (isset($_GET['did'])) {
    $did = $_GET['did'];
    $qrydel = mysqli_query($conn, "DELETE FROM quotation_items WHERE id = '" . $did . "'");
    if ($qrydel) {
        $showError = true;
        $errorContent = 'Item deleted successfully.';
    } else {
        echo '<script>alert("Error: ' . $sql . "<br>" . mysqli_error($conn) . '")</script>';
        // echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}
?>

<div class="container mt-5 w-50">
    <h3>Customer Detail</h3>
    <?php
    $customer = mysqli_fetch_assoc(mysqli_query($conn, "SELECT customers.* from customers LEFT JOIN quotations ON quotations.id ='" . $quotation_id . "'"));

    ?>
    <p><strong>Name:</strong><?php echo $customer['name']; ?></p>
    <p><strong>Email:</strong> <?php echo $customer['email']; ?></p>
    <p><strong>Phone:</strong> <?php echo $customer['phone']; ?></p>
    <p><strong>Address:</strong> <?php echo $customer['address']; ?></p><br>

    <h3>Add Items to Quotation</h3>

    <?php
    if ($showAlert) {

        echo ' <div class="alert alert-success alert-dismissible fade show" role="alert">
  <strong>' . $alertContent . ' </strong> Item successfully Updated!.
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div> ';
    }
    if ($showError) {

        echo ' <div class="alert alert-danger alert-dismissible fade show" role="alert">
  ' . $errorContent . '
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div> ';
    }
    ?>
    <form action="add_items.php" method="POST">
        <div class="row mb-3">
            <div class="col">
                <select name="item_id" class="form-control" required>
                    <option value="">Select Item</option>
                    <?php
                    // all items
                    $user_id = $_SESSION['user_id'];
                    $all_items = mysqli_query($conn, "SELECT * FROM items WHERE user_id = '$user_id'");
                    while ($item = mysqli_fetch_assoc($all_items)) { ?>
                        <option value="<?php echo $item['id']; ?>">
                            <?php echo $item['name']; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>

            <div class="col">
                <input type="number" name="quantity" class="form-control" placeholder="Quantity" required>
            </div>

            <div class="col">
                <input type="number" step="0.01" name="price" class="form-control" placeholder="Price" required>
            </div>

            <div class="col">
                <button class="btn btn-success" name="quotationItem" type="submit">Add</button>
                <!-- <input class="btn btn-success" name="quotationItem" type="submit" value="Add"> -->
            </div>
        </div>
    </form>

    <h5>Items Already Added</h5>
    <table class="table table-bordered">
        <tr>
            <th>Item</th>
            <th>Qty</th>
            <th>Price</th>
            <th>Total</th>
            <th>Action</th>
        </tr>
        <?php
        //already added items
        $added_sql1 = mysqli_query($conn, "
        SELECT quotation_items.id, quotation_items.quantity, quotation_items.price, items.name, items.id AS item_id
        FROM quotation_items
        JOIN items ON items.id = quotation_items.item_id
        WHERE quotation_id = '$quotation_id'
        ");

        echo "<script>console.log('Top Called -- $quotation_id')</script>";

        $add_sql = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from quotations WHERE id= '$quotation_id'"));
        if (isset($_SESSION['quotation_item_id'])) {
            if (!empty($add_sql)) {
                echo "<script>console.log('already added item checking Called')</script>";
                $add_customer_id = $add_sql['customer_id'];

                $added_sql2 = mysqli_query($conn, "
            SELECT quotations.*, quotation_items.*
            FROM quotations
            LEFT JOIN quotation_items ON quotation_items.quotation_id = quotations.id
            WHERE customer_id = '$add_customer_id'
            ");

                $sql_id = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from quotation_items WHERE id= '" . $_SESSION['quotation_item_id'] . "'"));

                if (isset($sql_id)) {
                    $added_sql3 = mysqli_query($conn, "
                    SELECT quotation_items.id, quotation_items.quantity, quotation_items.price, items.name, items.id AS item_id
                    FROM quotation_items
                    JOIN items ON items.id = quotation_items.item_id
                    WHERE quotation_id = '" . $sql_id['quotation_id'] . "'
                    ");
                }

            }
        }

        if (isset($added_sql2) and isset($added_sql3)) {
            if (mysqli_num_rows($added_sql2) > 0 and mysqli_num_rows($added_sql3) > 0) {
                echo "<script>console.log('already added items called!')</script>";
                // echo "<script>console.log('" . $added_sql2['id'] . $added_sql3['id'] . "')</script>";
                $added_items = $added_sql3;
            }
        } else {
            if (mysqli_num_rows($added_sql1) > 0) {
                echo "<script>console.log('Added items called!')</script>";
                $added_items = $added_sql1;
            }
        }

        if (isset($added_items)) {
            $i = 0;
            while ($row = mysqli_fetch_assoc($added_items)) {

                $quote_select_items = '';
                $quote_select_item = [];
                $total = $row['quantity'] * $row['price'];
                $user_id = $_SESSION['user_id'];
                $all_items = mysqli_query($conn, "SELECT * FROM items WHERE user_id = '$user_id'");
                while ($all_row = mysqli_fetch_assoc($all_items)) {
                    // echo "<script>console.log(".implode(' ', $all_row).")</script>";
                    $select_item = [];
                    foreach ($all_row as $key => $itemData) {
                        // echo "<script>console.log(\"[{'$key': '$itemData'}]\")</script>";
                        array_push($select_item, " {'$key':'$itemData'} ");
                    }
                    array_push($quote_select_item, "[" . implode(' ', $select_item) . "]");
                }
                $quote_item_data = "{quotation_item_id: " . $row['id'] . ",quantity: " . $row['quantity'] . ", price: " . $row['price'] . "}";
                $quote_select_items = implode('/', $quote_select_item);
                ?>
                <tr>
                    <td><?php echo $row['name']; ?></td>
                    <td><?php echo $row['quantity']; ?></td>
                    <td>Rs <?php echo $row['price']; ?></td>
                    <td>Rs <?php echo $total; ?></td>
                    <td>

                        <a href="" class="btn btn-sm btn-success"
                            onclick="setModelData(<?php echo $quote_item_data; ?>,&quot;<?php echo $quote_select_items; ?>&quot;)"
                            data-bs-toggle="modal" data-bs-target="#exampleModal">
                            Update -
                        </a>
                        <!-- Modal -->
                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <form action="add_items.php" method="post" class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Update '<?php echo $row['id']; ?>'
                                            Quotation Item</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label class="form-label"><strong>Select Item</strong></label>
                                            <select name="quotation_item" class="form-control border border-success bg-light"
                                                required id="quote_item_update">
                                                <option value="">Select Item</option>
                                            </select>
                                            <!-- <select name="quotation_item" class="form-control border border-success bg-light"
                                                required id="quote_item_update">
                                                <option value="">Select Item</option>
                                                <?php
                                                // all items
                                                $user_id = $_SESSION['user_id'];
                                                $all_items = mysqli_query($conn, "SELECT * FROM items WHERE user_id = '$user_id'");
                                                while ($item = mysqli_fetch_assoc($all_items)) { ?>
                                                    <option value="<?php echo $item['id']; ?>"<?php echo $item['id'] == $row['item_id'] ? 'selected' : '' ?>>
                                                        <?php echo $item['name']; ?>
                                                    </option>
                                                <?php } ?>
                                            </select> -->
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label"><strong>Quantity</strong></label>
                                            <input name="quotation_qty" value="<?php echo $row['quantity']; ?>"
                                                id="quote_quantity_update" class="form-control border border-success bg-light"
                                                (change)="enterDirectRowNumberResponse(data,$event.target.value)" required />
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label"><strong>Price</strong></label>
                                            <input name="quotation_price" value="<?php echo $row['price']; ?>"
                                                id="quote_price_update" class="form-control border border-success bg-light"
                                                required />
                                        </div>
                                    </div>

                                    <input type="hidden" name="quotation_item_id" id="quote_item_id_update"
                                        value="<?php echo $row['id']; ?>">
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

                                        <input type="submit" value="Save changes" name="quotationItemUpdate"
                                            class="btn btn-primary">
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- <a href="#" class="btn btn-sm btn-success">Update</a> -->
                        <a href="?did=<?php echo $row['id'] ?>" class="btn btn-sm btn-danger"
                            onClick="return confirm('Are you delete Item.')">Delete</a>
                    </td>
                </tr>
            <?php }
        } ?>
    </table>

    <a href="select_terms.php" class="btn btn-primary">Next= Select Terms</a>
</div>

<script>
    function setModelData(row, item_data) {
        // console.log(item_data);
        var quote_item_update = document.getElementById('quote_item_update');
        var quote_select_items = item_data.split("/");
        console.log(quote_select_items);
        for (var select_item in quote_select_items) {
            console.log(quote_select_items[select_item]);
            select_item = quote_select_items[select_item].split(' ')
            var id = '';
            var name = '';
            var cc = 0;
            for (var item in select_item) {
                var string = select_item[item];

                    if(string.length > 1){
                    //   if(string != '[' || string != ']'){
                        eval('var obj=' + string);
                        if (obj['id']) {
                            id = obj.id;
                            console.log('-----ID-----'); 
                    }
                        if (obj['name']) {
                            name = obj.name;
                            console.log(`-----Name-----name`); 
            }
                    }
        
                    cc++;
                    console.log(`${string}==${cc}`); 
            }
                    var opt = document.createElement('option');
                    opt.value = id;
                    opt.innerHTML = name+' '+id;
                    quote_item_update.appendChild(opt);
        }
        // console.log(JSON.parse(item_data));
        // for (var i = 0; i<=length(row); i++){
        // }

        document.getElementById('quote_quantity_update').value = row['quantity'];
        document.getElementById('quote_price_update').value = row['price'];
        document.getElementById('quote_item_id_update').value = row['quotation_item_id'];

        // const form = document.querySelector('#modelForm');
        // form.action = `{{ url('admin/manage_color') }}/${data['id']}?_method=PUT`;
    }
</script>
<?php include '../sidebar/sidebar_footer.php'; ?>