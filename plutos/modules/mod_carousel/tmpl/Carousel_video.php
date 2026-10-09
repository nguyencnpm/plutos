<?php
/**
 * @package     giaiphapcongnghethongtin.Site
 * author       Binh Nguyen
 * @subpackage  mod_carousel
 */
defined('_JEXEC') or die;
?>
<style type="text/css">
    .carousel-video-inner {
        text-align: center;
    }
</style>
<div id="carouselVideoControls" class="carousel slide" data-ride="carousel" data-interval="false">
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img class="d-block w-100" src="https://cdn.rawgit.com/KimSarabia/bootstrap-carousel-sample/a1eee04b/slide-3.jpg" alt="First slide">
        </div>
        <div class="carousel-item">
            <img class="d-block w-100" src="https://cdn.rawgit.com/KimSarabia/bootstrap-carousel-sample/a1eee04b/slide-2.jpg" alt="Second slide">
        </div>
        <div class="carousel-item">
            <img class="d-block w-100" src="https://cdn.rawgit.com/KimSarabia/bootstrap-carousel-sample/a1eee04b/slide-1.jpg" alt="Third slide">
        </div>
        <div class="carousel-item">
            <div class="carousel-video-inner">
                <div id="video-player" data-video-id="0vrdgDdPApQ"></div>
            </div>
        </div>
    </div>
    <a class="carousel-control-prev" href="#carouselVideoControls" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#carouselVideoControls" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>
</div>