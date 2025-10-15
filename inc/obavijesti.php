<?php if (isset($_SESSION['administrator']) && $_SESSION['administrator'] == 0) { ?>
<?php foreach($obavjestenjauser as $obv) {?>
<div class="obavjestenje">
    <h3><?php echo $obv['naslov'];?></h3>
    <p><em><?php echo date('d.m.Y \u H:i', strtotime($obv['datum'])); ?></em></p>
    <p><?php echo $obv['poruka'];?></p>
</div>

<?php }
}?>