<?php
/**
 * @package     giaiphapcongnghethongtin.Site
 * author       Binh Nguyen
 * @subpackage  mod_carousel
 */
defined('_JEXEC') or die;
?>

<div id="gpCarouselSmallThumbnails" class="carousel slide" data-ride="carousel">

<!--    <ol class="carousel-indicators">
        <li data-target="#gpCarousel" data-slide-to="0" class="active"></li>
        <li data-target="#gpCarousel" data-slide-to="1"></li>
        <li data-target="#gpCarousel" data-slide-to="2"></li>
    </ol>-->

    <div class="carousel-inner text-center">
        <div class="carousel-item active">
            <img style="height: 500px;" class="first-slide" src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" alt="First slide">
            <div class="container">
                <div class="carousel-caption text-left">
                    <h1>Example headline.</h1>
                    <p>Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.</p>
                    <p><a class="btn btn-lg btn-primary" href="#" role="button">Sign up today</a></p>
                </div>
            </div>
        </div>
        <div class="carousel-item">
            <img style="height: 500px;" class="second-slide" src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" alt="Second slide">
            <div class="container">
                <div class="carousel-caption">
                    <h1>Another example headline.</h1>
                    <p>Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.</p>
                    <p><a class="btn btn-lg btn-primary" href="#" role="button">Learn more</a></p>
                </div>
            </div>
        </div>
        <div class="carousel-item">
            <img style="height: 500px;" class="third-slide" src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" alt="Third slide">
            <div class="container">
                <div class="carousel-caption text-right">
                    <h1>One more for good measure.</h1>
                    <p>Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.</p>
                    <p><a class="btn btn-lg btn-primary" href="#" role="button">Browse gallery</a></p>
                </div>
            </div>
        </div>
    </div>

    <div class="carousel-multiple-items carousel slide" data-ride="carousel">
        <div class="carousel-inner row w-100 mx-auto" role="listbox">
            <div data-target="#gpCarouselSmallThumbnails" data-slide-to="0" class="carousel-multiple-item carousel-item col-12 col-sm-6 col-md-4 col-lg-3 active">
                <img style="height: 200px; background-color: red;" class="first-slide"  alt="First slide">
            </div>
            <div data-target="#gpCarouselSmallThumbnails" data-slide-to="1" class="carousel-multiple-item carousel-item col-12 col-sm-6 col-md-4 col-lg-3">
                <img style="height: 200px;  background-color: greenyellow;" class="second-slide"  alt="Second slide">
            </div>
            <div data-target="#gpCarouselSmallThumbnails" data-slide-to="2" class="carousel-multiple-item carousel-item col-12 col-sm-6 col-md-4 col-lg-3">
                <img style="height: 200px;  background-color: green;" class="third-slide"  alt="Third slide">
            </div>
        </div>
    </div>
    <a class="carousel-control-prev" href="#gpCarouselSmallThumbnails" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#gpCarouselSmallThumbnails" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>
</div>

