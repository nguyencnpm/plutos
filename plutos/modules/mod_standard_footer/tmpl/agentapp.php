<?php
/**
 * @package     giaiphapcongnghethongtin.Site
 * author       Binh Nguyen
 * @subpackage  mod_standard_footer
 */
defined('_JEXEC') or die;
?>
<div class="row">
    <div class="col-12 col-md-7">
        <h2 class="footer-title mb-4">Về Plutos</h2>
        <p>
            Plutos là nền tảng đặt dịch vụ du lịch trực tuyến dành cho đối tác đại lý, được xây dựng dựa trên kinh nghiệm hơn 27 năm kinh doanh vận hành các sản phẩm du lịch phục vụ hàng trăm đối tác trong và ngoài nước của tập đoàn Thiên Minh. Plutos mong muốn trở thành đối tác đáng tin cậy kết nối hàng chục nghìn đại lý du lịch, công ty lữ hành với các nhà cung cấp trong và ngoài nước.
        </p>
        <p>

            ĐKKD số 3301692381, ngày cấp 25/03/2021, Sở kế hoạch và đầu tư tỉnh Thửa Thiên Huế<br />
            <i class="fa fa-map-marker" aria-hidden="true"></i> <b>Huế:</b> 15 Lý Thường Kiệt, Quận Phú Nhuận, Tp. Thừa Thiên Huế<br />
            <i class="fa fa-map-marker" aria-hidden="true"></i> <b>HN:</b> 46 Nguyễn Trường Tộ, Quận Ba Đình, Tp. Hà Nội<br />
            <i class="fa fa-map-marker" aria-hidden="true"></i> <b>HCM:</b> Tầng 8, Toà nhà EMM, 157 Pasteur, Quận 3, TP HCM<br />
            <a class="hotline footer-link" href="tel:19002124"><i class="fa fa-phone" aria-hidden="true"></i> <b>Hotline:</b> 1900 2124</a> &nbsp;&nbsp;&nbsp;<i class="fa fa-envelope" aria-hidden="true"></i> info@plutos.vn
        </p>
    </div>
    <div class="col-12 col-md-5">
        <div class="row">
            <div class="col-12 col-sm-5">
                <h2 class="footer-title mb-4">Thông tin cần biết</h2>
                <div>
                    <a class="footer-link" href="./datafile/dieu-kien-va-dieu-khoan.pdf" target="_blank">Điều kiện và điều khoản</a><br />
                    <a class="footer-link" href="./datafile/quy-che-hoat-dong.pdf" target="_blank">Quy chế hoạt động</a><br />
                    <a class="footer-link" href="./datafile/chinh-sach-bao-mat-thong-tin-thanh-toan.pdf" target="_blank">Chính sách bảo mật</a><br />
                    <a class="footer-link" href="./datafile/co-che-giai-quyet-tranh-chap-phat-sinh.pdf" target="_blank">Cơ chế giải quyết tranh chấp phát sinh</a><br />

                    <?php if ($isRenderModuleFooterBlogEnabled): ?>
                        <div class="<?php echo $cContentFooterBlog; ?>">
                            <?php
                            $shareAttribs['style'] = 'footer';
                            $shareAttribs['headerLevel'] = 3;
                            foreach ($moduleFooterBlog as $blog) :
                                echo JModuleHelper::renderModule($blog, $shareAttribs);
                            endforeach;
                            ?>
                        </div>
                    <?php else: ?>
                        <br />
                    <?php endif; ?>
                </div>

                <ul class="nav footer-icon-menu mb-3">
                    <li class="nav-item">
                        <a href="https://fb.me/plutos.vn" target="_blank" title="Facebook" target="_blank" rel="noopener noreferrer">
                            <img src="./images/logo/ic_facebook.png" alt="Facebook">
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="https://zalo.me/950832068951480296" target="_blank" title="Zalo" target="_blank" rel="noopener noreferrer">
                            <img src="./images/logo/ic_zalo.png" alt="Zalo">
                        </a>
                    </li>
                </ul>
            </div>
            <div class="col-12 col-sm-7">
                <h2 class="footer-title mb-4"><span class="footer-sub-title">Một thành viên của</span> Thiên Minh Group</h2>
                <a href="https://tmgroup.vn/" target="_blank"><img src="./images/logo/TMG.png" alt="Thien Minh Group"></a>

                <h2 class="footer-title mt-4">Được chứng nhận</h2>
                <img src="./images/logo/bocongthuong.png" alt="Bo cong thuong">
            </div>
        </div>
    </div>
</div>
