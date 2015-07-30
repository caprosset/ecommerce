<?php
    use ecommerce\model\Category;
?>

<h1><?= $oCategory->getName(); ?></h1>

<p><?= $oCategory->getDescription(); ?></p>
<img class="img-responsive img-rounded" src="<?php echo $oCategory->getImage(); ?>" alt="">


<?php if(isset($aProducts)){ ?>
    <h2>Produits mis en avant</h2>

    <div class="row">
        <?php foreach (array_slice($aProducts, 0, 4) as $oProduct): ?>
            <?php /* @var $oProduct \ecommerce\model\Product */ ?>
            <div class="col-sm-6">
                <div class="product thumbnail">
                    <a href="<?= $oProduct->getUrl(); ?>"><img src="<?= $oProduct->getImage(); ?>" alt=""
                                                               class="img-responsive pull-left img-rounded"/></a>

                    <h3><a href="<?= $oProduct->getUrl(); ?>"><?= $oProduct->getName(); ?></a></h3>

                    <p><?= $oProduct->getShortDescription(600); ?></p>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <?php if (count($aProducts)>4) { ?>
    <h3>Autres produits en vente</h3>
    <ul class="list-unstyled">
        
        <?php foreach (array_slice($aProducts, 4, count($aProducts)) as $oProduct): ?>
            <?php /* @var $oProduct \ecommerce\model\Product */ ?>
            <li class="row"><a href="<?= $oProduct->getUrl(); ?>" class="col-xs-2"><img
                        src="/<?= $oProduct->getImage(); ?>" alt=""
                        class="img-responsive img-rounded"/></a>

                <h3 class="col-xs-2"><a href="<?= $oProduct->getUrl(); ?>"><?= $oProduct->getName(); ?></a></h3>

                <p class="col-xs-8"><?= $oProduct->getShortDescription(600); ?></p>
            </li>
        <?php endforeach; ?>
    </ul>
    <?php } ?>



     <?php } ?>   
