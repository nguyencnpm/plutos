<?php

/**
 * @package     Giaiphapcongnghethongtin.Administrator
 * @subpackage  com_standard
 * Author     : Binh Nguyen
 * 
 * @copyright   Copyright (C) 2005 - 2018 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;

jimport('joomla.filesystem.file');
jimport('joomla.filesystem.folder');

/**
 * Image upload and resizing helper
 */
class ImageHelper {

    /**
     * @const  integer
     * @since  1.0
     */
    const SCALE_FILL = 1;

    /**
     * @const  integer
     * @since  1.0
     */
    const SCALE_INSIDE = 2;

    /**
     * @const  integer
     * @since  1.0
     */
    const SCALE_OUTSIDE = 3;

    /**
     * @const  integer
     * @since  1.0
     */
    const CROP = 4;

    /**
     * @const  integer
     * @since  1.0
     */
    const CROP_RESIZE = 5;

    /**
     * @const  integer
     * @since  1.0
     */
    const SCALE_FIT = 6;

    /**
     * @const  string
     * @since  1.2.0
     */
    const ORIENTATION_LANDSCAPE = 'landscape';

    /**
     * @const  string
     * @since  1.2.0
     */
    const ORIENTATION_PORTRAIT = 'portrait';

    /**
     * @const  string
     * @since  1.2.0
     */
    const ORIENTATION_SQUARE = 'square';

    /**
     * @var    resource  The image resource handle.
     * @since  1.0
     */
    protected $handle;

    /**
     * @var    string  The source image path.
     * @since  1.0
     */
    protected $path = null;

    /**
     * @var    array  Whether or not different image formats are supported.
     * @since  1.0
     */
    protected static $formats = array();

    /**
     * @var    LoggerInterface  Logger object
     * @since  1.0
     */
    protected $logger = null;

    /**
     * @var    boolean  Flag if an image should use the best quality available.  Disable for improved performance.
     * @since  1.4.0
     */
    protected $generateBestQuality = true;

    /**
     * Constructor
     * 
     * @param object $params
     */
    function __construct($params) {
        // init vars
        $this->app = JFactory::getApplication();
        $this->path = JPATH_ROOT . '/images/products';
        $this->root = "images/products";
        $this->params = $params;

        // check folders
        $folders = array();
        $folders[] = $this->path;
        $folders[] = $this->path . '/categories';
        $folders[] = $this->path . '/images';
        $folders[] = $this->path . '/items';
        $folders[] = $this->path . '/users';
        foreach ($folders as $folder) {
            if (!file_exists($folder)) {
                /*
                  if (!mkdir($folder, 0755)) {//Create a folder : use PHP
                  $this->app->enqueueMessage('ANY_IMAGE_ERROR_DIRECTORY', 'error');
                  }
                 */
                self::create($folder);
            }
        }
    }

    /**
     * Create a folder
     *
     * @return  boolean
     *
     * @since   1.5
     */
    public static function create($filepath) {
        if (JFolder::create($filepath)) {
            $data = "<html>\n<body bgcolor=\"#FFFFFF\">\n</body>\n</html>";
            JFile::write($filepath . '/index.html', $data);
        }
    }

