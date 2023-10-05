<?php

namespace App\Enums;
enum ChartType: string
{
    case LineChart = "line_chart";
    case BarChart = "bar_chart";
    case PieChart = "pie_chart";
}
