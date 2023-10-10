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
    linkToProject: string;
    linkToSettings: string;
};

export default function Chart({ chart, linkToProject, linkToSettings }: Props) {
    const ChartComponent = chartTypeToComponent[chart.type];

    return (
        <>
            <header className="mb-4 flex items-start">
                <div>
                    <h1 className="font-bold tracking-tight text-3xl text-gray-800">
                        {chart.name}
                    </h1>
                    <p>
                        Project:{" "}
                        <a
                            className="underline hover:no-underline"
                            href={linkToProject}
                        >
                            {chart.project?.name}
                        </a>
                    </p>
                </div>

                <a
                    href={linkToSettings}
                    className="ml-auto px-4 py-2 rounded-md text-sm font-medium border hover:bg-slate-50"
                >
                    Settings
                </a>
            </header>

            <div className="relative sm:mx-6 lg:mx-auto max-w-5xl min-h-[25rem] max-h-screen [&>*]:mx-auto">
                <ChartComponent chart={chart} />
            </div>
        </>
    );
}
