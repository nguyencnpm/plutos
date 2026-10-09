<?php

/**
 * Author       : Binh Nguyen
 * @package     : Giaiphapcongnghethongtin.Site
 * @subpackage  : com_standard
 */
defined('_JEXEC') or die;

use Joomla\Registry\Registry;

class StandardControllerInventory extends JControllerForm {

    public function getModel($name = 'Inventory', $prefix = 'StandardModel', $config = array('ignore_request' => true)) {
        return parent::getModel($name, $prefix, array('ignore_request' => false));
    }

    public function infoChart() {
        $app = JFactory::getApplication();
        $aPost = JRequest::get('post');
        $sTypeChart = isset($aPost["typechart"]) ? $aPost["typechart"] : "bar";
        $model = $this->getModel();
        $oItems = $model->getItems();
        $aLabel = array();
        $aData = array();
        $aBackgroundColor = array();
        $aBorderColor = array();

        foreach ($oItems as $key => $item) :
            $aLabel[$key] = $item->title;
            $aData[$key] = $item->in_stock;
            $aBackgroundColor[$key] = 'rgba(12, 46, 83, 1)';
            $aBorderColor[$key] = 'rgba(185, 151, 91, 1)';
        endforeach;
  
        // === Set info Drawing Chart ===
        $oDataChart = new stdClass();
        $oDatasets = new stdClass();
        $sTitleChart = "# of Product";
        $borderWidthChart = 1;

        $oDataChart->type = $sTypeChart;
        // --- data ---
        $oDataChart->data = new stdClass();
        $oDataChart->data->labels = $aLabel;
        /*
          $oDataPoints = new stdClass();
          $oDataPoints->y = 10;
          $oDataChart->data->indexLabel = "y";
          $oDataChart->data->dataPoints[] = $oDataPoints;
         */
        $oDatasets->label = $sTitleChart; // set data: datasets
        $oDatasets->data = $aData; // set data: datasets
        $oDatasets->backgroundColor = $aBackgroundColor; // set data: datasets
        $oDatasets->borderColor = $aBorderColor; // set data: datasets
        $oDatasets->borderWidth = $borderWidthChart; // set data: datasets
        // $oDatasets->fill=true;

        $oDataChart->data->datasets[] = $oDatasets;
        // --- /.data ---
        // --- options ---
        $oDataChart->options = new stdClass();

        // $oDataChart->options->maintainAspectRatio = false;
        $oDataChart->options->responsive = false;

        //$oDataChart->options->tooltips = new stdClass();
        //$oDataChart->options->tooltips->enabled = true;

        $oDataChart->options->hover = new stdClass();
        $oDataChart->options->hover->animationDuration = 0;

        //$oDataChart->options->legend = new stdClass();
        //$oDataChart->options->legend->display = true;

        $oDataChart->options->scales = new stdClass();
        // yAxes
        $oYAxes = new stdClass();
        $oYAxes->ticks = new stdClass();
        $oYAxes->ticks->beginAtZero = true;
        // $oYAxes->ticks->max = 80;
        //$oYAxes->gridLines = new stdClass();
        //$oYAxes->gridLines->display = true;

        $oDataChart->options->scales->yAxes[] = $oYAxes;
        // /.yAxes
        // xAxes
        $oXAxes = new stdClass();
        $oXAxes->ticks = new stdClass();
        $oXAxes->ticks->beginAtZero = true;

        $oXAxes->gridLines = new stdClass();
        // $oXAxes->gridLines->display = false;
        // $oXAxes->gridLines->color = 'rgba(185, 151, 91, 1)';

        $oDataChart->options->scales->xAxes[] = $oXAxes;

        // /.xAxes
        // --- /.options ---
        // === /. Set info Drawing Chart ===
        $registry = new Registry;
        $registry->loadArray($oDataChart);

        echo $registry;
        // echo json_encode($oDataChart);
        $app->close();
    }

}
