<?php 
session_start();

/**
 * SQL Queries for managing the 'products' table, 'categories' table, and 'brands' table.
 * The code below defines the functionality for managing products, categories, and brands in an e-commerce platform.
 */
 
class Products
{
    private $con; // Database connection object

    function __construct()
    {
        include_once("Database.php"); // Including the database connection class
        $db = new Database(); // Instantiating the database class
        $this->con = $db->connect(); // Establishing database connection
    }

    // Function to fetch all products along with their associated categories and brands
    public function getProducts(){
        // Query to fetch product details along with categories and brands
        $q = $this->con->query("SELECT p.product_id, p.product_title, p.product_price,p.product_qty, p.product_desc, p.product_image, p.product_keywords, c.cat_title, c.cat_id, b.brand_id, b.brand_title FROM products p JOIN categories c ON c.cat_id = p.product_cat JOIN brands b ON b.brand_id = p.product_brand");

        $products = [];
        if ($q->num_rows > 0) { 
            // Fetching each product and storing it in the $products array
            while($row = $q->fetch_assoc()){
                $products[] = $row;
            }
            $_DATA['products'] = $products;
        }

        // Fetching all categories
        $categories = [];
        $q = $this->con->query("SELECT * FROM categories");
        if ($q->num_rows > 0) {
            // Storing categories in $categories array
            while($row = $q->fetch_assoc()){
                $categories[] = $row;
            }
            $_DATA['categories'] = $categories;
        }

        // Fetching all brands
        $brands = [];
        $q = $this->con->query("SELECT * FROM brands");
        if ($q->num_rows > 0) {
            // Storing brands in $brands array
            while($row = $q->fetch_assoc()){
                $brands[] = $row;
            }
            $_DATA['brands'] = $brands;
        }

        // Returning the data in the response
        return ['status'=> 202, 'message'=> $_DATA];
    }

    // Function to add a new product to the database
    public function addProduct($product_name, $brand_id, $category_id, $product_desc, $product_qty, $product_price, $product_keywords, $file){

        // Extracting file details and validating the image format
        $fileName = $file['name'];
        $fileNameAr = explode(".", $fileName);
        $extension = end($fileNameAr);
        $ext = strtolower($extension);

        // If the image format is valid
        if ($ext == "jpg" || $ext == "jpeg" || $ext == "png") {

            // Check image size (2MB max)
            if ($file['size'] > (1024 * 2)) {
                
                $uniqueImageName = time()."_".$file['name']; // Creating a unique name for the image file
                // Moving the uploaded image to the server folder
                if (move_uploaded_file($file['tmp_name'], $_SERVER['DOCUMENT_ROOT']."/ecommerce-app-h/product_images/".$uniqueImageName)) {
                    
                    // Inserting the product into the 'products' table
                    $q = $this->con->query("INSERT INTO `products`(`product_cat`, `product_brand`, `product_title`, `product_qty`, `product_price`, `product_desc`, `product_image`, `product_keywords`) VALUES ('$category_id', '$brand_id', '$product_name', '$product_qty', '$product_price', '$product_desc', '$uniqueImageName', '$product_keywords')");

                    // Checking if the query was successful
                    if ($q) {
                        return ['status'=> 202, 'message'=> 'Product Added Successfully..!'];
                    } else {
                        return ['status'=> 303, 'message'=> 'Failed to run query'];
                    }

                } else {
                    return ['status'=> 303, 'message'=> 'Failed to upload image'];
                }

            } else {
                return ['status'=> 303, 'message'=> 'Large Image ,Max Size allowed 2MB'];
            }

        } else {
            return ['status'=> 303, 'message'=> 'Invalid Image Format [Valid Formats : jpg, jpeg, png]'];
        }

    }

