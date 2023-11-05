import { useEffect, useMemo, useState } from "react";
import { Chart as ChartType } from "@/types";
import {
    Chart as ChartJS,
    ArcElement,
    Tooltip,
    Legend,
    ChartOptions,
} from "chart.js";
import { Pie } from "react-chartjs-2";
import { COLORS, DARK_MODE_COLORS } from "../constants";
import { getGeneralChartOptions } from "../chartOptions";
import { useDarkMode } from "usehooks-ts";
import useTheme from "@/hooks/useTheme";

ChartJS.register(ArcElement, Tooltip, Legend);

type Props = {
    chart: ChartType;
};

export default function PieChart({ chart }: Props) {
    let { data, config } = chart;
    const theme = useTheme();

    data = useMemo(() => {
        const sectorLimit = +config.sectorLimit;
        if (data.length <= sectorLimit) return data;

        for (let i = sectorLimit; i < data.length; i++) {
            for (let column of config.dataColumns) {
                data[sectorLimit - 1][column] += +data[i][column];
            }
        }

        data[sectorLimit - 1][config.categoryColumn] = "Others";
        return data.slice(0, sectorLimit);
    }, [data, config]);

    const labels = useMemo(
        () =>
            data
                .map((row) => row[config.categoryColumn])
                .slice(0, +config.sectorLimit),
        [data, config]
    );

    const colors = theme === 'dark' ? DARK_MODE_COLORS : COLORS;

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
                        backgroundColor: colors,
                        borderColor: colors,
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
