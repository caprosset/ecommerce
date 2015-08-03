<?php
    use ecommerce\model\Product;
?>

<h1>Liste des produits</h1>

<table class="table table-striped">
        <thead>
        <tr>
            <th>ID</th>
            <th>Nom</th>
            <th>Description</th>
            <th>Prix</th>
            <th>Evaluation</th>
            <th>Statut</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($aProducts as $oProduct): ?>
            <tr>
                <td class="col-sm-1"><?= $oProduct->getId(); ?></td>
                <td class="col-sm-2"><a href="<?= $oProduct->getUrl(); ?>"><?= $oProduct->getName(); ?></a></td>
                <td class="col-sm-3"><?= $oProduct->getShortDescription(50); ?> <a href="index.php?page=product&action=show&amp;id=<?= $oProduct->getId(); ?>">Voir plus</a>
                </td> 
                <td class="col-sm-1"><?= $oProduct->getPrice(); ?> €</td>
                <td class="col-sm-1"><?= $oProduct->getRating(); ?> star(s)</td>
               
                <td class="col-sm-2"><a href="index.php?page=product&action=archive&id=<?= $oProduct->getId(); ?>" class="btn btn-<?= $oProduct->getActive() == 1?"success":"danger"; ?> btn-xs"><span class="glyphicon glyphicon-<?= $oProduct->getActive() == 1?"ok":"remove"; ?>"></span></a></td>

                <td class="col-sm-2">    
                    <span>
                        <button type="submit" name="edit" value="edit" class="btn btn-success"><a href="index.php?page=product&action=edit&id=<?php echo $oProduct->getId(); ?>"><span
                              class="glyphicon glyphicon-edit"></span>&nbsp;Modifier</a>
                        </button>
                    </span>
                    <span>
                        <button type="submit" name="remove" value="remove" class="btn btn-danger"><a href="index.php?page=product&action=remove&id=<?php echo $oProduct->getId(); ?>"><span
                                class="glyphicon glyphicon-remove"></span>&nbsp;Supprimer</a>
                        </button>
                    </span>
                </td> 
            </tr>
        <?php endforeach; ?>
        </tbody>

    </table>


    <div class="col-md-12">
        <a href="index.php?page=product&action=edit"><button type="reset" class="btn btn-primary pull-left" name="addcategory" value="addcategory">Ajouter un produit</button></a>
            <div class="clearfix"></div>
    </div>







     
