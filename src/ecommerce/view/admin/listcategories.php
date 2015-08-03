<?php
    use ecommerce\model\Category;
?>

<h1>Liste des catégories</h1>


<?php if (count($aCategories) > 0): ?>

<table class="table table-striped">
        <thead>
        <tr>
            <th>ID</th>
            <th>Nom</th>
            <th>Description</th>
            <th>Nombre de produits</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($aCategories as $aCategory): ?>
            <tr>
                <td><?= $aCategory['id']; ?></td>
                <td><a href="index.php?page=category&action=show&id=<?= $aCategory['id']; ?>"><?= $aCategory['name']; ?></a></td>
                <td><?= $aCategory['description']; ?></td> 
                <td><?= $aCategory['nb_produits']; ?></td> 
            </tr>
        <?php endforeach; ?>
        </tbody>

</table>


<div id="flotcontainer"></div>

<?php else: ?>
    <p><strong>Pas de categories !</strong></p>
<?php endif; ?>



 

<!-- Javascript: graph #flotcontainer -->
<script type="text/javascript">
$(function () { 
    var data =
         [
            <?php 
                foreach ($aCategories as $aCategory){ 
                    echo "{label: '" . $aCategory['name'] . "' , data: " . $aCategory['nb_produits'] . "},";
                } 
            ?>
        ];
 
    var options = {
            series: {
                pie: {show: true}
                    }
         };
 
    $.plot($("#flotcontainer"), data, options);  
});
</script>
 





