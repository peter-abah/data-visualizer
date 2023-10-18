import { ChartTypeEnum } from "@/types";

import LineChart from "./line_chart";
import BarChart from "./bar_chart";
import PieChart from "./pie_chart";
import RadarChart from "./radar_chart";
import ScatterChart from "./scatter_chart";

export const chartTypeToComponent = {
    [ChartTypeEnum.Line]: LineChart,
    [ChartTypeEnum.Bar]: BarChart,
    [ChartTypeEnum.Pie]: PieChart,
    [ChartTypeEnum.Radar]: RadarChart,
    [ChartTypeEnum.Scatter]: ScatterChart,
};

export { LineChart, BarChart, PieChart, RadarChart, ScatterChart };
