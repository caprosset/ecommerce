<?php
    use ecommerce\model\Comment;
    use ecommerce\model\Product;
	
    /* @var $oProduct Product */
?>

<h1>Liste des commentaires à valider</h1>

<table class="table table-bordered">
	<tr class="row head">
		<th>Produit</th>
		<th>Nom</th>
		<th>Email</th>
		<th>Commentaire</th>
		<th>Evaluation</th>
		<th>Date</th>
		<th>Statut</th>
	</tr>	
	<?php foreach ($aQueuedComments as $oComment): ?>
		<tr class="row">
			<td class="col"><a href="index.php?page=product&amp;action=show&amp;id=<?php echo $oComment->getProduct()->getId();?>"><?= $oComment->getProduct()->getName(); ?></a></td>
			<td class="col"><?= $oComment->getName(); ?></td>
			<td class="col"><?= $oComment->getUser()->getEmail();?></td>
			<td class="col"><a href="index.php?page=comment&amp;action=show&amp;productid=<?php echo $oComment->getProduct()->getId();?>&amp;email=<?php echo $oComment->getUser()->getEmail();?>"><?= $oComment->getShortComment(50);?></a></td>
			<td class="col"><?= $oComment->getMark(); ?> stars</td>
			<td class="col"><?= $oComment->getDate(); ?></td>
			<td class="col">
<!--             <ul class="list-unstyled">
                <li>
		              <button type="submit" name="edit" value="edit" class="btn btn-success"><a href="index.php?page=comment&amp;action=approve&amp;productid=<?php //echo $oComment->getProduct()->getId();?>&amp;email=<?php //echo $oComment->getUser()->getEmail();?>"><span
		                      class="glyphicon glyphicon-edit"></span>&nbsp;Valider</a>
		              </button>
                </li>
                <li>
                    <button type="submit" name="remove" value="remove" class="btn btn-danger"><a href="index.php?page=comment&amp;action=remove&amp;productid=<?php //echo $oComment->getProduct()->getId();?>&amp;email=<?php //echo $oComment->getUser()->getEmail();?>"><span
                            class="glyphicon glyphicon-remove"></span>&nbsp;Supprimer</a>
                    </button>
                </li>
            </ul> -->
			</td>
		</tr>
	<?php endforeach; ?>
	
</table>
