<meta charset="UTF-8"> 
<h1>Modification de l'adresse</h1>


<form class="form-horizontal" action="index.php?page=account&action=address" method="post" name="update" role="form">
    

    <div class="form-group">
        <label for="address" class="col-sm-2 control-label">Adresse :</label>
        <div class="col-sm-10">
            <textarea class="form-control" name="address" id="address" value=""><?php echo $oUser->getAddress(); ?></textarea>
        </div>
    </div>

    <div class="form-group">
        <label for="cp" class="col-sm-2 control-label">Code Postal :</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" name="cp" id="cp" value="<?php echo $oUser->getCp(); ?>"></input>
        </div>
    </div>

    <div class="form-group">
        <label for="city" class="col-sm-2 control-label">Ville :</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" name="city" id="city" value="<?php echo $oUser->getCity(); ?>"></input>
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="btn btn-primary pull-left" name="submit" value="submit">Valider les modifications</button>
        </div>
    </div>

    <?php //var_dump($oUser); ?>
</form>
