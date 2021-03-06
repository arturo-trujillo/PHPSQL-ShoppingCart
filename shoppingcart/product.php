<?php
// Check to make sure the id parameter is specified in the URL
if (isset($_GET['id'])) {
    // Prepare statement and execute, prevents SQL injection
    $stmt = $pdo->prepare('SELECT * FROM articulos WHERE idArticulo = ?');
    $stmt->execute([$_GET['id']]);
    // Fetch the product from the database and return the result as an Array
    $product = $stmt->fetch(PDO::FETCH_ASSOC);
    // Check if the product exists (array is not empty)
    if (!$product) {
        // Simple error to display if the id for the product doesn't exists (array is empty)
        exit('Product does not exist!');
    }
} else {
    // Simple error to display if the id wasn't specified
    exit('Product does not exist!');
}
?>
<?=template_header('Product')?>

<div class="product content-wrapper">
    <img src="/imgs/<?=$product['imagenArticulo']?>" width="500" height="500" alt="<?=$product['nombreArticulo']?>">
    <div>
        <h1 class="name"><?=$product['nombreArticulo']?></h1>
        <span class="price">
            &dollar;<?=$product['precioArticulo']?>
        </span>
        <form action="index.php?page=cart" method="post">
        <input type="number" name="quantity" value="1" min="1" max="<?=$product['cantidadArticulo']?>" placeholder="Quantity" required> 
        <input type="hidden" name="product_id" value="<?=$product['idArticulo']?>">
            <input type="submit" value="Añadir a Carrito">
        </form>
    </div>
</div>

<?=template_footer()?>