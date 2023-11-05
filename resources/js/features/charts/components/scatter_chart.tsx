import { Chart as ChartType } from "@/types";
import { Scatter } from "react-chartjs-2";
import {
    Chart as ChartJS,
    CategoryScale,
    LinearScale,
    PointElement,
    Tooltip,
    Legend,
    ChartOptions,
} from "chart.js";
import "chartjs-adapter-dayjs-4/dist/chartjs-adapter-dayjs-4.esm";

import { COLORS, DARK_MODE_COLORS } from "../constants";
import {
    getCartesianChartOptions,
    getGeneralChartOptions,
} from "../chartOptions";
import { merge } from "chart.js/helpers";
import useTheme from "@/hooks/useTheme";

ChartJS.register(CategoryScale, LinearScale, PointElement, Tooltip, Legend);

type Props = {
    chart: ChartType;
};

export default function ScatterChart({ chart }: Props) {
    const theme = useTheme();
    const { data, config } = chart;
    const colors = theme === 'dark' ? DARK_MODE_COLORS : COLORS;

    return (
        <Scatter
            data={{
                datasets: config.dataColumns.map((dataColumn, i) => ({
                    label: dataColumn,
                    data: data.map((row) => ({
                        x: row[config.categoryColumn],
                        y: row[dataColumn],
                    })),
                    backgroundColor: colors[i],
                    borderColor: colors[i],
                })),
            }}
            options={getScatterChartOptions(chart)}
        />
    );
}

export function getScatterChartOptions(chart: ChartType) {
    let options = getGeneralChartOptions(chart);
    options = merge(options, getCartesianChartOptions(chart));
    options.scales = merge(options.scales, {
        x: {
            type: "linear",
        },
    });

    return options as ChartOptions<"scatter">;
}
