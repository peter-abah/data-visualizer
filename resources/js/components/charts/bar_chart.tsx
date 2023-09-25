import { Chart as ChartType } from "../../types";
import { Bar } from "react-chartjs-2";
import {
    Chart as ChartJS,
    CategoryScale,
    LinearScale,
    BarElement,
    Title,
    Tooltip,
    Legend,
} from "chart.js";
import { COLORS, getDefaultConfigToRenderChart } from "../../lib/constants";

ChartJS.register(
    CategoryScale,
    LinearScale,
    BarElement,
    Title,
    Tooltip,
    Legend
);

type Props = {
    chart: ChartType;
};
export default function BarChart({ chart }: Props) {
    const { data, config } = chart;

    return (
        <>
            <div className="sm:mx-6 lg:mx-auto max-w-5xl h-[25rem]">
                <Bar
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
