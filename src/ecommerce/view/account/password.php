<meta charset="UTF-8"> 
<h1>Modification du mot de passe</h1>


<form class="form-horizontal" action="index.php?page=account&action=password" method="post" name="update" role="form">
    
    <div class="form-group">
        <label for="email" class="col-sm-2 control-label">Email :</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" name="email" id="email" value="<?php echo $oUser->getEmail(); ?>" readonly></input>
        </div>
    </div>

    <div class="form-group">
        <label for="password" class="col-sm-2 control-label">Password:</label>
        <div class="col-sm-10">
            <input type="password" class="form-control" name="password" id="password" value=""></input>
        </div>
    </div>

    <div class="form-group">
        <label for="newpassword" class="col-sm-2 control-label">New password:</label>
        <div class="col-sm-10">
            <input type="password" class="form-control" name="newpassword" id="newpassword" value=""></input>
        </div>
    </div>

    <div class="form-group">
        <label for="passwordconfirmation" class="col-sm-2 control-label">Confirm new password:</label>
        <div class="col-sm-10">
            <input type="password" class="form-control" name="passwordconfirmation" id="passwordconfirmation" value=""></input>
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="btn btn-primary pull-left" name="submit" value="submit">Valider les modifications</button>
        </div>
    </div>

    <?php var_dump($oUser); ?>
   </form>