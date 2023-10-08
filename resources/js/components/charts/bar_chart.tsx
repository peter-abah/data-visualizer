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
import { COLORS } from "@/lib/constants";
import { getChartOptions } from "@/lib";

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
        <Bar
            data={{
                labels: chart.data.map((row) => row[config.categoryColumn]),
                datasets: config.dataColumns.map((dataColumn, i) => ({
                    label: dataColumn,
                    data: data.map((row) => row[dataColumn]),
                    backgroundColor: COLORS[i],
                    borderColor: COLORS[i],
                })),
            }}
            options={getChartOptions(chart)}
        />
    );
}
