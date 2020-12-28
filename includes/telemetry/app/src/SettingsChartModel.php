<?php


namespace Telemetry;



class SettingsChartModel
{
    private $height;
    private $width;
    private $chart_location;

    public function __construct()
    {
        require_once 'libchart/classes/libchart.php';
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
     * creates a chart image, stores it at the defined location
     */
    public function createSettingsChart()
    {
        $chart = new VerticalBarChart(500, 250);
        $dataSet = new XYDataSet();
        $dataSet->addPoint(new Point("Jan 2005", 273));
        $dataSet->addPoint(new Point("Feb 2005", 321));
        $dataSet->addPoint(new Point("March 2005", 442));
        $dataSet->addPoint(new Point("April 2005", 711));
        $chart->setDataSet($dataSet);
        $chart->setTitle("Monthly usage for www.example.com");

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