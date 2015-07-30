<h1>Recapitulatif de ma commande</h1>

<p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum
    tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas
    semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo.</p>

<h2>Votre panier :</h2>
<?php //if (count($aCart) > 0): ?>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>produit</th>
            <th>prix unitaire</th>
            <th width="100">quantité</th>
            <th>total</th>

        </tr>
        </thead>
        <tbody>
        <?php foreach ($aCart as $oProduct): ?>
            <?php /* @var $oProduct \ecommerce\model\CartProduct */ ?>
            <tr>
                <form action="" method="post">
                    <input type="hidden" name="product" value="<?= $oProduct->getId(); ?>"/>
                    <td><a href="<?= $oProduct->getUrl(); ?>"><?= $oProduct->getName(); ?></a></td>
                    <td><?= $oProduct->getPrice(); ?>€</td>
                    <td><?= $oProduct->getQuantity(); ?></td>
                    <td><?= $oProduct->getTotal(); ?>€</td>
                </form>
            </tr>
        <?php endforeach; ?>
        <hr>
        </tbody>
        <tfoot>
        <tr>
            <td colspan="1">Total HT :</td>
            <td colspan="1"><?= $fTotal; ?>€</td>
            <td colspan="1">TVA :</td>
            <td colspan="1">20%</td>
            <td colspan="4">Total TTC :</td>
            <td colspan="4"><?= $fTotalTTC; ?>€</td>
        </tr>
        </tfoot>
    </table>

    <hr>
    
    <h2>Vos coordonnees :</h2>
    <h4><?= $oUser->getName(); ?> <?= $oUser->getFirstName(); ?></h4>
    <p><?= $oUser->getAddress(); ?></p>
    <p><?= $oUser->getCp(); ?> <?= $oUser->getCity(); ?></p>
    <p><?= $oUser->getEmail(); ?></p>

    <a href="index.php?page=product&action=submitorder" class="btn btn-primary pull-right">Régler ma commande</a>
    <div class="clearfix"></div>

<?php //else: ?>
<!--     <p><strong>Vous n'avez rien dans votre panier !</strong></p> -->
<?php //endif; ?>
