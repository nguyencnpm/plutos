<?php

class Stringhandling extends stdClass {

    /**
     * Author     : Binh Nguyen
     * trim string with max specify
     *
     * @param string $subject
     * @param integer $length .
     */
    static function trimString($subject, $length = 60, $moretxt = '...') {
        if (!$length):
            return '';
        endif;

        $subject = str_replace('/[\r\n\s\t]+/', ' ', strip_tags($subject));
        //remove short code
        $subject = preg_replace('/\{(loadposition|ja|rk|gk)[a-z0-9\s]+\}/i', '', $subject);

        if (strlen($subject) > $length) {
            $pos = strpos($subject, ' ', $length);
            if (!$pos) {
                return substr($subject, 0, $length);
            } elseif ($pos > $length + 10) {
                return substr($subject, 0, $length) . $moretxt;
            } else {
                return substr($subject, 0, $pos) . $moretxt;
            }
        } else {
            return $subject;
        }
    }

    static function SearchImage($fulltext) {
        // Search Image
        $url_img = "";
        $regex = '/\<img.+src\s*=\s*\"([^\"]*)\"[^\>]*\>/';
        preg_match($regex, $fulltext, $matches);
        $images = (count($matches)) ? $matches : array();
        $image = count($images) > 1 ? $images[1] : '';
        if ($image) {
            $url_img = $image;
        } else {
            $url_img = "images/news.png";
        }
        return $url_img;
    }

}
