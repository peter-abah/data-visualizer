import { Chart as ChartType } from "@/types";
import { Bar } from "react-chartjs-2";
import {
    Chart as ChartJS,
    CategoryScale,
    BarElement,
    Tooltip,
    Legend,
    ChartOptions,
} from "chart.js";
import { COLORS } from "../constants";
import {
    getCartesianChartOptions,
    getGeneralChartOptions,
} from "../chartOptions";
import { merge } from "chart.js/helpers";

ChartJS.register(CategoryScale, BarElement, Tooltip, Legend);

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
            options={getBarChartOptions(chart)}
        />
    );
}

export function getBarChartOptions(chart: ChartType) {
    let options = getGeneralChartOptions(chart);
    options = merge(options, getCartesianChartOptions(chart));
    return options as ChartOptions<"bar">;
}
