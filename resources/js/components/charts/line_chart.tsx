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
} from "chart.js";

import { COLORS } from "@/lib/constants";
import { getDefaultConfigToRenderChart } from "@/lib";

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
            <div className="relative sm:mx-6 lg:mx-auto max-w-5xl min-h-[25rem]">
                <Line
                    data={{
                        labels: chart.data.map(
                            (row) => row[config.categoryColumn]
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
