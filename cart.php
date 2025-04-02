<?php
// Include the configuration file that contains constants like CURRENCY
require "config/constants.php";
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Ecommerce</title>
    <!-- Bootstrap CSS for styling -->
    <link rel="stylesheet" href="css/bootstrap.min.css"/>
    <!-- jQuery for JavaScript functions -->
    <script src="js/jquery2.js"></script>
    <!-- Bootstrap JavaScript for UI components -->
    <script src="js/bootstrap.min.js"></script>
    <!-- Custom JavaScript file -->
    <script src="main.js"></script>
    <!-- Custom CSS file -->
    <link rel="stylesheet" type="text/css" href="style.css"/>
</head>
<body>

<!-- Loading animation overlay -->
<div class="wait overlay">
    <div class="loader"></div>
</div>

<!-- Navigation bar -->
<div class="navbar navbar-inverse navbar-fixed-top">
    <div class="container-fluid">    
        <div class="navbar-header">
            <!-- Responsive navigation button for mobile view -->
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#collapse" aria-expanded="false">
                <span class="sr-only">navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a href="#" class="navbar-brand">Ecommerce</a>
        </div>
        <!-- Collapsible navigation items -->
        <div class="collapse navbar-collapse" id="collapse">
            <ul class="nav navbar-nav">
                <li><a href="index.php"><span class="glyphicon glyphicon-home"></span> Home</a></li>
                <li><a href="index.php"><span class="glyphicon glyphicon-modal-window"></span> Product</a></li>
            </ul>
        </div>
    </div>
</div>

<!-- Space for layout adjustment -->
<p><br/></p>
<p><br/></p>
<p><br/></p>

<div class="container-fluid">
    <!-- Cart message display area -->
    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8" id="cart_msg">
            <!-- Cart messages like "Item added" will be shown here -->
        </div>
        <div class="col-md-2"></div>
    </div>

    <!-- Cart checkout section -->
    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8">
            <div class="panel panel-primary">
                <div class="panel-heading">Cart Checkout</div>
                <div class="panel-body">
                    <!-- Cart table header -->
                    <div class="row">
                        <div class="col-md-2 col-xs-2"><b>Action</b></div>
                        <div class="col-md-2 col-xs-2"><b>Product Image</b></div>
                        <div class="col-md-2 col-xs-2"><b>Product Name</b></div>
                        <div class="col-md-2 col-xs-2"><b>Quantity</b></div>
                        <div class="col-md-2 col-xs-2"><b>Product Price</b></div>
                        <div class="col-md-2 col-xs-2"><b>Price in <?php echo CURRENCY; ?></b></div>
                    </div>
                    <!-- Cart items will be dynamically loaded here -->
                    <div id="cart_checkout"></div>

                    <!-- Uncomment this section if you want to show a sample cart item -->
                    <!-- 
                    <div class="row">
                        <div class="col-md-2">
                            <div class="btn-group">
                                <a href="#" class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span></a>
                                <a href="" class="btn btn-primary"><span class="glyphicon glyphicon-ok-sign"></span></a>
                            </div>
                        </div>
                        <div class="col-md-2"><img src='product_images/imges.jpg'></div>
                        <div class="col-md-2">Product Name</div>
                        <div class="col-md-2"><input type='text' class='form-control' value='1'></div>
                        <div class="col-md-2"><input type='text' class='form-control' value='5000' disabled></div>
                        <div class="col-md-2"><input type='text' class='form-control' value='5000' disabled></div>
                    </div> 
                    -->

                    <!-- Uncomment this section if you want to show total price -->
                    <!-- 
                    <div class="row">
                        <div class="col-md-8"></div>
                        <div class="col-md-4">
                            <b>Total $500000</b>
                        </div> 
                    </div> 
                    -->
                </div>
                <div class="panel-footer"></div>
            </div>
        </div>
        <div class="col-md-2"></div>
    </div>
</div>

<!-- JavaScript variable for currency -->
<script>var CURRENCY = '<?php echo CURRENCY; ?>';</script>

</body>    
</html>
