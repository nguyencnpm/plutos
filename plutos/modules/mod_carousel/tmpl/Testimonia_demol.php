<?php
/**
 * @package     giaiphapcongnghethongtin.Site
 * author       Binh Nguyen
 * @subpackage  mod_carousel
 */
defined('_JEXEC') or die;
?>
<div id="MyTestimonial" class="testimonial carousel slide" data-ride="carousel">
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img class="first-slide" src="" alt="First slide">
        </div>
        <div class="carousel-item">
            <img class="second-slide" src="" alt="Second slide">
        </div>
    </div>

    <div class="control-prev-next">
        <a class="btn btn-primary testimonial-control-prev" href="#MyTestimonial" role="button" data-slide="prev">
            <span class="fa fa-angle-left fa-1x" aria-hidden="true"></span>
            <span class="sr-only"><?php echo JText::_('Previous') ?></span>
        </a>
        <a class="btn btn-primary testimonial-control-next" href="#MyTestimonial" role="button" data-slide="next">
            <span class="fa fa-angle-right fa-1x" aria-hidden="true"></span>
            <span class="sr-only"><?php echo JText::_('Next') ?></span>
        </a>
    </div>
</div>