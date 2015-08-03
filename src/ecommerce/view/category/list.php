<?php
    use ecommerce\model\Category;
?>

<h1>Liste des catégories</h1>

<table class="table table-striped">
        <thead>
        <tr>
            <th>ID</th>
            <th>Nom</th>
            <th>Description</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($aCategories as $oCategory): ?>
            <tr>
                <td><?= $oCategory->getId(); ?></td>
                <td><a href="<?= $oCategory->getUrl(); ?>"><?= $oCategory->getName(); ?></a></td>
                <td><?= $oCategory->getDescription(); ?></td> 
                <td>    
                    <span>
                        <button type="submit" name="edit" value="edit" class="btn btn-success"><a href="index.php?page=category&action=edit&id=<?php echo $oCategory->getId(); ?>"><span
                              class="glyphicon glyphicon-edit"></span>&nbsp;Modifier</a>
                        </button>
                    </span>
                    <span>
                        <button type="submit" name="remove" value="remove" class="btn btn-danger"><a href="index.php?page=category&action=remove&id=<?php echo $oCategory->getId(); ?>"><span
                                class="glyphicon glyphicon-remove"></span>&nbsp;Supprimer</a>
                        </button>
                    </span>
                </td> 
            </tr>
        <?php endforeach; ?>
        </tbody>

    </table>


    <div class="col-md-12">
        <a href="index.php?page=category&action=edit"><button type="reset" class="btn btn-primary pull-left" name="addcategory" value="addcategory">Ajouter une catégorie</button></a>
            <div class="clearfix"></div>
    </div>







     
