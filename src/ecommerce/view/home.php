<h1>Accueil</h1>

<h2>Présentation</h2>

<p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum
    tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas
    semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo. Quisque sit amet est et sapien
    ullamcorper pharetra. Vestibulum erat wisi, condimentum sed, commodo vitae, ornare sit amet, wisi. Aenean
    fermentum, elit eget tincidunt condimentum, eros ipsum rutrum orci, sa
    gittis tempus lacus enim ac dui. Donec
    non enim in turpis pulvinar facilisis. Ut felis. Praesent dapibus, neque id cursus faucibus, tortor neque
    egestas augue, eu vulputate magna eros eu erat. Aliquam erat volutpat. Nam dui mi, tincidunt quis, accumsan
    porttitor, facilisis luctus, metus</p>
<ol>
    <li>Lorem ipsum dolor sit amet, consectetuer adipiscing elit.</li>
    <li>Aliquam tincidunt mauris eu risus.</li>
    <li>Vestibulum auctor dapibus neque.</li>
</ol>

<h2>Toutes nos catégories</h2>

<ul class="nav nav-pills">
    <?php foreach ($aCategories as $oCategory): ?>
        <?php /* @var $oCategory \ecommerce\model\Category */ ?>
        <li><a href="<?= $oCategory->getUrl(); ?>"><?= $oCategory->getName(); ?></a></li>
    <?php endforeach; ?>
</ul>

<h2>Produits en avant</h2>

<div class="row products">
    <?php foreach ($aProducts as $iCpt => $oProduct): ?>
    <?php if ($iCpt > 0 && 0 === $iCpt % 2) : ?>
        </div><div class="row products">
    <?php endif; ?>
    <?php /* @var $oProduct \ecommerce\model\Product */ ?>
    <div class="col-sm-6">
        <div class="product thumbnail clearfix">
            <a href="<?= $oProduct->getUrl(); ?>s"><img src="<?= $oProduct->getImage(); ?>" alt=""
                                                        class="img-responsive pull-left img-rounded"/></a>

            <h3><a href="<?= $oProduct->getUrl(); ?>"><?= $oProduct->getName(); ?></a></h3>

            <p><?= $oProduct->getShortDescription(300); ?></p>
        </div>
    </div>
    <?php endforeach; ?>
</div>

