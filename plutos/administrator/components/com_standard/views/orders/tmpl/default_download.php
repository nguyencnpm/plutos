<?php

defined('_JEXEC') or die;

// Load the export form 
$title = JText::_('COM_STANDARD_ORDERS_DOWNLOAD');
$urlSelect = JRoute::_('index.php?option=com_standard&amp;view=download&amp;tmpl=component');
$footer = '<a class="btn" data-dismiss="modal" type="button"'
        . ' onclick="jQuery(\'#downloadModal iframe\').contents().find(\'#closeBtn\').click();">'
        . JText::_('COM_STANDARD_CANCEL') . '</a>';
$footer .= '<button class="btn btn-success" type="button"'
        . ' onclick="jQuery(\'#downloadModal iframe\').contents().find(\'#exportBtn\').click();">'
        . JText::_('COM_STANDARD_ORDERS_EXPORT') . '</button>';

echo JHtml::_(
        'bootstrap.renderModal', 'downloadModal', array(
        'title' => $title,
        'url' => $urlSelect,
        'height' => '245px',
        'width' => '300px',
        'modalWidth' => '40',
        'footer' => $footer
    )
);


