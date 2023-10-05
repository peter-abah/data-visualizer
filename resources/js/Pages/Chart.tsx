import { Chart as ChartType, ChartTypeEnum } from "../types";
import LineChart from "../components/charts/line_chart";
import BarChart from "../components/charts/bar_chart";
import PieChart from "../components/charts/pie_chart";

const chartTypeToComponent = {
    [ChartTypeEnum.Line]: LineChart,
    [ChartTypeEnum.Bar]: BarChart,
    [ChartTypeEnum.Pie]: PieChart
};

type Props = {
    chart: ChartType;
};

export default function Chart({ chart }: Props) {
    const ChartComponent = chartTypeToComponent[chart.type];

    return (
        <>
            <h1 className="mb-4 font-bold tracking-tight text-3xl text-gray-800 dark:text-gray-200">
                {chart.name}
            </h1>

            <ChartComponent chart={chart} />
        </>
    );
}
