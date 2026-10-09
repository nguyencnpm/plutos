<?php
/**
 * @package     Giaiphapcongnghethongtin.vn.Plugin
 * @subpackage  Content.socialsharing
 * @author      Binh Nguyen
 * @copyright   Copyright (C) 2005 - 2018 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
/**
 * Social Sharing Plugin is a module using for Display icons for your online social networking sites.
 */
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

$language = $this->params->get('system-addtoany-language', 'en-US');
$customApps = $this->params->get('addthis_custom_apps');

if (trim($customApps) != '') {
    $apps = '"' . implode('","', split(',', $customApps)) . '"';
}
?>
<a class="a2a_dd" href="http://www.addtoany.com/share_save">
    <?php if ($this->params->get('addthis_button') != 'none') : ?>
        <?php if (!$this->params->get('used_custom_button')) : ?>
            <img src="http://static.addtoany.com/buttons/<?php echo $this->params->get('system-addtoany-button', 'share_save_256_24.png'); ?>" border="0" alt="Share/Save/Bookmark" />
        <?php else : ?>
            <img src="<?php echo $this->params->get('custom_button'); ?>" border="0" alt="Share/Save/Bookmark" />
            <?php echo $this->params->get('widget_text'); ?>
        <?php endif; ?>
    <?php endif; ?>
</a>
<script type="text/javascript">
    a2a_color_main = "<?php echo $this->params->get('system-addtoany-maincolor', 'D7E5ED'); ?>";
    a2a_color_border = "<?php echo $this->params->get('system-addtoany-border', '414c53'); ?>";
    a2a_color_link_text = "<?php echo $this->params->get('system-addtoany-linktext', '333333'); ?>";
    a2a_color_link_text_hover = "<?php echo $this->params->get('system-addtoany-linktext_hover', '333333'); ?>";
    a2a_color_bg = "<?php echo $this->params->get('system-addtoany-background', 'FFFFFF'); ?>";
    a2a_show_title =<?php echo (int) $this->params->get('system-addtoany-showpagetitle', '0'); ?>;
    a2a_orientation = "<?php echo $this->params->get('system-addtoany-orientation', 'down'); ?>";
<?php if (isset($apps)) : ?>
        a2a_prioritize = [<?php echo $apps; ?>];

<?php endif; ?>
</script>

<script type="text/javascript" src="http://static.addtoany.com/menu/locale/<?php echo $language; ?>.js" charset="utf-8"></script>
<script type="text/javascript" src="http://static.addtoany.com/menu/page.js"></script>