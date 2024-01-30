<?php include('includes/header.php'); ?>
<?php include('includes/menu.php'); ?>
<div class="container">
    <?php 
    $articolo_da_visualizzare = show_article($art_slug); 
    echo "<h3>".$articolo_da_visualizzare['title']."</h3>";
    ?>
    <?php 
    if($articolo_da_visualizzare['link_image']!=null) {
        echo '<img src="'.$articolo_da_visualizzare['link_image'].'" class="img-fluid" style="max-height:400px;">';
    }
    ?>
    <p><?php echo $articolo_da_visualizzare['description']; ?></p>
   
    
</div>
<?php include('includes/footer.php'); ?>
