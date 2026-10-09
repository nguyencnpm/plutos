<?php
/**
 * author       Binh Nguyen! Project
 * @package     Giaiphapcongnghethongtin.Site
 * @subpackage  com_standard
 *
 * @copyright   Copyright (C) 2017 - 2018 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('JPATH_BASE') or die;

// Create a shortcut for params.
$params = $displayData->params;
$canEdit = $displayData->params->get('access-edit');
JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');

$app = JFactory::getApplication();
$template = $app->getTemplate(true);
$templateParams = $template->params;
$templateParams->get('tooltip_viewport');
$tooltip = $templateParams->get('tooltip_viewport');
?>

<?php if ($displayData->state == 0 || $params->get('show_title') || ($params->get('show_author') && !empty($displayData->author))) : ?>
    <div class="item-header">
        <?php if ($params->get('show_title')) : ?>
            <h2 class="item-title" itemprop="name"> <?php //  cut-string-multiple-lines one-line ?>
                <?php if ($params->get('link_titles') && ($params->get('access-view') || $params->get('show_noauth', '0') == '1')) : ?>
                    <a href="<?php
                    echo JRoute::_(
                            StandardHelperRoute::getProductRoute($displayData->slug, $displayData->catid, $displayData->language)
                    );
                    ?>" itemprop="url">
                        <span 
                        <?php
                        switch ($templateParams->get('tooltip_viewport')) {
                            case 'hasPopover':
                                echo ' title="' . $this->escape($displayData->title) . '"';
                                echo ' data-content="' . htmlspecialchars($displayData->introtext) . '"';
                                break;

                            default:
                                echo ' title="' . htmlspecialchars($displayData->title) . '"';
                                break;
                        }
                        ?>
                            class="fa fa-info-circle custom-icon-info-circle <?php echo $tooltip; ?>" aria-hidden="true">
                        </span>
                        <?php echo $this->escape($displayData->title); ?>
                    </a>
                <?php else : ?>
                    <span 
                    <?php
                    switch ($templateParams->get('tooltip_viewport')) {
                        case 'hasPopover':
                            echo ' title="' . $this->escape($displayData->title) . '"';
                            echo ' data-content="' . htmlspecialchars($displayData->introtext) . '"';
                            break;

                        default:
                            echo ' title="' . htmlspecialchars($displayData->introtext) . '"';
                            break;
                    }
                    ?>
                        class="fa fa-info-circle custom-icon-info-circle <?php echo $tooltip; ?>" aria-hidden="true">
                    </span>
                    <?php echo $this->escape($displayData->title); ?>
                <?php endif; ?>
            </h2>
        <?php endif; ?>

        <?php if ($displayData->state == 0) : ?>
            <span class="label label-warning"><?php echo JText::_('JUNPUBLISHED'); ?></span>
        <?php endif; ?>

        <?php if (strtotime($displayData->publish_up) > strtotime(JFactory::getDate())) : ?>
            <span class="label label-warning"><?php echo JText::_('JNOTPUBLISHEDYET'); ?></span>
        <?php endif; ?>

        <?php if ($displayData->publish_down != JFactory::getDbo()->getNullDate() && (strtotime($displayData->publish_down) < strtotime(JFactory::getDate()))): ?>
            <span class="label label-warning"><?php echo JText::_('JEXPIRED'); ?></span>
        <?php endif; ?>
    </div>
<?php endif; ?>
