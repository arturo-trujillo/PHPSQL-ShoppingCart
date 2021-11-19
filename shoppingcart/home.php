

<?php
// Get the 4 most recently added products
$stmt = $pdo->prepare('SELECT * FROM articulos ORDER BY fechaanadido DESC LIMIT 4');
$stmt->execute();
$recently_added_products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?=template_header('Home')?>

<div class="featured">
    <h2>Doña Irma</h2>
    <p>Tortilleria</p>
</div>
<div class="recentlyadded content-wrapper">
    <h2>Productos Añadidos Recientemente</h2>
    <div class="products">
        <?php foreach ($recently_added_products as $product): ?>
        <a href="index.php?page=product&id=<?=$product['idArticulo']?>" class="product">
            <img src="/imgs/<?=$product['imagenArticulo']?>" width="200" height="200" alt="<?=$product['nombreArticulo']?>">
            <span class="name"><?=$product['nombreArticulo']?></span>
            <span class="price">
                &dollar;<?=$product['precioArticulo']?>
               
            </span>
        </a>
        <?php endforeach; ?>
    </div>
</div>

<?=template_footer()?>