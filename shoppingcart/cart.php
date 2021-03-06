<?php
// If the user clicked the add to cart button on the product page we can check for the form data
if (isset($_POST['product_id'], $_POST['quantity']) && is_numeric($_POST['product_id']) && is_numeric($_POST['quantity'])) {
    // Set the post variables so we easily identify them, also make sure they are integer
    $product_id = (int)$_POST['product_id'];
    $quantity = (int)$_POST['quantity'];
    // Prepare the SQL statement, we basically are checking if the product exists in our databaser
    $stmt = $pdo->prepare('SELECT * FROM articulos WHERE idArticulo = ?');
    $stmt->execute([$_POST['product_id']]);
    // Fetch the product from the database and return the result as an Array
    $product = $stmt->fetch(PDO::FETCH_ASSOC);
    // Check if the product exists (array is not empty)
    if ($product && $quantity > 0) {
        // Product exists in database, now we can create/update the session variable for the cart
        if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
            if (array_key_exists($product_id, $_SESSION['cart'])) {
                // Product exists in cart so just update the quanity
                $_SESSION['cart'][$product_id] += $quantity;
            } else {
                // Product is not in cart so add it
                $_SESSION['cart'][$product_id] = $quantity;
            }
        } else {
            // There are no products in cart, this will add the first product to cart
            $_SESSION['cart'] = array($product_id => $quantity);
        }
    }
    // Prevent form resubmission...
    header('location: index.php?page=cart');
    exit;
}

// Remove product from cart, check for the URL param "remove", this is the product id, make sure it's a number and check if it's in the cart
if (isset($_GET['remove']) && is_numeric($_GET['remove']) && isset($_SESSION['cart']) && isset($_SESSION['cart'][$_GET['remove']])) {
    // Remove the product from the shopping cart
    unset($_SESSION['cart'][$_GET['remove']]);
}

// Update product quantities in cart if the user clicks the "Update" button on the shopping cart page
if (isset($_POST['update']) && isset($_SESSION['cart'])) {
    // Loop through the post data so we can update the quantities for every product in cart
    foreach ($_POST as $k => $v) {
        if (strpos($k, 'quantity') !== false && is_numeric($v)) {
            $id = str_replace('quantity-', '', $k);
            $quantity = (int)$v;
            // Always do checks and validation
            if (is_numeric($id) && isset($_SESSION['cart'][$id]) && $quantity > 0) {
                // Update new quantity
                $_SESSION['cart'][$id] = $quantity;
            }
        }
    }
    // Prevent form resubmission...
    header('location: index.php?page=cart');
    exit;
}

// Send the user to the place order page if they click the Place Order button, also the cart should not be empty
if (isset($_POST['placeorder']) && isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    

    $nombre= $_POST['name'];
    $descripcion= $_POST['articulo']; 
    $importe = $_POST['importe'];
    $direccion= $_POST['dir'];
    $stmt = $pdo->prepare('INSERT INTO pedidos (nombreCliente , descripcion, importePedido, direccionPedido ) VALUES (? ,? ,? ,?)');
    $stmt->execute([$nombre, $descripcion, $importe, $direccion]);
    
    
    header('Location: index.php?page=placeorder');
    exit;
}

// Check the session variable for products in cart
$products_in_cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : array();
$products = array();
$subtotal = 0.00;
// If there are products in cart
if ($products_in_cart) {
    // There are products in the cart so we need to select those products from the database
    // Products in cart array to question mark string array, we need the SQL statement to include IN (?,?,?,...etc)
    $array_to_question_marks = implode(',', array_fill(0, count($products_in_cart), '?'));
    $stmt = $pdo->prepare('SELECT * FROM articulos WHERE idArticulo IN (' . $array_to_question_marks . ')');
    // We only need the array keys, not the values, the keys are the id's of the products
    $stmt->execute(array_keys($products_in_cart));
    // Fetch the products from the database and return the result as an Array
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    // Calculate the subtotal
    foreach ($products as $product) {
        $subtotal += (float)$product['precioArticulo'] * (int)$products_in_cart[$product['idArticulo']];
    }
}
?>

<?=template_header('Cart')?>

<div class="cart content-wrapper">
    <h1>Carrito</h1>
    <form action="index.php?page=cart" method="post">
        <table>
            <thead>
                <tr>
                    <td colspan="2">Articulo</td>
                    <td>Precio</td>
                    <td>Cantidad</td>
                    <td>Subotal</td>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($products)): ?>
                <tr>
                    <td colspan="5" style="text-align:center;">No hay productos en el carrito.</td>
                </tr>
                <?php else: ?>
                    <?php  $articulos ='';?>
                <?php foreach ($products as $product): ?>
                    
                    <tr>
                        <td class="img">
                            <a href="index.php?page=product&id=<?=$product['idArticulo']?>">
                                <img src="/imgs/<?=$product['imagenArticulo']?>" width="50" height="50" alt="<?=$product['nombreArticulo']?>">
                            </a>
                        </td>
                        <td>
                            <a class='articulo'  href="index.php?page=product&id=<?=$product['idArticulo']?>"><?=$product['nombreArticulo']?></a>
                            <br>
                            <a href="index.php?page=cart&remove=<?=$product['idArticulo']?>" class="remove">Eliminar</a>
                        </td>
                        <td class="price">&dollar;<?=$product['precioArticulo']?></td>
                        <td class="quantity">
                            <input type="number" name="quantity-<?=$product['idArticulo']?>" value="<?=$products_in_cart[$product['idArticulo']]?>" min="1" max="<?=$product['cantidadArticulo']?>" placeholder="Quantity" required>
                        </td>
                        <td class="price">&dollar;<?=$product['precioArticulo'] * $products_in_cart[$product['idArticulo']]?></td>
                    </tr>
                 <?php  $articulos= $articulos.$product['nombreArticulo'].' || Cantidad= '.$products_in_cart[$product['idArticulo']].' ||'?> 
                <?php endforeach; ?>
                <input type='hidden' name='articulo' id='articulo'  value ='<?=$articulos?>'> </input>
                <?php endif; ?>
            </tbody>
        </table>
        <div class="subtotal">
            <span class="text">Total</span>
            <span class="price" id='imp' name='imp'>&dollar;<?=$subtotal?></span>
        </div>
        <div class="buttons">
            <input type="submit" value="Actualizar" name="update">
            <input type="submit" value="Ordenar" name="placeorder" >
            
        </div>
        <p>Datos de Envio</p>
        <label for="name">Nombre :  </label>
        <input type="text" id="name" name="name" required minlength="4" maxlength="20" size="30">
        <br><br>
        <label for="surname">Apellidos:  </label>
        <input type="text" id="surname" name="surname" required minlength="4" maxlength="50" size="30">  
        <br><br>        
        <label for="dir">Direccion:  </label>
        <input type="text" id="dir" name="dir" required minlength="4" maxlength="100" size="50">
        <br><br>
        <div>
            <label for="name">Metodo de pago:  </label>
            <select name="select">
                <option value="value1">Tarjeta Debito/Credito</option>
                <option value="value2" selected>Paypal</option>
                <option value="value3">Efectivo</option>
            </select>
            
            <input type='hidden' id='importe' name = 'importe' value ='<?=$subtotal?>'> </input>
    </form>
</div>

<?=template_footer()?>

<?php 
    function addorder(){

     
    }
?>   