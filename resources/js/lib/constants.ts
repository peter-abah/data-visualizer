import { Chart } from "../types";

export const COLORS = ["#0088FE", "#00C49F", "#FFBB28", "#FF8042"];

export function getDefaultConfigToRenderChart(chart: Chart) {
    return {
        options: {
            scales: {
                x: {
                    title: {
                        display: true,
                        text: chart.config.xAxisColumn,
                    },
                },
            },
            maintainAspectRatio: false,
        },
    };
}
