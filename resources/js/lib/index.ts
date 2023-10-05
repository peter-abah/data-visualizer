import { Chart, ChartTypeEnum } from "@/types";
import { deepmerge } from "deepmerge-ts";

export function getDefaultConfigToRenderChart(chart: Chart) {
    const configForChartType = getConfigToRenderChartType(chart);
    const defaultConfig = { options: { maintainAspectRatio: true } };
    return deepmerge(defaultConfig, configForChartType);
}

// Gets default config specific to chart type
function getConfigToRenderChartType(chart: Chart) {
    switch (chart.type) {
        case ChartTypeEnum.Line:
        case ChartTypeEnum.Bar:
            return {
                options: {
                    scales: {
                        x: {
                            title: {
                                display: true,
                                text: chart.config.categoryColumn,
                            },
                        },
                    },
                },
            };
        default:
            return {};
    }
}
