<h1>Mes commandes</h1>

<?php
/** @var $oOrder Order */


use ecommerce\model\Order;
use ecommerce\model\dao\OrderManager;
use ecommerce\model\dao\UserManager;

//var_dump($aAllOrders);

?>

<?php if (count($aAllOrders) > 0): ?>

    <?php $oUser = UserManager::getCurrent();   ?>
    
    <table class="table table-striped">
        <thead>
        <tr>
            <?php if($oUser) {
                    if (UserManager::getCurrent()->getRole() == 2) {  ?>
                        <th>Email client</th>
            <?php } }?>
            <th>ID</th>
            <th>Date</th>
            <th>Détail</th>
            <th>Prix total</th>
        </tr>
        </thead>


        <tbody>
        <?php foreach ($aAllOrders as $oOrder): ?>
            <tr>
            <?php
                if($oUser) {
                    if (UserManager::getCurrent()->getRole() == 2) {  ?>
                        <td><?= $oOrder->getUserMail(); ?></td>
            <?php } }?>
                <td><?= $oOrder->getId(); ?></td>
                <td><?=$oOrder->getDate(); ?></td>
                <td><a href="index.php?page=account&action=orderdetail&id=<?= $oOrder->getId(); ?>"> Détail de la commande </a></td>
                <td><?= $oOrder->getTotal(); ?>€</td>     
            </tr>
        <?php endforeach; ?>
        </tbody>

    </table>
    <div class="clearfix"></div>


<?php else: ?>
    <p><strong>Pas de commandes !</strong></p>
<?php endif; ?>


