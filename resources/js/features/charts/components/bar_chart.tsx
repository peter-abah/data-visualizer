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
import { COLORS, DARK_MODE_COLORS } from "../constants";
import {
    getCartesianChartOptions,
    getGeneralChartOptions,
} from "../chartOptions";
import { merge } from "chart.js/helpers";
import useTheme from "@/hooks/useTheme";

ChartJS.register(CategoryScale, BarElement, Tooltip, Legend);

type Props = {
    chart: ChartType;
};
export default function BarChart({ chart }: Props) {
    const theme = useTheme();
    const { data, config } = chart;
    const colors = theme === 'dark' ? DARK_MODE_COLORS : COLORS;


    return (
        <Bar
            data={{
                labels: chart.data.map((row) => row[config.categoryColumn]),
                datasets: config.dataColumns.map((dataColumn, i) => ({
                    label: dataColumn,
                    data: data.map((row) => row[dataColumn]),
                    backgroundColor: colors[i],
                    borderColor: colors[i],
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
