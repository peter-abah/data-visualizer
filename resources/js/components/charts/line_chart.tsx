import { Chart as ChartType } from "../../types";
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
    chart: ChartType;
};
export default function LineChart({ chart }: Props) {
    const { name, data, config } = chart;

    return (
        <>
            <div className="max-w-screen-lg mx-auto">
                <Line
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
