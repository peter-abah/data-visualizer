import { Chart, ChartTypeEnum } from "@/types";
import { ChartOptions } from "chart.js";
import { merge } from "chart.js/helpers";
import { CARTESAIN_CHART_TYPES } from "./constants";

// Generates options to render chart
export function getChartOptions(chart: Chart): ChartOptions {
    let options = getGeneralChartOptions(chart);
    options = merge(getChartTypeOptions(chart), options);
    return options;
}

export function getGeneralChartOptions(chart: Chart): ChartOptions {
    let options = { maintainAspectRatio: false };
    return options;
}

export function getChartTypeOptions(chart: Chart): ChartOptions {
    let options = {};

    if (isChartCartesian(chart)) {
        options = getCartesianChartOptions(chart);
    }

    switch (chart.type) {
        case ChartTypeEnum.Line:
            options = merge(options, getLineChartOptions(chart));
            break;
        default:
            break;
    }

    return options;
}

export function getLineChartOptions(chart: Chart): ChartOptions {
    let options = {
        scales: { x: { type: chart.config.scaleType || "category" } },
    };

    if (chart.config.scaleType === "time") {
        options = merge(options, getTimeScaleOptions(chart));
    }

    return options;
}

export function getCartesianChartOptions(chart: Chart): ChartOptions {
    return {
        scales: {
            x: {
                type: "category",
                title: {
                    display: true,
                    text: chart.config.categoryColumn,
                },
            },
        },
    };
}

export function getTimeScaleOptions(chart: Chart): ChartOptions {
    return {
        scales: {
            x: { time: { parser: chart.config.dateFormat || undefined } },
        },
    };
}

export function isChartCartesian(chart: Chart) {
    return CARTESAIN_CHART_TYPES.includes(chart.type);
}
