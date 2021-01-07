<?php
/**
 * SettingsChartModel
 *
 * @author P2508450
 *
 *
 */

namespace Telemetry;

use VerticalBarChart;
use XYDataSet;

class SettingsChartModel
{
    private $height;
    private $width;
    private $chart_location;

    public function __construct()
    {
        $this->height = 500;
        $this->height = 500;
        $this->chart_location = null;
    }

    public function __destruct()
    {
    }

    /**
     * sets desired height or chart png image
     * @param $height
     */
    public function setHeight($height)
    {
        $this->height = $height;
    }

    /**
     * sets desired width of hart png image
     * @param $width
     */
    public function setWidth($width)
    {
        $this->width = $width;
    }

    /**
     * returns location where chart image is stored
     * @return String
     */
    public function getChartLocation()
    {
        return $this->chart_location;
    }

    /**
     * creates a chart png image using temperature data passed from database
     * @param int $temperature
     */
    public function createSettingsChart($temperature = 0)
    {
        require_once 'libchart/classes/libchart.php';

        $chart = new VerticalBarChart(500, 500);
        $dataSet = new XYDataSet();
        $dataSet->addPoint(new \Point("Temperature", $temperature));
        $chart->setDataSet($dataSet);
        $chart->setTitle("Circuit Board reading");

        $output_chart_location = LIB_CHART_OUTPUT_PATH;
        //$this->createChartDirectoryIfNotExists($output_chart_location);

        $output_chart_path = $output_chart_location . "/chart.png";

        $chart->render($output_chart_path);
        $this->chart_location = $output_chart_path;
    }

    /**
     * creates the directory where the chart image is stored if it doesn't exist
     * @param $output_chart_location
     */
    private function createChartDirectoryIfNotExists($output_chart_location)
    {
        if (!is_dir($output_chart_location)) {
            mkdir($output_chart_location, 0755, true);
        }
    }

}