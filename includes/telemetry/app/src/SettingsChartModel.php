<?php


namespace Telemetry;



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

    public function setHeight($height){
        $this->height = $height;
    }

    public function setWidth($width){
        $this->width = $width;
    }

    /**
     * creates a chart image using temperature data passed from database, store image at the defined location
     * @param int $temperature
     */
    public function createSettingsChart($temperature = 0)
    {
        require_once 'libchart/classes/libchart.php';
        $chart = new \VerticalBarChart(500, 250);
        $dataSet = new \XYDataSet();
        $dataSet->addPoint(new \Point("Temperature", $temperature));
        $chart->setDataSet($dataSet);
        $chart->setTitle("Circuit Board reading");

        $output_chart_location = LIB_CHART_OUTPUT_PATH;
        $this->createChartDirectoryIfNotExists($output_chart_location);

        $output_chart_path = $output_chart_location . "/chart.png";

        $chart->render($output_chart_path);
        $this->chart_location = $output_chart_path;
    }

    /**
     * creates the directory where the chart image is stored if it doesn't exist
     * @param $output_chart_location
     */
    private function createChartDirectoryIfNotExists($output_chart_location){
        if (!is_dir($output_chart_location))
        {
            mkdir($output_chart_location, 0755, true);
        }
    }

    public function getChartLocation(){
        return $this->chart_location;
    }

}