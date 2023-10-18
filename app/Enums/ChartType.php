<?php

namespace App\Enums;

enum ChartType: string
{
    case LineChart = "line_chart";
    case BarChart = "bar_chart";
    case PieChart = "pie_chart";
    case RadarChart = "radar_chart";
    case ScatterChart = "scatter_chart";

    public static function getCartesianTypes()
    {
        return [self::BarChart->value, self::LineChart->value, self::ScatterChart];
    }

    public function isCartesian()
    {
        return in_array($this->value, self::getCartesianTypes());
    }
}
