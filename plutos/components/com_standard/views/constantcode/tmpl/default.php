<?php
/**
 * @package     Giaiphapcongnghethongtin.Site
 * @subpackage  com_standard
 *
 * @copyright   Copyright (C) 2005 - 2017 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;
?>
<div class="page-constantcode<?php //echo $this->pageclass_sfx;   ?>" id="constantcode">
    <div class="body-smart-tab">
        <div class="container">
            <div class="smart-tab position-relative mx-auto using-max-width-sm px-0">
                <div class="row">
                    <div class="col-12 px-0 px-md-3">
                        <?php // -- Nav tabs --   ?>
                        <ul class="nav nav-tabs d-flex justify-content-center" role="tablist">
                            <li class="nav-tab-item" role="presentation">
                                <a class="nav-tab-link active" href="#air-ticket" role="tab" data-toggle="tab">
                                    <div class="row m-0 bg-tab-inner rounded-top px-0 px-sm-1 px-sm-4 py-md-4 py-2">
                                        <div class="col-12 col-md-auto px-0 text-center">
                                            <img class=""  src="./images/icon/airplanemode_active.svg" alt="">
                                        </div>
                                        <div class="col-12 col-md-auto px-0 text-center">
                                            Vé máy bay
                                            <br class="d-block d-md-none" />
                                            <span class="d-block d-md-none" >&nbsp;</span>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li class="nav-tab-item" role="presentation">
                                <a class="nav-tab-link" href="#hotel" role="tab" data-toggle="tab">
                                    <div class="row m-0 bg-tab-inner rounded-top px-0 px-sm-1 px-sm-4 py-md-4 py-2">
                                        <div class="col-12 col-md-auto px-0 text-center"><img class=""  src="./images/icon/building.svg" alt=""></div>
                                        <div class="col-12 col-md-auto px-0 text-center">
                                            Khách sạn 
                                            <br class="d-block d-md-none" /> 
                                            <span class="d-block d-md-none" >&nbsp;</span>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li  class="nav-tab-item" role="presentation">
                                <a class="nav-tab-link" href="#loca-experience" role="tab" data-toggle="tab">
                                    <div class="row m-0 bg-tab-inner rounded-top px-0 px-sm-1 px-sm-4 py-md-4 py-2">
                                        <div class="col-12 col-md-auto px-0 text-center"><img class=""  src="./images/icon/travel.svg" alt=""></div>
                                        <div class="col-12 col-md-auto px-0 text-center">
                                            Trải nghiệm 
                                            <br class="d-block d-md-none" /> 
                                            địa phương
                                        </div> 
                                    </div>
                                </a>
                            </li>
                        </ul>

                        <?php // -- Tab panes --   ?>
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="air-ticket" role="tabpanel"  >
                                <div class="row w-100 m-0">
                                    <div class="col-12 bg-tab-content rounded">
                                        <form name="airticket" id="airticket" class="needs-validation" novalidate>
                                            <div class="row">
                                                <div class="col-auto mb-2 pl-0 pl-sm-3">
                                                    <div class="custom-control custom-radio">
                                                        <input id="two-way" name="way" type="radio" class="custom-control-input" value="2" checked required>
                                                        <label class="custom-control-label" for="two-way">Khứ hồi</label>
                                                    </div>
                                                </div>
                                                <div class="col-auto mb-2 px-0 px-sm-3">
                                                    <div class="custom-control custom-radio">
                                                        <input id="one-way" name="way" type="radio" class="custom-control-input" value="1" required>
                                                        <label class="custom-control-label" for="one-way">Một chiều</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-7 pr-lg-0">
                                                    <div class="row">
                                                        <div class="col-6 px-0 pl-sm-3 mb-3">
                                                            <div class="input-group using-bg-white rounded-left">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text icon-group-select-position-relative background-none border-0 "><img src="./images/icon/ic_flight1.svg"  alt="plane taking off"></span>
                                                                </div>
                                                                <label class="label-contact pt-2" for="from">Từ</label>
                                                                <input type="text" name="from" class="form-control custom-input-position d-block w-100 rounded-left border-0 h-auto pt-0 pb-2" id="from" placeholder="" value="Hà Nội (HAN)" required>
                                                                <!--
                                                                <select class="selectpicker custom-select-position d-block w-100 rounded-left no-arrow" id="from"  required>
                                                                    <option value="Bangkok (BKK)">Bangkok (BKK)</option>
                                                                </select>
                                                                -->
                                                            </div>
                                                        </div>
                                                        <div class="col-6 px-0 pr-sm-3 using-border-left-with-bordersecondary-light mb-3">
                                                            <div class="input-group using-bg-white rounded-right">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text icon-group-select-position-relative background-none border-0 "><img src="./images/icon/ic_flight2.svg"  alt="the plane lands"></span>
                                                                </div>
                                                                <label class="label-contact pt-2" for="to">Đến</label>
                                                                <input type="text" name="to" class="form-control custom-input-position d-block w-100 rounded-left border-0 h-auto pt-0 pb-2" id="to" placeholder="" value="Sài Gòn (SGN)" required>
                                                                <!--
                                                                <select class="selectpicker custom-select-position d-block w-100 rounded-left no-arrow" id="to"  required>
                                                                    <option value="Sài Gòn (SGN)">Sài Gòn (SGN)</option>
                                                                </select>
                                                                -->
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-6 px-0 pl-sm-3 mb-3">
                                                            <div class="field-datetimepicker">
                                                                <div class="input-group datetimepicker using-bg-white rounded-left" data-autoclose="true">
                                                                    <div class="input-group-prepend">
                                                                        <label for="start_date" class="input-group-text icon-group-select-position-relative background-none border-0 using-text-secondary-light">
                                                                            <img src="./images/icon/ic_checkin.svg"  alt="checkin">
                                                                        </label>
                                                                    </div>
                                                                    <input type="text" id="start_date" name="start_date" value="" class="form-control outline-none px-0 pt-2 pb-0 h-auto background-none border-none using-text-secondary  border-0 radius-0 required" readonly="readonly" required="" aria-required="true" placeholder="Check in" autocomplete="off">
                                                                    <label id="weekday-checkin" for="start_date" class="w-100 label-padding-left using-text-secondary-light"></label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-6 px-0 pr-sm-3 using-border-left-with-bordersecondary-light mb-3">
                                                            <div class="field-datetimepicker">
                                                                <div class="input-group datetimepicker using-bg-white rounded-right" data-autoclose="true">
                                                                    <div class="input-group-prepend">
                                                                        <label for="end_date" class="input-group-text icon-group-select-position-relative background-none border-0 using-text-secondary-light">
                                                                            <img src="./images/icon/ic_chechout.svg"  alt="chechout">
                                                                        </label>
                                                                    </div>
                                                                    <input type="text" id="end_date" name="end_date" value="" class="form-control outline-none px-0 pt-2 pb-0 h-auto background-none border-none using-text-secondary  border-0 radius-0 required" readonly="readonly" required="" aria-required="true" placeholder="Check out" autocomplete="off">
                                                                    <label id="weekday-chechout" for="end_date" class="w-100 label-padding-left using-text-secondary-light"></label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-5 px-0 px-sm-3">
                                                    <div class="row">
                                                        <div class="col-12 mb-3">
                                                            <div class="guests dropdown dropupAuto">
                                                                <button type="button" id="contact_guests" name="contact_guests" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" class="btn dropdown-toggle-split using-bg-white text-left w-100 px-3 py-2 border-0" required="" aria-required="true">
                                                                    <div class="input-group">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text pl-0 background-none border-0"><img src="./images/icon/ic_people.svg"  alt="khách"></span>
                                                                        </div>
                                                                        <div class="filter-option">
                                                                            <div class="total-count">4 khách</div>
                                                                            <div class="total-guests">2 người lớn, 1 trẻ em, 1 em bé</div>                                                                               
                                                                        </div>
                                                                    </div>
                                                                </button>

                                                                <div class="dropdown-menu w-100 px-3">
                                                                    <div class="row d-flex justify-content-between mb-2">
                                                                        <div class="col-auto">
                                                                            <a class="count"><span id="guests-count-adults">2</span> người lớn</a>
                                                                        </div>
                                                                        <div class="col-auto">
                                                                            <a class="btn using-btn-orange minus px-2 py-0" id="adults-subs-btn">-</a>
                                                                            <a class="btn using-btn-orange plus px-2 py-0" id="adults-add-btn">+</a>
                                                                        </div>
                                                                    </div>
                                                                    <div class="divider mb-2 row"></div>
                                                                    <div class="row d-flex justify-content-between mb-2">
                                                                        <div class="col-auto">
                                                                            <a class="count"><span id="guests-count-children">1</span> trẻ em</a>
                                                                        </div>
                                                                        <div class="col-auto">
                                                                            <a class="btn using-btn-orange minus px-2 py-0" id="children-subs-btn">-</a>
                                                                            <a class="btn using-btn-orange plus px-2 py-0" id="children-add-btn">+</a>
                                                                        </div>
                                                                    </div>
                                                                    <div class="divider mb-2 row"></div>
                                                                    <div class="row d-flex justify-content-between">
                                                                        <div class="col-auto">
                                                                            <a class="count"><span id="guests-count-infant">1</span> em bé</a>
                                                                        </div>
                                                                        <div class="col-auto">
                                                                            <a class="btn using-btn-orange minus px-2 py-0" id="infant-subs-btn">-</a>
                                                                            <a class="btn using-btn-orange plus px-2 py-0" id="infant-add-btn">+</a>
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                                <input type="hidden" name="adults" value="2">
                                                                <input type="hidden" name="children" value="1">
                                                                <input type="hidden" name="infant" value="1">
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <a href="" class="reset btn using-btn-orange w-100 text-white py-3 btn-contact-submit" data-toggle="modal" data-target="#account">Tìm chuyến bay</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="hotel" role="tabpanel">
                                <div class="row w-100 m-0">
                                    <div class="col-12 bg-tab-content rounded">
                                        <form id="hotel" name="hotel" class="needs-validation pt-3" novalidate>
                                            <div class="row">
                                                <div class="col-12 mb-3 px-0 px-sm-3">
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text using-bg-white border-0">
                                                                <img src="./images/icon/group.svg"  alt="checkin">
                                                            </span>
                                                        </div>
                                                        <input type="text" class="form-control input-location border-0 pl-1" id="location" placeholder="Bạn muốn đi đâu?" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-6 pr-lg-0">
                                                    <div class="row">
                                                        <div class="col-6 px-0 pl-sm-3 mb-3">
                                                            <div class="field-datetimepicker">
                                                                <div class="input-group datetimepicker using-bg-white rounded-left" data-autoclose="true">
                                                                    <div class="input-group-prepend">
                                                                        <label for="hotel_start_date" class="input-group-text icon-group-select-position-relative background-none border-0 using-text-secondary-light">
                                                                            <img src="./images/icon/ic_checkin.svg"  alt="checkin">
                                                                        </label>
                                                                    </div>
                                                                    <input type="text" id="hotel_start_date" name="start_date" value="" class="form-control outline-none px-0 pt-2 pb-0 h-auto background-none border-none using-text-secondary  border-0 radius-0 required" readonly="readonly" required="" aria-required="true" placeholder="Check in" autocomplete="off">
                                                                    <label id="weekday-checkin" for="hotel_start_date" class="w-100 label-padding-left using-text-secondary-light"></label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-6 px-0 pr-sm-3 using-border-left-with-bordersecondary-light mb-3">
                                                            <div class="field-datetimepicker">
                                                                <div class="input-group datetimepicker using-bg-white rounded-right" data-autoclose="true">
                                                                    <div class="input-group-prepend">
                                                                        <label for="hotel_end_date" class="input-group-text icon-group-select-position-relative background-none border-0 using-text-secondary-light">
                                                                            <img src="./images/icon/ic_chechout.svg"  alt="chechout">
                                                                        </label>
                                                                    </div>
                                                                    <input type="text" id="hotel_end_date" name="end_date" value="" class="form-control outline-none px-0 pt-2 pb-0 h-auto background-none border-none using-text-secondary  border-0 radius-0 required" readonly="readonly" required="" aria-required="true" placeholder="Check out" autocomplete="off">
                                                                    <label id="weekday-chechout" for="hotel_end_date" class="w-100 label-padding-left using-text-secondary-light"></label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 pl-lg-2">
                                                    <div class="row">
                                                        <div class="col-12 px-0 px-sm-3 col-md-9 mb-3">
                                                            <div class="guests dropdown dropupAuto">
                                                                <button type="button" id="hotel_guests" name="hotel_guests" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" class="btn dropdown-toggle-split using-bg-white text-left w-100 px-3 py-2 border-0" required="" aria-required="true">
                                                                    <div class="input-group">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text pl-0 background-none border-0"><img src="./images/icon/ic_people.svg"  alt="khách"></span>
                                                                        </div>
                                                                        <div class="filter-option">
                                                                            <div class="total-hotel-guests">2 người lớn, 0 trẻ em</div>    
                                                                            <div class="total-room using-text-secondary-light">1 phòng</div>
                                                                        </div>
                                                                    </div>
                                                                </button>

                                                                <div class="dropdown-menu w-100 px-3">
                                                                    <div class="row d-flex justify-content-between mb-2">
                                                                        <div class="col-auto">
                                                                            <a class="count"><span id="hotel_guests-count-room">1</span> phong</a>
                                                                        </div>
                                                                        <div class="col-auto">
                                                                            <a class="btn using-btn-orange minus px-2 py-0" id="hotel_room-subs-btn">-</a>
                                                                            <a class="btn using-btn-orange plus px-2 py-0" id="hotel_room-add-btn">+</a>
                                                                        </div>
                                                                    </div>
                                                                    <div class="divider mb-2 row"></div>

                                                                    <div class="row d-flex justify-content-between mb-2">
                                                                        <div class="col-auto">
                                                                            <a class="count"><span id="hotel_guests-count-adults">2</span> người lớn</a>
                                                                        </div>
                                                                        <div class="col-auto">
                                                                            <a class="btn using-btn-orange minus px-2 py-0" id="hotel_adults-subs-btn">-</a>
                                                                            <a class="btn using-btn-orange plus px-2 py-0" id="hotel_adults-add-btn">+</a>
                                                                        </div>
                                                                    </div>
                                                                    <div class="divider mb-2 row"></div>

                                                                    <div class="row d-flex justify-content-between">
                                                                        <div class="col-auto">
                                                                            <a class="count"><span id="hotel_guests-count-children">0</span> trẻ em</a>
                                                                        </div>
                                                                        <div class="col-auto">
                                                                            <a class="btn using-btn-orange minus px-2 py-0" id="hotel_children-subs-btn">-</a>
                                                                            <a class="btn using-btn-orange plus px-2 py-0" id="hotel_children-add-btn">+</a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <input type="hidden" name="adults" value="2">
                                                                <input type="hidden" name="children" value="0">
                                                                <input type="hidden" name="rooms" value="1">
                                                            </div>
                                                        </div>
                                                        <div class="col-12 px-0 px-sm-3 col-md-3 pl-md-0">
                                                            <a href="" class="reset btn using-btn-orange w-100 text-white py-3 btn-contact-submit"  data-toggle="modal" data-target="#account">Tìm</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="loca-experience" role="tabpanel">
                                <div class="row w-100 m-0">
                                    <div class="col-12 bg-tab-content rounded">
                                        <form id="form-loca-experience" name="hotel" class="needs-validation pt-3" novalidate>
                                            <div class="row">
                                                <div class="col-12 px-0 px-sm-3 mb-3">
                                                    Giới thiệu các trải nghiệm địa phương, đánh giá, đặc sản từng vùng miền
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-8 pl-0 pl-sm-3 col-md-9 col-lg-10 mb-3">
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text using-bg-white border-0">
                                                                <img src="./images/icon/group.svg"  alt="checkin">
                                                            </span>
                                                        </div>
                                                        <input type="text" class="form-control input-location border-0 pl-1" id="location" placeholder="Bạn muốn đi đâu?" required>
                                                    </div>
                                                </div>
                                                <div class="col-4 col-md-3 col-lg-2 mb-3 px-0 pr-sm-3">
                                                    <a href="" class="reset btn using-btn-orange w-100 text-white py-3 btn-contact-submit" data-toggle="modal" data-target="#account">Tìm</a>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12 px-0 px-sm-3 mb-3">
                                                    <span class="title-hot-key">Từ khóa hot:</span>&nbsp;&nbsp;

                                                    <span class="hot-key">Săn mây tà xùa</span>&nbsp;&nbsp;
                                                    <span class="hot-key">Xe Jeep Nam Đảo</span>&nbsp;&nbsp;
                                                    <span class="hot-key">Chèo Kayak</span>

                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="hot-deals py-4 w-100">
        <div class="container">
            <h3 class="component-title">Sản phẩm mới</h3>
            <div id="carousel-multiple-items-max3-183" class="row carousel-multiple-items-max3 carousel touch-swipe slide " data-ride="carousel" data-interval="false">

                <div class="controls-top">
                    <div class="col-auto">
                        <a class="carousel-control-prev" href="#carousel-multiple-items-max3-183" role="button" data-slide="prev">
                            <img class="" src="./images/icon/icon_av_play_circle_previous.svg" alt="Previous" title="Previous">
                        </a>
                    </div>

                    <div class="col-auto">
                        <a class="carousel-control-next" href="#carousel-multiple-items-max3-183" role="button" data-slide="next">
                            <img class="" src="./images/icon/icon_av_play_circle_next.svg" alt="Next" title="Next">
                        </a>
                    </div>
                </div>

                <div class="carousel-inner w-100 mx-auto d-flex" role="listbox">
                    <div class="carousel-multiple-item-max3 carousel-item col-12 col-md-6 col-lg-4 mb-3 active">
                        <div class="content-item using-rounded-1 px-0 py-0">
                            <div class="row">
                                <div class="d-flex col-12">
                                    <div class="flex-fill">
                                        <img class="reset h-100 w-100 object-fit-cover using-rounded-1 using-shadow" data-toggle="modal" data-target="#account" src="<?php echo JURI::root(false); ?>/images/hot_deals/BANNER-2.jpg" alt="Plutos Agent App- Ứng dụng cho đại lý du lịch thời công nghệ">
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="carousel-multiple-item-max3 carousel-item col-12 col-md-6 col-lg-4 mb-3">
                        <div class="content-item using-rounded-1 px-0 py-0">
                            <div class="row">
                                <div class="d-flex col-12">
                                    <div class="flex-fill">
                                        <img class="reset h-100 w-100 object-fit-cover using-rounded-1 using-shadow" data-toggle="modal" data-target="#account" src="<?php echo JURI::root(false); ?>/images/hot_deals/BANNER-1.jpg" alt="Plutos Agent App- Ứng dụng cho đại lý du lịch thời công nghệ">
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="carousel-multiple-item-max3 carousel-item col-12 col-md-6 col-lg-4 mb-3">
                        <div class="content-item using-rounded-1 px-0 py-0">
                            <div class="row">
                                <div class="d-flex col-12">
                                    <div class="flex-fill">
                                        <img class="reset h-100 w-100 object-fit-cover using-rounded-1 using-shadow" data-toggle="modal" data-target="#account" src="<?php echo JURI::root(false); ?>/images/hot_deals/BANNER-4.jpg" alt="Plutos Agent App- Ứng dụng cho đại lý du lịch thời công nghệ">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="carousel-multiple-item-max3 carousel-item col-12 col-md-6 col-lg-4 mb-3 ">
                        <div class="content-item using-rounded-1 px-0 py-0">
                            <div class="row">
                                <div class="d-flex col-12">
                                    <div class="flex-fill">
                                        <img class="reset h-100 w-100 object-fit-cover using-rounded-1 using-shadow" data-toggle="modal" data-target="#account" src="<?php echo JURI::root(false); ?>/images/hot_deals/BANNER-3.jpg" alt="Plutos Agent App- Ứng dụng cho đại lý du lịch thời công nghệ">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>


    <div class="marketing py-4">
        <div class="container">
            <h3 class="component-title">Lợi ích khi tham gia nền tảng Plutos</h3>
            <div class="row">

                <div class="col-lg-4 text-center">
                    <div class="rounded-circle d-flex align-items-center justify-content-center text-center mx-auto mb-3">
                        <img class="mw-100" src="./images/marketing/Plutos_Photos_1.png" alt="Tăng trưởng doanh thu tới 20%" title="Tăng trưởng doanh thu tới 20%">
                    </div>

                    <h2 class="title">Tăng trưởng doanh thu tới 20%</h2>
                    <p>
                        Nền tảng công nghệ ưu việt với kho hàng phong phú cho phép bạn dễ dàng mở rộng hệ thống đại lý và cộng tác viên
                    </p>
                </div>

                <div class="col-lg-4 text-center">
                    <div class="rounded-circle d-flex align-items-center justify-content-center text-center mx-auto mb-3">
                        <img class="mw-100"  src="./images/marketing/Plutos_Photos_2.png" alt="Tiết kiệm đến 20% chi phí" title="Tiết kiệm đến 20% chi phí">
                    </div>

                    <h2 class="title">Tiết kiệm đến 20% chi phí</h2>
                    <p>
                        Lập tức kết nối với 100,000 đối tác khách sạn, vé máy bay, và các dịch vụ địa phương với mức giá ưu đãi vượt trội, không tốn 1 đồng chi phí nhân sự
                    </p>
                </div>

                <div class="col-lg-4 text-center">
                    <div class="rounded-circle d-flex align-items-center justify-content-center text-center mx-auto mb-3">
                        <img class="mw-100"  src="./images/marketing/Plutos_Photos_3.png" alt="Quản lý việc kinh doanh tập trung dễ dàng" title="Quản lý việc kinh doanh tập trung dễ dàng">
                    </div>

                    <h2 class="title">Quản lý việc kinh doanh tập trung dễ dàng</h2>
                    <p>
                        Dễ dàng quản lý tập trung mọi giao dịch đặt chỗ, tình trạng đơn hàng, kết quản doanh thu lợi nhuận, thu chi minh bạch, hoàn toàn tự động
                    </p>
                </div>

            </div>
        </div>
    </div>
    <div class="our-customer py-4">
        <div class="container">
            <h3 class="component-title">Khách hàng của chúng tôi</h3>
            <div class="row">
                <div class="d-flex col-12 col-md-6">
                    <div class="d-flex flex-fill mb-3 bg-white">
                        <div class="row">
                            <div class="d-flex flex-column col-12">
                                <div class="w-100 mb-3">
                                    <img class="w-100" src="./images/our_customer/du-lich-truyen-thong.png" alt="" title="">
                                </div>
                                <h2 class="title px-3">Đại lý du lịch truyền thống (vé máy bay/lữ hành)</h2>
                                <div class="flex-fill px-3">
                                    <p>
                                        <img class=""  src="./images/icon/check-circle.svg" alt="">&nbsp;&nbsp;
                                        Nguồn sản phẩm du lịch <spsn class="using-text-orange">phong phú giá tốt</spsn> nhất tại Việt Nam và toàn cầu
                                    </p>
                                    <p>
                                        <img class=""  src="./images/icon/check-circle.svg" alt="">&nbsp;&nbsp;
                                        Đội ngũ hỗ trợ <spsn class="using-text-orange">chuyên nghiệp, tận tình</spsn>
                                    </p>
                                    <p>
                                        <img class=""  src="./images/icon/check-circle.svg" alt="">&nbsp;&nbsp;
                                        Dễ dàng bán hàng và quản lý việc kinh doanh <spsn class="using-text-orange">mọi lúc mọi nơi</spsn> với ứng dụng điện thoại Plutos Agent
                                    </p>
                                    <p>
                                        <img class=""  src="./images/icon/check-circle.svg" alt="">&nbsp;&nbsp;
                                        Cung cấp sản phẩm công nghệ <spsn class="using-text-orange">nhãn trắng</spsn> (White-label) khi đối tác yêu cầu
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex col-12 col-md-6">
                    <div class="d-flex flex-fill mb-3 bg-white">
                        <div class="row">
                            <div class="d-flex flex-column col-12">
                                <div class="w-100 mb-3">
                                    <img class="w-100" src="./images/our_customer/ket-noi-api.png" alt="" title="">
                                </div>
                                <h2 class="title px-3">Đối tác phân phối bằng công nghệ kết nối API</h2>
                                <div class="flex-fill px-3">
                                    <p>
                                        <img class=""  src="./images/icon/check-circle.svg" alt="">&nbsp;&nbsp;
                                        Dễ dàng <spsn class="using-text-orange">gia tăng doanh thu</spsn> và <spsn class="using-text-orange">mở rộng sản phẩm</spsn> trên nền tảng của bạn khi kết nối với kho sản phẩm của Plutos thông qua API
                                    </p>
                                    <p>
                                        <img class=""  src="./images/icon/check-circle.svg" alt="">&nbsp;&nbsp;
                                        Lựa chọn sử dụng đội ngũ hỗ trợ khách hàng của bạn hoặc ủy thác việc hỗ trợ khách hàng hoàn toàn cho Plutos
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="our-partner py-4">
        <div class="container">
            <h3 class="component-title">Đối tác của chúng tôi</h3>
            <div class="row">
                <div class="col d-flex justify-content-center mb-3">
                    <img src="./images/our_partner/VNA.png">
                </div>
                <div class="col d-flex justify-content-center mb-3">
                    <img src="./images/our_partner/VietJet_Air.png">
                </div>
                <div class="col d-flex justify-content-center mb-3">
                    <img src="./images/our_partner/Bamboo-Airways.png">
                </div>
                <div class="col d-flex justify-content-center mb-3">
                    <img src="./images/our_partner/Jetstar.png">
                </div>
                <div class="col d-flex justify-content-center mb-3">
                    <img src="./images/our_partner/Amadeus.png">
                </div>
                <div class="col d-flex justify-content-center mb-3">
                    <img src="./images/our_partner/Hotelbeds.png">
                </div>
                <div class="col d-flex justify-content-center mb-3">
                    <img src="./images/our_partner/Expedia.png">
                </div>
                <div class="col d-flex justify-content-center mb-3">
                    <img src="./images/our_partner/Vingroup.png">
                </div>
                <div class="col d-flex justify-content-center mb-3">
                    <img src="./images/our_partner/Sun-group.png">
                </div>
                <div class="col d-flex justify-content-center mb-3">
                    <img src="./images/our_partner/Group.png">
                </div>
                <div class="col-12 p-2"></div>
                <div class="col mb-3">
                    <span class="other-partner">và hàng ngàn đối tác khác...</span>
                </div>
            </div>
        </div>
    </div>


    <div class="agent-app py-4">
        <div class="container">
            <h3 class="component-title">
                Plutos Agent App 
                <span class="text-color-sub-app">- Ứng dụng cho đại lý du lịch thời công nghệ</span>
            </h3>
            <div class="row">
                <div class="d-flex col-12 col-md-6 mb-1 px-md-5">
                    <div class="flex-fill mb-2 pr-md-5">
                        <img class="h-100 w-100 object-fit-cover" src="./images/agent_app/Flying-iPhone-X-Mockups.png" alt="Plutos Agent App- Ứng dụng cho đại lý du lịch thời công nghệ">
                    </div>
                </div>
                <div class="d-flex col-12 col-md-6 mb-1">
                    <div class="row">
                        <div class="d-flex flex-column col-12">
                            <div class="flex-fill mb-2">
                                <h2 class="title-application">Tải ứng dụng Plutos Agent ngay để bắt đầu bán hàng</h2>
                                <div class="pr-md-5">
                                    <p class="pr-md-4">
                                        <img class=""  src="./images/icon/check-circle.svg" alt="">&nbsp;&nbsp;
                                        Dễ dàng tìm kiếm, so sánh giá và chất lượng dịch vụ của hàng ngàn nhà cung cấp
                                    </p>
                                    <p class="pr-md-4">
                                        <img class=""  src="./images/icon/check-circle.svg" alt="">&nbsp;&nbsp;
                                        Đặt cùng lúc nhiều loại sản phẩm dịch vụ du lịch, bất kể lúc nào bất kể đâu
                                    </p>
                                    <p class="pr-md-4">
                                        <img class=""  src="./images/icon/check-circle.svg" alt="">&nbsp;&nbsp;
                                        Quản lý doanh thu, lợi nhuận, tình trạng đơn hàng toàn bộ hệ thống đại lý của bạn một cách tập trung, số liệu sẵn sàng mọi lúc mọi nơi
                                    </p>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12"><h4 class="experience-application mb-3">Trải nghiệm thực tế trên ứng dụng</h4></div>
                                <div class="col-auto  mb-2"> 
                                    <img class="mw-100" src="./images/agent_app/qr-codeplutosapp.png" alt="Code QR">
                                </div>
                                <div class="col-auto"> 
                                    <div class="row">
                                        <div class="col-12 mb-2">
                                            <a href="">
                                                <img class="mw-100" src="./images/agent_app/app-store.png" alt="App Store">
                                            </a>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 mb-2">
                                            <a href="">
                                                <img class="mw-100" src="./images/agent_app/google-play.png" alt="Google play">
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
