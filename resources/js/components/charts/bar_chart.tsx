import { Chart as ChartType } from "../../types";
import { Bar } from "react-chartjs-2";
import {
    Chart as ChartJS,
    CategoryScale,
    LinearScale,
    BarElement,
    Title,
    Tooltip,
    Legend,
} from "chart.js";

ChartJS.register(
    CategoryScale,
    LinearScale,
    BarElement,
    Title,
    Tooltip,
    Legend
);

type Props = {
    chart: ChartType;
};
export default function BarChart({ chart }: Props) {
    const { data, config } = chart;

    return (
        <>
            <div className="sm:mx-6 lg:mx-auto max-w-5xl">
                <Bar
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
