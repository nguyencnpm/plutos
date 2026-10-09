<?php
/**
 * Description of ColumnBlock
 *
 * @author Binh Nguyen
 */
class ColumnBlock {

    //put your code here
    // ========== Start - Ham tao Block trong Template =========================

    static public function createBlock($obj, $arrModule, $Class_prefix, &$Class) {
        $newArrModule = array();
        foreach ($arrModule as $key => $val) {
            if ($obj->countModules($val) > 0) {
                //echo '<br>Vi tri  ' . $val . ' co du lieu';
                $newArrModule[] = $val;
            }
        }
        //css: 0 - 33 - 50 - 100: - . - . - .
        if (count($newArrModule) > 0) {
            //number_format nếu là số lẻ ta chỉ lấy phần số nguyên (so le,0)
            $pecent = number_format(12 / count($newArrModule), 0);
            $Class = $Class_prefix["prefix_medium"] . $pecent;
        }
        return $newArrModule;
    }

    static public function createBlockException($obj, $arrModule, $Class_prefix, &$arrClass) {
        $newArrModule = array();
        foreach ($arrModule as $key => $val) {
            if ($obj->countModules($val) > 0) {
                $newArrModule[] = $val;
            }
        }
        if (count($newArrModule) > 0) {
            $pecent = number_format(12 / count($newArrModule), 0);
            if (count($newArrModule) == 2) {
                $arrClass[$newArrModule['0']] = $Class_prefix["prefix_medium"] . ($pecent - (count($newArrModule) + 2));
                $arrClass[$newArrModule['1']] = $Class_prefix["prefix_medium"] . ($pecent + (count($newArrModule) + 2));
            } else {
                $arrClass[$newArrModule['0']] = $Class_prefix["prefix_medium"] . $pecent;
            }
        }
        return $newArrModule;
    }

