import { CartesianScale, Chart, ChartTypeEnum } from "@/types";
import { ChartOptions } from "chart.js";
import { CARTESAIN_CHART_TYPES } from "./constants";

export function getGeneralChartOptions(chart: Chart): ChartOptions {
    return { maintainAspectRatio: false };
}

export function getCartesianChartOptions(chart: Chart): ChartOptions {
    const xScale = (chart.config.scaleType as CartesianScale) || "category";

    return {
        scales: {
            x: {
                type: xScale,
                title: {
                    color: "black",
                    display: true,
                    text: chart.config.categoryColumn,
                    font: {
                        size: 16,
                        weight: "bold",
                    },
                },
            },
        },
    };
}

export function getTimeScaleOptions(chart: Chart): ChartOptions {
    return {
        scales: {
            x: {
                type: "time",
                time: { parser: chart.config.dateFormat || undefined },
            },
        },
    };
}

export function isChartCartesian(chart: Chart) {
    return CARTESAIN_CHART_TYPES.includes(chart.type);
}
