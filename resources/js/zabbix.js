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
            // auth: API_TOKEN,
            id: 2
        };

        // Thực hiện lệnh Fetch
        const response = await fetch(ZABBIX_URL, {
            method: 'POST', // Zabbix luôn dùng POST
            headers: {
                'Content-Type': 'application/json-rpc', // Hoặc 'application/json'
                'Authorization': API_TOKEN
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


const CPU = document.getElementById('CPU');
const CPUText = document.getElementById('CPU-text');
const MemoryText = document.getElementById('Memory-text');
const Memory = document.getElementById('Memory');

const getSystemStats = async () => {
    const payload = {
        jsonrpc: "2.0",
        method: "item.get",
        params: {
            output: ["itemid", "name", "key_", "lastvalue", "units"], // Chỉ lấy các trường này
            hostids: "10084", // ID của host bạn muốn xem (10084 thường là Zabbix Server)
            search: {
                //key_: "system.cpu.util" // Tìm tất cả item có chữ "system.cpu" trong key
                // name: "CPU utilization"
            },
            sortfield: "name"
        },
        // auth: API_TOKEN,
        id: 1
    };

    // Thực hiện lệnh Fetch
        const response = await fetch(ZABBIX_URL, {
            method: 'POST', // Zabbix luôn dùng POST
            headers: {
                'Content-Type': 'application/json-rpc', // Hoặc 'application/json'
                'Authorization': API_TOKEN
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
        // console.log("Danh sách thiết bị:", data.result[0]);

        return data.result;
};

getSystemStats()
    .then((items) => {
        return items;
    })
    .then((items) => {
        items.forEach((item) => {
        // console.log(item);
        if (item.name === 'CPU utilization') {
            let cpuText = parseFloat(item.lastvalue).toFixed(2);
            let cpuUsage = parseInt(item.lastvalue);
            CPUText.innerText = `CPU Usage (${cpuText}%)`;
            CPU.querySelector('.progress-bar').classList.add(`wd-${cpuUsage}p`);
            CPU.querySelector('.progress-bar').setAttribute('aria-valuenow', cpuUsage);
        }

        if (item.name === 'Memory utilization') {
            let memoryText = parseFloat(item.lastvalue).toFixed(2);
            let memoryUsage = parseInt(item.lastvalue);
            let totalMemory = item.name = 'Total memory';
            MemoryText.innerText = `Memory Usage (${memoryText}%)`;
            Memory.querySelector('.progress-bar').classList.add(`wd-${memoryUsage}p`);
            Memory.querySelector('.progress-bar').setAttribute('aria-valuenow', memoryUsage);
        }
    });
});

const historyStatus = async () => {
    const payload = {
        jsonrpc: "2.0",
        method: "history.get",
        params: {
            output: "extend",
            history: 0, // 0 là Float (CPU thường dùng loại này)
            itemids: itemId, // ID lấy được từ bước 1
            sortfield: "clock", // Sắp xếp theo thời gian
            sortorder: "DESC",  // Mới nhất lấy trước
            limit: 10 // Lấy 10 điểm dữ liệu gần nhất
        },
        // auth: API_TOKEN,
        id: 1
    };

    // Thực hiện lệnh Fetch
        const response = await fetch(ZABBIX_URL, {
            method: 'POST', // Zabbix luôn dùng POST
            headers: {
                'Content-Type': 'application/json-rpc', // Hoặc 'application/json'
                'Authorization': API_TOKEN
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
};

historyStatus();