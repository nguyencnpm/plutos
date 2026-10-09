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
<?php // -- Modal login -- ?>
<div class="modal fade" id="logIn" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="logInLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content bg-modal-content steps">
            <div class="modal-header pb-2">
                <h5 class="modal-title" id="accountLabel">Đăng nhập</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body pb-0">
                <div class="row ">
                    <div class="col-12 px-md-4 pt-4 pb-5">
                        <div class="row">
                            <div class="col-12"><h4 class="experience-application text-center pb-4">Tải ngay ứng dụng Plutos Agent để đăng nhập, tìm kiếm, so sánh và đặt dịch vụ.</h4></div>
                            <div class="col-5  mb-2 pr-2"> 
                                <img class="mw-100 w-100" src="./images/agent_app/qr-codeplutosapp.png" alt="Code QR">
                            </div>
                            <div class="col-7 pl-0"> 
                                <div class="row">
                                    <div class="col-12 mb-2">
                                        <a href="">
                                            <img class="mw-100 w-100" src="./images/agent_app/app-store.png" alt="App Store">
                                        </a>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 mb-2">
                                        <a href="">
                                            <img class="mw-100 w-100" src="./images/agent_app/google-play.png" alt="Google play">
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
<?php // -- /.Modal login --?>
