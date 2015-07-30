<h1>Mes commandes</h1>

<?php
/** @var $oOrder Order */


use ecommerce\model\Order;

//var_dump($aAllOrders);

?>

<?php //if (count($aAllOrders) > 0): ?>
    
    <table class="table table-striped">
        <thead>
        <tr>
            <th>ID</th>
            <th>Date</th>
            <th>Détail</th>
            <th>Prix total</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($aAllOrders as $oOrder): ?>
            <tr>
               <td><?= $oOrder->getId(); ?></td>
                <td><?=$oOrder->getDate(); ?></td>
                <td><a href="index.php?page=account&action=orderdetail&id=<?= $oOrder->getId(); ?>"> Détail de la commande </a></td>
                <td><?= $oOrder->getTotal(); ?>€</td>     
            </tr>
        <?php endforeach; ?>
        </tbody>

    </table>
    <div class="clearfix"></div>

<?php //else: ?>
    <p><strong>Vous n'avez pas de commandes !</strong></p>
<?php //endif; ?>

