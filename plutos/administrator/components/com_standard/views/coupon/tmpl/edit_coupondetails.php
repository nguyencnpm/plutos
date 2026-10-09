<?php defined('_JEXEC') or die; ?>
<div class="span12 alert well">
    <?php
    if ($this->item->id):
        echo $this->loadTemplate('updatecoupon');
    else:
        echo $this->loadTemplate('generatecoupon'); // new coupon
    endif;
    ?>
</div>