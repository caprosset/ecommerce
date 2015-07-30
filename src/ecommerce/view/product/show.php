<?php
    use ecommerce\model\Comment;
    use ecommerce\model\Product;
	
    /* @var $oProduct Product */
?>


<div class="content clearfix">
	
	
    <div class="thumbnail">
        <img class="img-responsive img-rounded" src="<?php echo $oProduct->getImage(); ?>" alt="">
		
        <div class="caption-full">
            <h4 class="pull-right"><?php echo $oProduct->getPrice(); ?> &euro;</h4>
            <h4><a href="index.php?page=product&action=show&id=<?php echo $oProduct->getId(); ?>"><?php echo $oProduct->getName(); ?></a>
			</h4>
            <p><?php echo $oProduct->getDescription(); ?></p>
		</div>
		
		<p>
			<?php
				foreach($aCategories as $category){  ?>
				<span class="label label-success"><?php echo $category->getName() ?></span>
			<?php }  ?>
		</p>
        <div class="ratings">
            <p class="pull-right"><?php echo count($aComments) ?> reviews</p>
			
            <p>
                <?php for($i=0; $i<=4; $i++ ) { ?>
					 <?php if ($i < $oProduct->getRating()){  ?>
                        <span class="glyphicon glyphicon-star"></span>
						<?php } else { ?>
                        <span class="glyphicon glyphicon glyphicon-star-empty"></span>
					<?php } ?>
					
				<?php } ?>
                <?php echo $oProduct->getRating() ?> stars
			</p>
		</div>
	</div>
	
	<p >
		<form id="addtocart" method="post" action="index.php?page=product&action=addtocart" class="form-inline">
			<input type="hidden" name="product" value="<?= $oProduct->getId(); ?>"/>
			<input type="number" name="quantity" class="form-control" value="1"/>
			<button class="btn btn-primary" type="submit" name="addToCart">
				<span class="glyphicon glyphicon-shopping-cart"></span>&nbsp;Ajouter au panier
			</button>
		</form>
	</p>
	
	
	<div class="well">	
		<p>
			<form id="comment-form" method="post" action="index.php?page=product&action=addcomment" class="form-horizontal">
				<p>
					<div class="text-right">
						<button class="btn btn-primary" type="submit" id="add-comment" name="add-comment">
							<span class="glyphicon glyphicon-comment"></span>&nbsp;Ajouter un commentaire
						</button>
					</div>
				</p>
				<input type="hidden" name="product-id" value="<?= $oProduct->getId(); ?>"/>
				
				<div class="form-group">
					<label for="name" class="col-sm-2 control-label">Nom</label>
					<div class="col-sm-10">
	               <input class="form-control" type="text" name="name" placeholder="your name"> 
	            </div>
	         </div>

				<div class="form-group">
					<label for="comment" class="col-sm-2 control-label">Commentaire</label>
					<div class="col-sm-10">
						<textarea class="form-control" name="comment" id="comment"></textarea>
					</div>
				</div>
				
				<div class="form-group">
					<label for="email" class="col-sm-2 control-label">Email</label>
					<div class="col-sm-10">
						<input type="email" class="form-control" name="email" id="email" placeholder="Email">
					</div>
				</div>
				
	         <div class="form-group">
					<label for="rate" class="col-sm-2 control-label">Evaluation</label>
					<div class="col-sm-10">
	         		<div class="rate"></div><br>
	         	</div>
	         </div>
			
			</form>
			
		</p>
		
		
		
		
		
		
        <hr>
		
		
		<?php foreach ($aComments as $oComment): ?>
		<div class="row">
			<div class="col-md-12">
				<p>
					<div class="fixedRate" data-score="<?php echo $oComment->getMark();?>"></div>
               <?php //for($i=0; $i<=4; $i++ ) { ?>
						<?php //if ($i < $oComment->getMark()){  ?>
                  	<!-- <span class="glyphicon glyphicon-star"></span> -->
						<?php //} else { ?>
                  	<!-- <span class="glyphicon glyphicon glyphicon-star-empty"></span> -->
						<?php //} ?>
					<?php //} ?>
            	<?php echo $oComment->getMark() ?> stars
				</p>

				<?= $oComment->getUser()->getFirstName(); ?>
				<span class="pull-right"><?php $dateOld = $oComment->getDateOld(); ?>
					<?php if ($dateOld['years'] > 0){  ?>
						<p>Posted <?php echo $dateOld['years'] . " years, " . $dateOld['months'] . " months and " . $dateOld['days'] . " days ago"; ?></p>
					<?php } else if ($dateOld['months'] > 0){ ?>
						<p>Posted <?php echo $dateOld['months'] . " months and " . $dateOld['days'] . " days ago"; ?></p>
					<?php } else { ?>
						<p>Posted <?php echo $dateOld['days'] . " days ago"; ?></p>
					<?php } ?>
				</span>
				<p><?= $oComment->getComment(); ?></p>
			</div>
		</div>
		<hr>
		<?php endforeach; ?>
		
	</div>
	
