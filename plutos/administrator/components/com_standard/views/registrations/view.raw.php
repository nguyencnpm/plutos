<?php

defined('_JEXEC') or die;

class StandardViewRegistrations extends JViewLegacy {

    public function display($tpl = null) {
        $app = JFactory::getApplication();
        $doc = JFactory::getDocument();
        
        $basename = $this->get('BaseName');
        $filetype = $this->get('FileType');
        $mimetype = $this->get('MimeType');
        $content = $this->get('Content');
        
        // Check for errors.
        if (count($errors = $this->get('Errors'))) {
            throw new Exception(implode("\n", $errors), 500);
        }

        $doc->setMimeEncoding($mimetype);
        $app->setHeader(
                        'Content-disposition', 
                        'attachment; filename="' . $basename . '.' . $filetype . '"; creation-date="' . JFactory::getDate()->toRFC822() . '"', 
                        true
        );
        echo $content;
    }
    
}
