import { useMemo } from "react";
import { Chart as ChartType } from "@/types";
import {
    Chart as ChartJS,
    ArcElement,
    Tooltip,
    Legend,
    ChartOptions,
} from "chart.js";
import { Pie } from "react-chartjs-2";
import { COLORS } from "../constants";
import { getGeneralChartOptions } from "../chartOptions";

ChartJS.register(ArcElement, Tooltip, Legend);

type Props = {
    chart: ChartType;
};
const CATEGORY_LIMIT = 6;
export default function PieChart({ chart }: Props) {
    let { data, config } = chart;

    data = useMemo(() => {
        if (data.length <= CATEGORY_LIMIT) return data;

        for (let i = CATEGORY_LIMIT; i < data.length; i++) {
            for (let column of config.dataColumns) {
                data[CATEGORY_LIMIT - 1][column] += data[i][column];
            }
        }

        data[CATEGORY_LIMIT - 1][config.categoryColumn] = "Others";
        return data.slice(0, CATEGORY_LIMIT);
    }, [data, config]);

    const labels = useMemo(
        () =>
            data
                .map((row) => row[config.categoryColumn])
                .slice(0, CATEGORY_LIMIT),
        [data, config]
    );

    return (
        <Pie
            data={{
                labels: labels,
                datasets: [
                    {
                        label: config.dataColumns[0],
                        data: data.map((row) =>
                            Number(row[config.dataColumns[0]])
                        ),
                        backgroundColor: COLORS,
                        borderColor: COLORS,
                    },
                ],
            }}
            options={getPieChartOptions(chart)}
        />
    );
}

export function getPieChartOptions(chart: ChartType) {
    return getGeneralChartOptions(chart) as ChartOptions<"pie">;
}