</div>



        <hr>
        <!-- Title -->
        <div class="row">
            <div class="col-lg-12">
                <h3>Produit similaire</h3>
            </div>
        </div>
        <!-- /.row -->

        <!-- Page Features -->
        <div class="row text-center">

				<?php foreach ($aSimilarProducts as $oSimilar): ?>
            <?php //var_dump($aSimilarProducts); ?>
            <div class="col-md-3 col-sm-6 hero-feature">
                <div class="thumbnail">
                    <img src="<?= $oSimilar->getImage(); ?>" alt="">
                    <div class="caption">
                        <h3><?= $oSimilar->getName(); ?></h3>
                        <p><?= $oSimilar->getShortDescription(300); ?></p>
                        <!-- Autre façon plus artisanale de limiter le nb char de la description
                        	<p><? //echo substr($oSimilar->getDescription(), 0, 50)."..."; ?></p>
                     	-->
                        <p>
                            <a href="#" class="btn btn-primary">Buy Now!</a> <a href="index.php?page=product&amp;action=show&amp;id=<?= $oSimilar->getId() ?>" class="btn btn-default">More Info</a>
                        </p>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>

           
        </div>
        <!-- /.row -->


<script>
$(document).ready( function () {
    $(function() {
		//twitter bootstrap script
        $('form#comment-form').on('submit', function(e) {

            // Empêcher le comportement par défaut du navigateur, c-à-d de soumettre le formulaire
            e.preventDefault();


				// L'objet jQuery du formulaire
				var $this = $(this);

				// Envoi de la requête HTTP en mode asynchrone
            $.ajax({
                type: $this.attr('method'), // La méthode indiquée dans le formulaire (get ou post) : "POST",
                url: $this.attr('action'), // La méthode indiquée dans le formulaire (get ou post): "index.php?page=product&action=addcomment",
                data: $this.serialize(),  // Sérialisation les données (Envoyer toutes les valeurs présentes dans le formulaire): $$this.serialize(),    // Sérialisation les données (Envoyer toutes les valeurs présentes dans le formulaire): ('#comment-form').serialize(),

             	success: function(msg){
					// msg : le message retourné par la requête ajax
					if(msg != ''){
						// Une erreur s'est produite
						alert("ERREUR: [" +  msg + "]");
					}
					else {
						alert("Votre commentaire a été enregistré avec succès");
					}
					},
					error: function(){
						alert("ERREUR: Une erreur s'est produite lors de l'ajout de votre commentaire");
					}
            });
        });
		
			$('form#addtocart').on('submit', function(e) {
				// Empêcher le comportement par défaut du navigateur, c-à-d de soumettre le formulaire
            e.preventDefault();


				// L'objet jQuery du formulaire
				var $this = $(this);

				// Envoi de la requête HTTP en mode asynchrone
            $.ajax({
                type: $this.attr('method'), // La méthode indiquée dans le formulaire (get ou post) : "POST",
                url: $this.attr('action'), // La méthode indiquée dans le formulaire (get ou post): "index.php?page=product&action=addtocart",
                data:  $this.serialize(),  // Sérialisation les données (Envoyer toutes les valeurs présentes dans le formulaire): $$this.serialize(),    // Sérialisation les données (Envoyer toutes les valeurs présentes dans le formulaire): ('#addtocart').serialize(),

             	success: function(msg){
					// msg : le message retourné par la requête ajax
					if(msg != ''){
						// Une erreur s'est produite
						alert("ERREUR: [" +  msg + "]");
					}
					else {
						alert("Votre produit a été ajouté au panier");
					}
					},
					error: function(){
						alert("ERREUR: Une erreur s'est produite lors de l'ajout du produit à votre panier");
					}
            });
			});


    });
});
</script>
