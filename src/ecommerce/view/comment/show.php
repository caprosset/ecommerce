<?php
    use ecommerce\model\Comment;
    use ecommerce\model\Product;
	
    /* @var $oProduct Product */
?>

<h1>Description du commentaire</h1>


		<div>
			<p><a href="index.php?page=product&amp;action=show&amp;id=<?php echo $oComment->getProduct()->getId();?>"><?= $oComment->getProduct()->getName(); ?></a></p>
			<p><?= $oComment->getName(); ?></p>
			<p><?= $oComment->getUser()->getEmail();?></p>
			<p><?= $oComment->getComment();?></p>
			<p><?= $oComment->getMark(); ?> stars</p>
			<p><?= $oComment->getDate(); ?></p>
		</div>

		<?php //var_dump($oComment); ?>

		<form>
        <button type="submit" name="edit" value="edit" class="btn btn-success"><a href="index.php?page=comment&amp;action=approve&amp;productid=<?php echo $oComment->getProduct()->getId();?>&amp;email=<?php echo $oComment->getUser()->getEmail();?>"><span
                class="glyphicon glyphicon-edit"></span>&nbsp;Valider</a>
        </button>
        <button type="submit" name="remove" value="remove" class="btn btn-danger"><a href="index.php?page=comment&amp;action=remove&amp;productid=<?php echo $oComment->getProduct()->getId();?>&amp;email=<?php echo $oComment->getUser()->getEmail();?>"><span
                class="glyphicon glyphicon-remove"></span>&nbsp;Supprimer</a>
        </button>
		</form>