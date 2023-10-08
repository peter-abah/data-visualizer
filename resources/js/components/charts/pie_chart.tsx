import { Chart as ChartType } from "@/types";
import { Chart as ChartJS, ArcElement, Tooltip, Legend } from "chart.js";
import { Pie } from "react-chartjs-2";

ChartJS.register(ArcElement, Tooltip, Legend);

import { COLORS } from "@/lib/constants";
import { getChartOptions } from "@/lib";

type Props = {
    chart: ChartType;
};
export default function PieChart({ chart }: Props) {
    const { data, config } = chart;

    return (
        <Pie
            data={{
                labels: chart.data.map((row) => row[config.categoryColumn]),
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
            options={getChartOptions(chart)}
        />
    );
}