    // ============ End - Ham tao Block trong Template =========================
    //--------------------------------------------------------------------------
    static public function createBlockContentarea($blockPosition, &$ClassLeft, &$ClassCom, &$ClassRight) {
        $widthcolumn_leftright = (int) $blockPosition["widthcolumn_leftright"];
        $widthcolumn = (int) $blockPosition["widthcolumn"];
        switch ($blockPosition["slidername"]) {
            case 0:

                if ($blockPosition["showLeftColumn"] > 0 and $blockPosition["showRightColumn"] > 0) {
                    $ClassLeft = 'block-left column-block ' . $blockPosition["prefix_medium"] . $widthcolumn_leftright;
                    $ClassCom = $blockPosition["prefix_medium"] . (12 - 2 * $widthcolumn_leftright);
                    $ClassRight = 'block-right column-block ' . $blockPosition["prefix_medium"] . $widthcolumn_leftright;
                } elseif ($blockPosition["showLeftColumn"] > 0 and $blockPosition["showRightColumn"] == 0) {
                    
                    $ClassLeft = 'block-left column-block ' . $blockPosition["prefix_extrasmall"] . '12';
                    $ClassLeft .= ' ' . $blockPosition["prefix_small"] . '6';
                    $ClassLeft .= ' ' . $blockPosition["prefix_medium"] . '6';
                    $ClassLeft .= ' ' . $blockPosition["prefix_large"] . $widthcolumn;
                    $ClassLeft .= ' ' . $blockPosition["prefix_extralarge"] . $widthcolumn;
                    
                    $ClassCom = $blockPosition["prefix_extrasmall"] . '12';
                    $ClassCom .= ' ' . $blockPosition["prefix_small"] . '6';
                    $ClassCom .= ' ' . $blockPosition["prefix_medium"] . '6';
                    $ClassCom .= ' ' . $blockPosition["prefix_large"] . (12 - $widthcolumn);
                    $ClassCom .= ' ' . $blockPosition["prefix_extralarge"] . (12 - $widthcolumn);
                    
                    $ClassRight = $blockPosition["prefix_extrasmall"] . '0';
                    $ClassRight .= ' ' . $blockPosition["prefix_small"] . '0';
                    $ClassRight .= ' ' . $blockPosition["prefix_medium"] . '0';
                    $ClassRight .= ' ' . $blockPosition["prefix_large"] . '0';
                     $ClassRight .= ' ' . $blockPosition["prefix_extralarge"] . '0';
                    
                } elseif ($blockPosition["showLeftColumn"] == 0 and $blockPosition["showRightColumn"] > 0) {

                    $ClassLeft = $blockPosition["prefix_extrasmall"] . '0';
                    $ClassLeft .= ' ' . $blockPosition["prefix_small"] . '0';
                    $ClassLeft .= ' ' . $blockPosition["prefix_medium"] . '0';
                    $ClassLeft .= ' ' . $blockPosition["prefix_large"] . '0';
                     $ClassLeft .= ' ' . $blockPosition["prefix_extralarge"] . '0';


                    $ClassCom = $blockPosition["prefix_extrasmall"] . '12';
                    $ClassCom .= ' ' . $blockPosition["prefix_small"] . '6';
                    $ClassCom .= ' ' . $blockPosition["prefix_medium"] . '6';
                    $ClassCom .= ' ' . $blockPosition["prefix_large"] . (12 - $widthcolumn);
                    $ClassCom .= ' ' . $blockPosition["prefix_extralarge"] . (12 - $widthcolumn);

                    $ClassRight = 'block-right column-block ' . $blockPosition["prefix_extrasmall"] . '12';
                    $ClassRight .= ' ' . $blockPosition["prefix_small"] . '6';
                    $ClassRight .= ' ' . $blockPosition["prefix_medium"] . '6';
                    $ClassRight .= ' ' . $blockPosition["prefix_large"] . $widthcolumn;
                     $ClassRight .= ' ' . $blockPosition["prefix_extralarge"] . $widthcolumn;
                    
                } else {
                    //$blockPosition["showRightColumn"] == 0 and $blockPosition["showLeftColumn"] == 0
                    //$showno = 0;
                    $ClassLeft = $blockPosition["prefix_extrasmall"] . '0';
                    $ClassCom = $blockPosition["prefix_extrasmall"] . '12';
                    $ClassRight = $blockPosition["prefix_extrasmall"] . '0';
                }

                break;

            default: // Sidebar offcanvas

                if ($blockPosition["showLeftColumn"] > 0 and $blockPosition["showRightColumn"] > 0) {
                    $ClassLeft = 'block-left column-block ' . $blockPosition["prefix_medium"] . $widthcolumn_leftright;
                    $ClassCom = $blockPosition["prefix_medium"] . (12 - (2 * $widthcolumn_leftright));
                    $ClassRight = 'block-right column-block ' . $blockPosition["prefix_medium"] . $widthcolumn_leftright . ' sidebar-offcanvas';
                } elseif ($blockPosition["showLeftColumn"] > 0 and $blockPosition["showRightColumn"] == 0) {
                    $ClassLeft = 'block-left column-block ' . $blockPosition["prefix_medium"] . $widthcolumn;
                    $ClassCom = $blockPosition["prefix_medium"] . (12 - $widthcolumn);
                    $ClassRight = $blockPosition["prefix_medium"] . '0';
                } elseif ($blockPosition["showLeftColumn"] == 0 and $blockPosition["showRightColumn"] > 0) {
                    $ClassLeft = $blockPosition["prefix_medium"] . '0';
                    $ClassCom = $blockPosition["prefix_medium"] . (12 - $widthcolumn);
                    $ClassRight = 'block-right column-block ' . $blockPosition["prefix_medium"] . $widthcolumn . ' sidebar-offcanvas';
                } else {
                    //$blockPosition["showRightColumn"] == 0 and $blockPosition["showLeftColumn"] == 0
                    //$showno = 0;
                    $ClassLeft = $blockPosition["prefix_extrasmall"] . '0';
                    $ClassCom = $blockPosition["prefix_extrasmall"] . '12';
                    $ClassRight = $blockPosition["prefix_extrasmall"] . '0';
                }

                break;
        }

        return true;
    }

}
