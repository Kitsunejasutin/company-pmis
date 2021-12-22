<?php
    require_once 'connection.php';
    if(isset($_POST['name'])){
        $sql = "SELECT * FROM stocks WHERE product_name LIKE '%".$_POST['name']."%' LIMIT 1";
        $result = mysqli_query($connection, $sql);

        if(mysqli_num_rows($result)>0){ session_start();?>
            <form action="includes/stocks.php" method="POST" id="search-result">
                <input readonly type="text" id="name" name="name" value="<?php echo $_POST['name']; ?>" style="display:none;"required>
                <input readonly type="text" id="admin" name="admin" value="<?php echo $_SESSION['FName'] ." ". $_SESSION['MName'] ." ". $_SESSION['LName']; ?>" style="display:none;"required>
                <?php while($row=mysqli_fetch_array($result)){ ?>
                    <div class="row">
                        <div class="col-25">
                            <label for="lname">Product Code</label>
                        </div>
                        <div class="col-75">
                            <input readonly type="text" id="code" name="code" value="<?php echo $row[2]; ?>" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-25">
                            <label for="lname">Product Category</label>
                        </div>
                        <div class="col-75">
                            <input readonly type="text" id="category" name="category" value="<?php echo $row[3]; ?>" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-25">
                            <label for="lname">Product Quantity</label>
                        </div>
                        <div class="col-75">
                            <input readonly type="text" id="quantity" name="quantity" value="<?php echo $row[4]; ?>" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-25">
                            <label for="lname">Product Supplier</label>
                        </div>
                        <div class="col-75">
                            <input readonly type="text" id="supplier" name="supplier" value="<?php echo $row[5]; ?>" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-25">
                            <label for="lname">Product Price</label>
                        </div>
                        <div class="col-75">
                            <input readonly type="text" id="price" name="price" value="<?php echo $row[6]; ?>" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-25">
                            <label for="lname">Customer Name</label>
                        </div>
                        <div class="col-75">
                            <input type="text" id="customer-name" name="customer_name" placeholder="Customer Name..." required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-25">
                            <label for="lname">Customer Quantity</label>
                        </div>
                        <div class="col-75">
                            <input type="number" id="customer-quantity" name="customer_quantity" placeholder="Customer Quantity..." required>
                        </div>
                    </div>
                    <div class="row">
                    <a class="action" name="multiply" id="multiply" onclick="multiply()">Generate Price</a>
                    <script>    function multiply() {
                        console.log("xD")
                        var a = $('#customer-quantity').val();
                        var b = $('#price').val();
                        $('#newproductprice').val(a * b);
                    }  </script>
                    </div>
                    <div class="row">
                        <div class="col-25">
                            <label for="lname">Overall Price</label>
                        </div>
                        <div class="col-75">
                            <input readonly type="number" id="newproductprice" name="newproductprice" placeholder="Price..." required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-25">
                            <label for="lname">Payment Status</label>
                        </div>
                        <div class="col-75">
                            <select name="status">
                                <option value="Paid">Paid</option>
                                <option value="To be follow">To be follow</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <button type="Submit" class="submit" name="submit">Confirm Order</button>
                    </div>
                <?php }?>
            </form>
        <?php }else{
            echo "Data not found";
        }
    }else{
        echo "parang may mali dito ah";
    }
?>
