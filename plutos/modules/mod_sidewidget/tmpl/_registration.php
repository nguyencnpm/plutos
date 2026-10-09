<?php
/**
 * @author      Binh Nguyen! Project
 * @package     giaiphapcongnghethongtin.Site
 * @subpackage  mod_agent_app
 *
 * @copyright   Copyright (C) 2005 - 2018 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;
?>
<!-- Button trigger modal -->
<?php // -- Modal --?>
<div class="modal fade" id="account" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="accountLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content bg-modal-content steps">

            <div class="modal-header pb-2">
                <h5 class="modal-title" id="accountLabel">Đăng ký</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body pb-0">
                <div class="row ">
                    <div class="col-12 px-md-4">
                        <ul id="progressbar" class="text-center">
                            <li class="active step0" id="step1">Thông tin cá nhân</li>
                            <li class="step0" id="step2">Thông tin doanh nghiệp</li>
                            <li class="step0" id="step3">Xác nhận</li>
                        </ul>
                        <form id="registrationForm" class=""  name="registration">
                            <div class="card-step b-0 show px-md-4">
                                <div class="row">
                                    <div class="col-12 mb-2"><b>Thông tin cá nhân</b></div>
                                    <div class="col-12">
                                        <?php echo $form->getControlGroup('fullName'); ?>
                                    </div>

                                    <div class="col-12">
                                        <?php echo $form->getControlGroup('phone'); ?>

                                    </div>

                                    <div class="col-12">
                                        <?php echo $form->getControlGroup('email'); ?> 
                                    </div>

                                    <div class="col-12">
                                        <?php echo $form->getControlGroup('position'); ?>
                                    </div>
                                    <div class="col-12">
                                        <?php echo $form->getControlGroup('referrerphonenumber'); ?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <button type="button" id="next1" class="btn using-btn-orange w-100 text-white py-2 mb-4 btn-contact-submit next" onclick="validate1(0)">Tiếp theo</button>
                                    </div>
                                </div>
                            </div>

                            <div class="card-step b-0 px-md-4">
                                <div class="row">
                                    <div class="col-12 mb-2"><b>Thông tin doanh nghiệp</b></div>
                                    <div class="col-12">
                                        <?php echo $form->getControlGroup('companyName'); ?>
                                    </div>

                                    <div class="col-12">
                                        <?php echo $form->getControlGroup('rentalCode'); ?>
                                    </div>

                                    <div class="col-12">
                                        <?php echo $form->getControlGroup('city'); ?>
                                    </div>

                                    <div class="col-12">
                                        <?php echo $form->getControlGroup('nation'); ?>
                                    </div>
                                    <div class="col-12">
                                        <?php echo $form->getControlGroup('address'); ?>
                                    </div>
                                    <div class="col-12">
                                        <?php echo $form->getControlGroup('typeOfBusiness'); ?>
                                    </div>

                                    <div class="col-12">
                                        <?php echo $form->getControlGroup('revenueLevel'); ?>
                                    </div>

                                    <div class="col-12 mb-3">
                                        <?php echo $form->getControlGroup('fbWebsite'); ?>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <button type="button" id="next2" class="btn using-btn-orange w-100 text-white py-2 mb-4 btn-contact-submit next" onclick="validate2(0)">Gửi thông tin đăng ký</button>
                                    </div>
                                </div>
                            </div>

                            <div class="card-step b-0">
                                <div class="row">
                                    <div class="d-flex col-6 col-sm-7 pr-0 pt-4 pb-5">
                                        <div class="row">
                                            <div class="d-flex flex-column col-12">
                                                <div class="flex-fill mb-2">
                                                    <h2 class="title-application">
                                                        <img class=""  src="./images/icon/check-circle.svg" alt="">&nbsp;&nbsp;
                                                        Đăng ký thành công
                                                    </h2>
                                                    <p>
                                                        Cảm ơn quý khách đã đăng ký.<br />
                                                        Vui lòng kiểm tra email ngay để hoàn thành đăng ký
                                                    </p>
                                                </div>

                                                <div class="row">
                                                    <div class="col-12"><h4 class="experience-application">Tải app ngay để bắt đầu bán hàng</h4></div>
                                                    <div class="col-5  mb-2 pr-2"> 
                                                        <img class="mw-100" src="./images/agent_app/qr-codeplutosapp.png" alt="Code QR">
                                                    </div>
                                                    <div class="col-7 pl-0"> 
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

                                    <div class="d-flex col-6 col-sm-5 pb-0">
                                        <div class="flex-fill pb-0">
                                            <img class="h-100 w-100 object-fit-cover" src="./images/agent_app/app-store-registration-is-successful.png" alt="Plutos Agent App- Ứng dụng cho đại lý du lịch thời công nghệ">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php echo JHtml::_('form.token'); ?>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<?php
// -- /.Modal --?>