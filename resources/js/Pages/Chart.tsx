import { Chart as ChartType, ChartTypeEnum } from "@/types";
import {
    LineChart,
    BarChart,
    PieChart,
    RadarChart,
} from "@/features/charts/components";

const chartTypeToComponent = {
    [ChartTypeEnum.Line]: LineChart,
    [ChartTypeEnum.Bar]: BarChart,
    [ChartTypeEnum.Pie]: PieChart,
    [ChartTypeEnum.Radar]: RadarChart,
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

            <div className="relative sm:mx-6 lg:mx-auto max-w-5xl min-h-[25rem] max-h-screen [&>*]:mx-auto">
                <ChartComponent chart={chart} />
            </div>
        </>
    );
}
