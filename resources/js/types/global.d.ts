import { AxiosInstance } from "axios";
import { Alpine as AlpineType } from "alpinejs";

declare global {
    interface Window {
        axios: AxiosInstance;
        Alpine: AlpineType;
    }
}
