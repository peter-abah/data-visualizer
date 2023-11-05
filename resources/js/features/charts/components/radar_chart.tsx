import { Radar } from "react-chartjs-2";
import {
    Chart as ChartJS,
    RadarController,
    RadialLinearScale,
    LineElement,
    PointElement,
    ChartOptions,
} from "chart.js";
import { Chart as ChartType } from "@/types";
import { COLORS, DARK_MODE_COLORS } from "../constants";
import { getGeneralChartOptions } from "../chartOptions";
import useTheme from "@/hooks/useTheme";

ChartJS.register(RadarController, RadialLinearScale, LineElement, PointElement);

type Props = {
    chart: ChartType;
};
export default function RadarChart({ chart }: Props) {
    const theme = useTheme();
    const { data, config } = chart;
    const colors = theme === 'dark' ? DARK_MODE_COLORS : COLORS;

    return (
        <Radar
            data={{
                labels: chart.data.map((row) => row[config.categoryColumn]),
                datasets: config.dataColumns.map((dataColumn, i) => ({
                    label: dataColumn,
                    data: data.map((row) => row[dataColumn]),
                    backgroundColor: colors[i],
                    borderColor: colors[i],
                })),
            }}
            options={getRadarChartOptions(chart)}
        />
    );
}

export function getRadarChartOptions(chart: ChartType) {
    return getGeneralChartOptions(chart) as ChartOptions<"radar">;
}
