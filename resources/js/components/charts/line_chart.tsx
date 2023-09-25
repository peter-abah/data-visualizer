import { Chart as ChartType } from "../../types";
import { Line } from "react-chartjs-2";
import {
    Chart as ChartJS,
    CategoryScale,
    LinearScale,
    PointElement,
    LineElement,
    Title,
    Tooltip,
    Legend,
    scales,
} from "chart.js";

import { COLORS, getDefaultConfigToRenderChart } from "../../lib/constants";

ChartJS.register(
    CategoryScale,
    LinearScale,
    PointElement,
    LineElement,
    Title,
    Tooltip,
    Legend
);

type Props = {
    chart: ChartType;
};
export default function LineChart({ chart }: Props) {
    const { data, config } = chart;

    return (
        <>
            <div className="sm:mx-6 lg:mx-auto max-w-5xl min-h-[25rem]">
                <Line
                    data={{
                        labels: chart.data.map(
                            (row) => row[config.xAxisColumn]
                        ),
                        datasets: config.dataColumns.map((dataColumn, i) => ({
                            label: dataColumn,
                            data: data.map((row) => row[dataColumn]),
                            backgroundColor: COLORS[i],
                            borderColor: COLORS[i],
                        })),
                    }}
                    {...getDefaultConfigToRenderChart(chart)}
                />
            </div>
        </>
    );
}
