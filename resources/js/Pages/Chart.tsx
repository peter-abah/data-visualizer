import { Chart, ChartType } from "../types";
import { Line } from "react-chartjs-2";
import {
    Chart as ChartJS,
    CategoryScale,
    LinearScale,
    PointElement,
    LineElement,
    Title,
    Tooltip,
    Legend,
} from "chart.js";

ChartJS.register(
    CategoryScale,
    LinearScale,
    PointElement,
    LineElement,
    Title,
    Tooltip,
    Legend
);

type Props = {
    chart: Chart;
};
export default function Chart({ chart }: Props) {
    const { name, data, config } = chart;

    return (
        <>
            <h1 className="font-bold tracking-tight text-3xl text-gray-800 dark:text-gray-200">
                {name}
            </h1>
            <div className="max-w-screen-lg mx-auto">
                <Line
                    options={{}}
                    data={{
                        labels: chart.data.map(
                            (row) => row[config.xAxisColumn]
                        ),
                        datasets: [
                            {
                                label: config.dataColumn,
                                data: data.map((row) => row[config.dataColumn]),
                                backgroundColor: "#4568FF",
                                borderColor: "#4568FF",
                            },
                        ],
                    }}
                />
            </div>
        </>
    );
}