    // Function to edit an existing product with a new image
    public function editProductWithImage($pid, $product_name, $brand_id, $category_id, $product_desc, $product_qty, $product_price, $product_keywords, $file){

        // Extracting file details and validating the image format
        $fileName = $file['name'];
        $fileNameAr = explode(".", $fileName);
        $extension = end($fileNameAr);
        $ext = strtolower($extension);

        if ($ext == "jpg" || $ext == "jpeg" || $ext == "png") {

            // Check image size (2MB max)
            if ($file['size'] > (1024 * 2)) {
                
                $uniqueImageName = time()."_".$file['name']; // Creating a unique name for the image file
                // Moving the uploaded image to the server folder
                if (move_uploaded_file($file['tmp_name'], $_SERVER['DOCUMENT_ROOT']."/ecommerce-app-h/product_images/".$uniqueImageName)) {
                    
                    // Updating the product details in the database
                    $q = $this->con->query("UPDATE `products` SET 
                        `product_cat` = '$category_id', 
                        `product_brand` = '$brand_id', 
                        `product_title` = '$product_name', 
                        `product_qty` = '$product_qty', 
                        `product_price` = '$product_price', 
                        `product_desc` = '$product_desc', 
                        `product_image` = '$uniqueImageName', 
                        `product_keywords` = '$product_keywords'
                        WHERE product_id = '$pid'");

                    // Checking if the query was successful
                    if ($q) {
                        return ['status'=> 202, 'message'=> 'Product Modified Successfully..!'];
                    } else {
                        return ['status'=> 303, 'message'=> 'Failed to run query'];
                    }

                } else {
                    return ['status'=> 303, 'message'=> 'Failed to upload image'];
                }

            } else {
                return ['status'=> 303, 'message'=> 'Large Image ,Max Size allowed 2MB'];
            }

        } else {
            return ['status'=> 303, 'message'=> 'Invalid Image Format [Valid Formats : jpg, jpeg, png]'];
        }
    }

    // Function to edit an existing product without changing the image
    public function editProductWithoutImage($pid, $product_name, $brand_id, $category_id, $product_desc, $product_qty, $product_price, $product_keywords){

        // If product ID is provided, update the product details
        if ($pid != null) {
            $q = $this->con->query("UPDATE `products` SET 
                                    `product_cat` = '$category_id', 
                                    `product_brand` = '$brand_id', 
                                    `product_title` = '$product_name', 
                                    `product_qty` = '$product_qty', 
                                    `product_price` = '$product_price', 
                                    `product_desc` = '$product_desc',
                                    `product_keywords` = '$product_keywords'
                                    WHERE product_id = '$pid'");

            // Checking if the query was successful
            if ($q) {
                return ['status'=> 202, 'message'=> 'Product updated Successfully'];
            } else {
                return ['status'=> 303, 'message'=> 'Failed to run query'];
            }
        } else {
            return ['status'=> 303, 'message'=> 'Invalid product id'];
        }
    }

    // Function to fetch all brands
    public function getBrands(){
        $q = $this->con->query("SELECT * FROM brands");
        $ar = [];
        if ($q->num_rows > 0) {
            while ($row = $q->fetch_assoc()) {
                $ar[] = $row;
            }
        }
        return ['status'=> 202, 'message'=> $ar];
    }

    // Function to add a new category
    public function addCategory($name){
        $q = $this->con->query("SELECT * FROM categories WHERE cat_title = '$name' LIMIT 1");
        if ($q->num_rows > 0) {
            return ['status'=> 303, 'message'=> 'Category already exists'];
        } else {
            $q = $this->con->query("INSERT INTO categories (cat_title) VALUES ('$name')");
            if ($q) {
                return ['status'=> 202, 'message'=> 'New Category added Successfully'];
            } else {
                return ['status'=> 303, 'message'=> 'Failed to run query'];
            }
        }
    }

    // Function to fetch all categories
    public function getCategories(){
        $q = $this->con->query("SELECT * FROM categories");
        $ar = [];
        if ($q->num_rows > 0) {
            while ($row = $q->fetch_assoc()) {
                $ar[] = $row;
            }
        }
        return ['status'=> 202, 'message'=> $ar];
    }

    // Function to delete a product
    public function deleteProduct($pid = null){
        if ($pid != null) {
            $q = $this->con->query("DELETE FROM `products` WHERE product_id = '$pid'");
            if ($q) {
                return ['status'=> 202, 'message'=> 'Product deleted Successfully'];
            } else {
                return ['status'=> 303, 'message'=> 'Failed to delete product'];
            }
        } else {
            return ['status'=> 303, 'message'=> 'Product ID missing'];
        }
    }

    // Function to delete a category
    public function deleteCategory($cat_id = null){
        if ($cat_id != null) {
            $q = $this->con->query("DELETE FROM `categories` WHERE cat_id = '$cat_id'");
            if ($q) {
                return ['status'=> 202, 'message'=> 'Category deleted Successfully'];
            } else {
                return ['status'=> 303, 'message'=> 'Failed to delete category'];
            }
        } else {
            return ['status'=> 303, 'message'=> 'Category ID missing'];
        }
    }

    // Function to update a category
    public function updateCategory($cat_id, $new_name){
        if ($cat_id != null) {
            $q = $this->con->query("UPDATE `categories` SET cat_title = '$new_name' WHERE cat_id = '$cat_id'");
            if ($q) {
                return ['status'=> 202, 'message'=> 'Category updated Successfully'];
            } else {
                return ['status'=> 303, 'message'=> 'Failed to update category'];
            }
        } else {
            return ['status'=> 303, 'message'=> 'Category ID missing'];
        }
    }
}
?>
