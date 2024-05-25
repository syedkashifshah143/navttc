<?php
include "query.php";
include "header.php";
?>
<!-- Blank Start -->
<div class="container-fluid pt-4 px-4">
                <div class="row vh-100 bg-light rounded  mx-0">
                    <div class="col-md-12 p-4">
                        <h3>Orders</h3>
                        <div class="container-fluid pt-4 px-4">
                <div class="bg-light text-center rounded p-4">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <h6 class="mb-0">All Sales</h6>
                        <a href="">Refresh</a>
                    </div>
                    <div class="table-responsive">
                        <table class="table text-start align-middle table-bordered table-hover mb-0">
                            <thead>
                                <tr class="text-dark">
                                    <th scope="col"><input class="form-check-input" type="checkbox"></th>
                                    <th scope="col">Invoice ID</th>
                                    <th scope="col">Customer Name</th>
                                    <th scope="col">Customer Email</th>
                                    <th scope="col">Total Price</th>
                                    <th scope="col">Total Quantity</th>
                                    <th scope="col">Order Date & Time</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $query = $pdo->query("select * from invoices");
                                $Allinvoices = $query->fetchAll(PDO::FETCH_ASSOC);
                                foreach ($Allinvoices as $invoice) {
                                    
                                
                                ?>
                                <tr>
                                    <td><input class="form-check-input" type="checkbox"></td>
                                    <td><?php echo $invoice['id'] ?></td>
                                    <td><?php echo $invoice['u_name'] ?></td>
                                    <td><?php echo $invoice['u_email'] ?></td>
                                    <td><?php echo $invoice['total_price'] ?></td>
                                    <td><?php echo $invoice['total_qty'] ?></td>
                                    <td><?php echo $invoice['dateTime'] ?></td>
                                    <?php
                                        if($invoice['status'] == "Pending"){
                                        ?>
                                        <td>
                                            <form action="email.php" method="post">   
                                            <input type="hidden" name="userEmail" value="<?php echo $invoice['u_email'] ?>"> 
                                            <button class="btn btn-sm btn-primary" name="sendEmail" >Confirm Order</button>
                                            </form>
                                            
                                        </td>
                                        <?php
                                        }
                                        else{
                                        ?>
                                        <td>
                                            <form action="email.php" method="post">   
                                            <button class="btn btn-sm btn-primary" name="" >Approved</button>
                                            </form>
                                        </td>
                                    <?php
                                        }
                                    ?>
                                </tr>
                                    <?php
                                    }
                                    ?>
                                    
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
                    </div>
                </div>
 </div>
 <!-- Blank End -->


<?php
include "footer.php";
?>