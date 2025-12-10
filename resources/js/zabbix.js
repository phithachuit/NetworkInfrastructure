
// Cấu hình
const ZABBIX_URL = 'http://192.168.1.28/api_jsonrpc.php';
const API_TOKEN = 'Bearer 0dd2f051632cc9af5e4d93f7c4987a71421c9559173cf363bbcb54ad9faf3756'; // Lấy trong Zabbix Admin

async function getZabbixHosts() {
    try {
        // Cấu hình payload theo chuẩn JSON-RPC 2.0
        const payload = {
            jsonrpc: "2.0",
            method: "host.get",
            params: {
                output: ["hostid", "name", "status"], // Các trường muốn lấy
                selectInterfaces: ["ip"] // Lấy thêm IP
            },
            auth: API_TOKEN,
            id: 1
        };

        // Thực hiện lệnh Fetch
        const response = await fetch(ZABBIX_URL, {
            method: 'POST', // Zabbix luôn dùng POST
            headers: {
                'Content-Type': 'application/json-rpc', // Hoặc 'application/json'
            },
            body: JSON.stringify(payload) // Fetch không tự stringify như Axios
        });

        // 1. Kiểm tra lỗi mạng (HTTP Status khác 200-299)
        if (!response.ok) {
            throw new Error(`HTTP Error! Status: ${response.status}`);
        }

        // 2. Parse dữ liệu từ JSON
        const data = await response.json();

        // 3. Kiểm tra lỗi logic từ Zabbix API (Ví dụ: sai token, sai quyền)
        if (data.error) {
            throw new Error(`Zabbix API Error: ${data.error.data}`);
        }

        // Thành công! Dữ liệu nằm trong data.result
        console.log("Danh sách thiết bị:", data.result);
        return data.result;

    } catch (error) {
        console.error("Lỗi khi gọi API:", error.message);
    }
}

// Gọi hàm
getZabbixHosts();