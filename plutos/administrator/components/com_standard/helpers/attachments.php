<?php

/**
 * @package     Giaiphapcongnghethongtin.Administrator
 * @subpackage  com_standard
 * @author Binh Nguyen
 * 
 * @copyright   Copyright (C) 2017 - 2018 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;

jimport('joomla.filesystem.file');
// jimport('joomla.filesystem.folder');

/**
 * attachments and resizing helper
 */
class AttachmentsHelper {

    /**
     * Constructor
     * 
     * @param object $params
     */
    function __construct($params) {
        // init vars
        $this->app = JFactory::getApplication();
        $this->params = $params;
    }

    public function CheckAttachments($file) {
        // Total length of post back data in bytes.
        $contentLength = (int) $_SERVER['CONTENT_LENGTH'];

        // Maximum allowed size of post back data in MB.
        $postMaxSize = self::toBytes(ini_get('post_max_size'));

        // Maximum allowed size of script execution in MB.
        $memoryLimit = self::toBytes(ini_get('memory_limit'));

        // Check for the total size of post back data.
        if (($postMaxSize > 0 && $contentLength > $postMaxSize) || ($memoryLimit != -1 && $contentLength > $memoryLimit)) {
            JError::raiseWarning(100, JText::_('ERROR_WARNUPLOADTOOLARGE'));

            return false;
        }

        // Check for the total size of post back data.
        if (($postMaxSize > 0 && $contentLength > $postMaxSize) || ($memoryLimit != -1 && $contentLength > $memoryLimit)) {
            JError::raiseWarning(100, JText::_('ERROR_WARNUPLOADTOOLARGE'));

            return false;
        }
        if (isset($file) && is_array($file)) {
            $totalSize = 0;
            // Media file names should never have executable extensions buried in them.
            $executable = array(
                'php', 'js', 'exe', 'phtml', 'java', 'perl', 'py', 'asp', 'dll', 'go', 'ade', 'adp', 'bat', 'chm', 'cmd', 'com', 'cpl', 'hta', 'ins', 'isp',
                'jse', 'lib', 'mde', 'msc', 'msp', 'mst', 'pif', 'scr', 'sct', 'shb', 'sys', 'vb', 'vbe', 'vbs', 'vxd', 'wsc', 'wsf', 'wsh',
            );

            foreach ($file as $aFile) {
                if ($aFile['size'] <= 0) {
                    continue;
                }
                $totalSize += $aFile['size'];
                // Perform basic checks on file info before attempting anything
                $aFile['name'] = JFile::makeSafe($aFile['name']);
                $aFile['name'] = str_replace(' ', '-', $aFile['name']);
                //$aFile['filepath'] = JPath::clean(implode(DIRECTORY_SEPARATOR, array(COM_MEDIA_BASE, $this->folder, $aFile['name'])));


                $filetypes = explode('.', $aFile['name']);
                if (count($filetypes) < 2) {
                    // There seems to be no extension
                    $this->app->enqueueMessage(JText::_('JLIB_MEDIA_ERROR_WARNFILETYPE'), 'error');

                    return false;
                }

                array_shift($filetypes);


                $check = array_intersect($filetypes, $executable);

                if (!empty($check)) {
                    $this->app->enqueueMessage(JText::_('JLIB_MEDIA_ERROR_WARNFILETYPE'), 'error');

                    return false;
                }

                // Checks if the file is an image
                $filetype = array_pop($filetypes);

                $allowable = array_map('trim', explode(',', $this->params->get('attachment_extensions')));
                if ($filetype == '' || $filetype == false || (!in_array($filetype, $allowable))) {
                    $this->app->enqueueMessage(JText::_('JLIB_MEDIA_ERROR_WARNFILETYPE'), 'error');

                    return false;
                }
            }
            // check size
            $uploadMaxSize = $this->params->get('attachment_maxsize', 0) * 1024 * 1024;
            if (($uploadMaxSize > 0 && $totalSize > $uploadMaxSize)) {
                // File size exceed either 'upload_max_filesize' or 'attachment_maxsize'.
                //JError::raiseWarning(100, JText::_('ERROR_WARNFILETOOLARGE'));
                $this->app->enqueueMessage(JText::_('JLIB_MEDIA_ERROR_WARNFILETOOLARGE'), 'error');
                return false;
            }
        }

        if ($totalSize == 0) {
            // no file
            return false;
        }
        return true;
    }

    /**
     * Small helper function that properly converts any
     * configuration options to their byte representation.
     *
     * @param   string|integer  $val  The value to be converted to bytes.
     *
     * @return integer The calculated bytes value from the input.
     *
     * @since 3.3
     */
    public static function toBytes($val) {
        switch ($val[strlen($val) - 1]) {
            case 'M':
            case 'm':
                return (int) $val * 1048576;
            case 'K':
            case 'k':
                return (int) $val * 1024;
            case 'G':
            case 'g':
                return (int) $val * 1073741824;
            default:
                return $val;
        }
    }

}
?>


