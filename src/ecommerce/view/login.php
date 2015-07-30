<h1>Connexion</h1>

<?php if ($bConnectError): ?>
    <div class="alert alert-danger alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <strong>Erreur!</strong> Impossible de vous connecter. Vérifier votre email et votre mot de passe.
    </div>
<?php endif; ?>

<form class="form-horizontal" action="index.php?page=login" method="post" name="login" role="form">
    <div class="form-group">
        <label for="email" class="col-sm-2 control-label">Email</label>

        <div class="col-sm-10">
            <input type="email" class="form-control" name="email" id="email" placeholder="Email">
        </div>
    </div>
    <div class="form-group">
        <label for="password" class="col-sm-2 control-label">Mot de passe</label>

        <div class="col-sm-10">
            <input type="password" class="form-control" name="password" id="password" placeholder="Password">
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="btn btn-primary" name="connect">Connexion</button>
        </div>
    </div>
</form>


<h2>Ou inscription : </h2>

<form class="form-horizontal" action="index.php?page=login" method="post" name="subscribe" role="form">
    <div class="form-group">
        <label for="name" class="col-sm-2 control-label">Nom</label>

        <div class="col-sm-10">
            <input type="text" class="form-control" name="name" id="name" placeholder="Nom"/>
        </div>
    </div>
    <div class="form-group">
        <label for="firstname" class="col-sm-2 control-label">Prénom</label>

        <div class="col-sm-10">
            <input type="text" class="form-control" name="firstname" id="firstname" placeholder="Prénom"/>
        </div>
    </div>
    <div class="form-group">
        <label for="email" class="col-sm-2 control-label">Email</label>

        <div class="col-sm-10">
            <input type="email" class="form-control" name="email" id="email" placeholder="Email">
        </div>
    </div>
    <div class="form-group">
        <label for="password" class="col-sm-2 control-label">Mot de passe</label>

        <div class="col-sm-10">
            <input type="password" class="form-control" name="password" id="password" placeholder="Password">
        </div>
    </div>
    <div class="form-group">
        <label for="address" class="col-sm-2 control-label">Adresse</label>

        <div class="col-sm-10">
            <textarea class="form-control" name="address" id="address"></textarea>
        </div>
    </div>


    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="btn btn-primary" name="subscribe" value="subscribe">S'inscrire</button>
        </div>
    </div>
</form>
