import { Chart as ChartType } from "@/types";
import { Line } from "react-chartjs-2";
import {
    Chart as ChartJS,
    CategoryScale,
    LinearScale,
    LogarithmicScale,
    TimeScale,
    PointElement,
    LineElement,
    Tooltip,
    Legend,
    ChartOptions,
} from "chart.js";
import "chartjs-adapter-dayjs-4/dist/chartjs-adapter-dayjs-4.esm";

import { COLORS } from "../constants";
import {
    getCartesianChartOptions,
    getGeneralChartOptions,
    getTimeScaleOptions,
} from "../chartOptions";
import { merge } from "chart.js/helpers";

ChartJS.register(
    CategoryScale,
    LinearScale,
    LogarithmicScale,
    TimeScale,
    PointElement,
    LineElement,
    Tooltip,
    Legend
);

type Props = {
    chart: ChartType;
};

export default function LineChart({ chart }: Props) {
    const { data, config } = chart;

    return (
        <Line
            data={{
                labels: chart.data.map((row) => row[config.categoryColumn]),
                datasets: config.dataColumns.map((dataColumn, i) => ({
                    label: dataColumn,
                    data: data.map((row) => row[dataColumn]),
                    backgroundColor: COLORS[i],
                    borderColor: COLORS[i],
                })),
            }}
            options={getLineChartOptions(chart)}
        />
    );
}

export function getLineChartOptions(chart: ChartType) {
    let options = getGeneralChartOptions(chart);
    options = merge(options, getCartesianChartOptions(chart));

    if (chart.config.scaleType === "time") {
        options = merge(options, getTimeScaleOptions(chart));
    }

    return options as ChartOptions<"line">;
}