    /**
     * Upload an image
     * 
     * @param type $file
     * @param type $folder
     * @param type $message
     * @return boolean
     */
    function uploadImage($file, $image_paths, $folder, $arr_sizes = null, $message = true, $keep_original = true) {
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

        // Perform basic checks on file info before attempting anything
        $file['name'] = JFile::makeSafe($file['name']);
        $file['name'] = str_replace(' ', '-', $file['name']);
        //$file['filepath'] = JPath::clean(implode(DIRECTORY_SEPARATOR, array(COM_MEDIA_BASE, $this->folder, $file['name'])));


        $filetypes = explode('.', $file['name']);
        if (count($filetypes) < 2) {
            // There seems to be no extension
            $this->app->enqueueMessage(JText::_('JLIB_MEDIA_ERROR_WARNFILETYPE'), 'error');

            return false;
        }

        array_shift($filetypes);

        // Media file names should never have executable extensions buried in them.
        $executable = array(
            'php', 'js', 'exe', 'phtml', 'java', 'perl', 'py', 'asp', 'dll', 'go', 'ade', 'adp', 'bat', 'chm', 'cmd', 'com', 'cpl', 'hta', 'ins', 'isp',
            'jse', 'lib', 'mde', 'msc', 'msp', 'mst', 'pif', 'scr', 'sct', 'shb', 'sys', 'vb', 'vbe', 'vbs', 'vxd', 'wsc', 'wsf', 'wsh',
        );

        $check = array_intersect($filetypes, $executable);

        if (!empty($check)) {
            $this->app->enqueueMessage(JText::_('JLIB_MEDIA_ERROR_WARNFILETYPE'), 'error');

            return false;
        }

        // Checks if the file is an image
        $filetype = array_pop($filetypes);

        $allowable = array_map('trim', explode(',', $this->params->get('image_upload_extensions')));
        if ($filetype == '' || $filetype == false || (!in_array($filetype, $allowable))) {
            $this->app->enqueueMessage(JText::_('JLIB_MEDIA_ERROR_WARNFILETYPE'), 'error');

            return false;
        }
        /*
          if (!$this->isImage($file['name'])) {
          $this->app->enqueueMessage(JText::sprintf('ANY_IMAGE_ERROR_FORMAT', $this->params->get('image_upload_extensions')), 'error');
          return false;
          }
         */

        // check size
        $uploadMaxSize = $this->params->get('image_upload_maxsize', 0) * 1024 * 1024;
        if (($file['error'] == 1) || ($uploadMaxSize > 0 && $file['size'] > $uploadMaxSize)) {
            // File size exceed either 'upload_max_filesize' or 'image_upload_maxsize'.
            //JError::raiseWarning(100, JText::_('ERROR_WARNFILETOOLARGE'));
            $this->app->enqueueMessage(JText::_('JLIB_MEDIA_ERROR_WARNFILETOOLARGE'), 'error');
            return false;
        }

        // delete previous files
        $this->deleteImage($image_paths);

        // copy new working image
        $filepath = "$this->path/{$folder}";
        $copy_path = "{$filepath}/{$file['name']}";
        /*
          if (!move_uploaded_file($file['tmp_name'], $copy_path)) {
          if ($message) {
          $this->app->enqueueMessage(JText::_('ANY_IMAGE_ERROR_COPY') . " $filepath", 'error');
          }
          return false;
          }
         */

        if (!JFile::upload($file['tmp_name'], $copy_path)) {
            // Error in upload
            JError::raiseWarning(100, JText::_('ERROR_UNABLE_TO_UPLOAD_FILE'));

            return false;
        }

        // create image sizes
        // jpg quality based on user preferences.
        // I'm using default compression (1) for PNG, as Joomla default is 0 (no compression).
        // Compression does not affect quality in PNG format
        $image = new JImage($copy_path);
        $properties = JImage::getImageFileProperties($copy_path); //$info = @getimagesize($copy_path);
        $ext = strtolower(JFile::getExt($file['name']));
        $quality = $ext == 'jpg' ? $this->params->get('image_quality', 89) : 1;
        //$time = time();
        $uniqid = uniqid();
        $arrayfilename = array();

        foreach (self::sizes($arr_sizes) as $size) {

            /**
             * Method to resize the current image.
             *
             * @param   mixed    $width        The width of the resized image in pixels or a percentage.
             * @param   mixed    $height       The height of the resized image in pixels or a percentage.
             * @param   boolean  $createNew    If true the current image will be cloned, resized and returned; else
             *                                 the current image will be resized and returned.
             * @param   integer  $scaleMethod  Which method to use for scaling
             *
             * @return  Image
             *
             * @since   1.0
             * @throws  \LogicException
             */
            $createNew = false;//  true
            $scaleMethod = self::SCALE_INSIDE;
            
            $resizedImage = $image->resize($this->params->get("image_$size"), $createNew, $scaleMethod);
            $resizedImage->toFile("$filepath/$size-$uniqid.$ext", $properties->type, ['quality' => $quality]); //-{$file['name']}
            $arrayfilename["image_$size"] = "{$this->root}/{$folder}/$size-$uniqid.$ext"; //-{$file['name']}
        }

        // remove original file
        if (!$keep_original) {
            if (file_exists($copy_path)) {
                unlink($copy_path);
            }
        }

        // append message
        if ($message) {
            $this->app->enqueueMessage(JText::_('ANY_IMAGE_OK_UPLOAD'));
        }

        return $arrayfilename;
    }

    /**
     * Delete image files
     * 
     * @param array $image_paths
     * 
     * @return boolean
     */
    function deleteImage($image_paths) {
        // delete files
        foreach ($image_paths as $imagePath) {
            $image_path = JPATH_ROOT . "/" . $imagePath;
            if (file_exists($image_path) && !empty($imagePath)) {
                unlink($image_path);
            }
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

    /**
     * Checks if the file is an image
     *
     * @param   string  $fileName  The filename
     *
     * @return  boolean
     *
     * @since   3.2
     */
    public function isImage($fileName) {
        static $imageTypes = 'xcf|odg|gif|jpg|png|bmp';

        return preg_match("/\.(?:$imageTypes)$/i", $fileName);
    }

    /**
     * Sizes array
     */
    public function sizes($sizes = array()) {
        if (sizeof($sizes) > 0) {
            return $sizes;
        }
        return ['full', 'big', 'screen', 'medium', 'small', 'tiny'];
    }

    /**
     * Calculate the size of a resized image
     *
     * @param   integer  $width   Image width
     * @param   integer  $height  Image height
     * @param   integer  $target  Target size
     *
     * @return  array  The new width and height
     *
     * @since   3.2
     */
    public static function imageResize($width, $height, $target) {
        /*
         * Takes the larger size of the width and height and applies the
         * formula accordingly. This is so this script will work
         * dynamically with any size image
         */
        if ($width > $height) {
            $percentage = ($target / $width);
        } else {
            $percentage = ($target / $height);
        }

        // Gets the new value and applies the percentage, then rounds the value
        $width = round($width * $percentage);
        $height = round($height * $percentage);

        return array($width, $height);
    }

}
