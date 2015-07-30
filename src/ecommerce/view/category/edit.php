<?php
    use ecommerce\model\Category;
?>


    <?php if(array_key_exists('id', $_GET)){ ?>
        <h1>Edition categorie :</h1>
    <?php } else { ?>
        <h1>Ajout categorie :</h1>
     <?php } ?>

<form class="form-horizontal" action="index.php?page=category&amp;action=edit" method="post" name="addCategory" role="form" enctype="multipart/form-data">

    <?php if ($oCategory->getId()){ ?>
        <input type="hidden" name="category-id" value="<?= $oCategory->getId(); ?>"/>
    <?php } ?>

    <div class="form-group">
        <label for="name" class="col-sm-2 control-label">Nom</label>

        <div class="col-sm-10">
            <input type="name" class="form-control" name="name" id="name" placeholder="Nom"  value="<?= $oCategory->getName(); ?>"/>
        </div>
    </div>

    <div class="form-group">
        <label for="description" class="col-sm-2 control-label">Description</label>

        <div class="col-sm-10">
            <textarea class="form-control" name="description" id="description"><?php echo $oCategory->getDescription() ?></textarea>
        </div>
    </div>

	<div class="form-group">
		<label for="exampleInputFile1"  class="col-sm-2 control-label" >Image</label>
		<div class="col-sm-10">
			<input type="file" name="image" id="image">
		</div>
	</div>

    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <button type="reset" class="btn" name="subscribe" value="subscribe">Annuler</button>
            <button type="submit" class="btn btn-primary" name="subscribe" value="subscribe">Valider</button>
        </div>
    </div>
</form>


