// Cấu hình
const ZABBIX_URL = 'http://192.168.1.28/api_jsonrpc.php';
const API_TOKEN = 'Bearer 1deefb76b969768141cf095671111a85a60cc8962e353f8c87129e534121a0cc'; // Lấy trong Zabbix Admin

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


// const CPU = document.getElementById('CPU');
// const CPUText = document.getElementById('CPU-text');
// const MemoryText = document.getElementById('Memory-text');
// const Memory = document.getElementById('Memory');

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

// getSystemStats()
//     .then((items) => {
//         return items;
//     })
//     .then((items) => {
//         items.forEach((item) => {        
//         if (item.name === "CPU utilization") {
//             let cpuText = parseFloat(item.lastvalue).toFixed(2);
//             let cpuUsage = parseInt(item.lastvalue);
//             CPUText.innerText = `CPU Usage (${cpuText}%)`;
//             CPU.querySelector('.progress-bar').classList.add(`wd-${cpuUsage}p`);
//             CPU.querySelector('.progress-bar').setAttribute('aria-valuenow', cpuUsage);
//         }

//         if (item.name === 'Memory utilization') {
//             let memoryText = parseFloat(item.lastvalue).toFixed(2);
//             let memoryUsage = parseInt(item.lastvalue);
//             let totalMemory = item.name = 'Total memory';
//             MemoryText.innerText = `Memory Usage (${memoryText}%)`;
//             Memory.querySelector('.progress-bar').classList.add(`wd-${memoryUsage}p`);
//             Memory.querySelector('.progress-bar').setAttribute('aria-valuenow', memoryUsage);
//         }
//     });
// });




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




// Lấy log cảnh báo
const getAlertLogs = async () => {
    const payload = {
        jsonrpc: "2.0",
        method: "problem.get",
        params: {
            output: ["eventid", "clock", "name", "severity"],
            // sortfield: "clock",
            sortorder: "DESC",
            limit: 100, // Lấy 100 lỗi mới nhất
            severities: [1,2,3, 4, 5] // BỎ COMMENT dòng này nếu chỉ muốn lấy lỗi Cao/Thảm họa
        },
        id: 1
    };

    let response = await fetch(ZABBIX_URL, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json-rpc', // Hoặc 'application/json'
            'Authorization': API_TOKEN
        },
        body: JSON.stringify(payload)
    });

    let data = await response.json();
    let problems = data.result;
    let html = '';

    problems.forEach(p => {
        // Chuyển mã severity thành chữ cho dễ đọc
        let level = "";
        let classLevel = "secondary";

        if (p.severity == 1) {
            level = "Thông tin";
            classLevel = "primary";
        }

        if (p.severity == 2) {
            level = "Cảnh báo";
            classLevel = "warning";
        }
        if (p.severity == 3) {
            level = "Trung bình";
            classLevel = "warning";
        }
        if (p.severity == 4) {
            level = "Cao";
            classLevel = "danger";
        }
        if (p.severity == 5) {
            level = "Nguy hiểm";
            classLevel = "danger";
        }

        let time = new Date(p.clock * 1000).toLocaleString();
        // console.log(`[${time}] [${level}] ${p.name}`);

        html += `<div class="alert alert-${classLevel} mg-b-0" role="alert">
                    <strong>[${level}]</strong> ${p.name} <br/>
                    <small class="text-muted">${time}</small>
                </div>`;
    });

    logList.insertAdjacentHTML('beforeend', html);
};


// Đảm bảo code chạy sau khi trang đã tải xong
document.addEventListener('DOMContentLoaded', function() {

    // get list log
    const logList = document.getElementById('logList');
    getAlertLogs();
    
    // get list server status
    const CPUText = document.getElementById('cpu-utilization-text');
    const CPU = document.getElementById('cpu-utilization');
    const MemoryText = document.getElementById('memory-utilization-text');
    const Memory = document.querySelector('#memoryUtilization');

    getSystemStats()
        .then((items) => {
            if (!items || !Array.isArray(items)) return; // Kiểm tra dữ liệu đầu vào

            items.forEach((item) => {
                console.log(item.name, item.lastvalue);
                        
                // Xử lý CPU
                if (item.name === "CPU utilization") {
                    // Kiểm tra xem phần tử HTML có tồn tại không trước khi thao tác
                    if (CPUText && CPU) {
                        let cpuText = parseFloat(item.lastvalue).toFixed(2);
                        let cpuUsage = parseInt(item.lastvalue);
                        
                        CPUText.innerText = `CPU Utilization (${cpuText}%)`;
                        
                        let progressBar = CPU.querySelector('.progress-bar');
                        if (progressBar) {
                            // Xóa các class cũ để tránh bị chồng chéo class (vd: vừa wd-20p vừa wd-30p)
                            progressBar.className = 'progress-bar'; 
                            progressBar.classList.add(`wd-${cpuUsage}p`);
                            progressBar.setAttribute('aria-valuenow', cpuUsage);
                        }
                    }
                }

                // Xử lý Memory
                if (item.name === 'Memory utilization') {
                    if (MemoryText && Memory) {
                        let memoryText = parseFloat(item.lastvalue).toFixed(2);
                        let memoryUsage = parseInt(item.lastvalue);
                        console.log(memoryUsage);
                        
                        
                        MemoryText.innerText = `Memory Utilization (${memoryText}%)`;
                        
                        let progressBar = Memory.querySelector('.progress-bar');
                        if (progressBar) {
                            progressBar.className = 'progress-bar bg-teal';
                            progressBar.classList.add(`wd-${memoryUsage}p`);
                            progressBar.setAttribute('aria-valuenow', memoryUsage);
                        }
                    }
                }
            });
        })
        .catch((error) => {
            console.error("Lỗi khi lấy thông tin hệ thống:", error);
        });
});

// Lấy log user tác động
const getAuditLog = async () => {
    let payload = {
        jsonrpc: "2.0",
        method: "auditlog.get",
        params: {
            output: "extend",
            // sortfield: "clock",
            sortorder: "DESC",
            limit: 10 // Lấy 10 hành động gần nhất
        },
        // auth: API_TOKEN,
        id: 1
    };
    
    let response = await fetch(ZABBIX_URL, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json-rpc', // Hoặc 'application/json'
            'Authorization': API_TOKEN
        },
        body: JSON.stringify(payload)
    });

    let data = await response.json();
    let problems = data.result;

    console.log("--- problems ---");
    console.log(problems);
    
};

getAuditLog();

const getBandwidthHistory = async (hostId) => {
    // BƯỚC 1: Tìm Item ID của Traffic Out (Upload) và In (Download)
    // Key chuẩn thường là: net.if.in[tên_card_mạng] hoặc net.if.out[...]
    const itemRes = await fetch(ZABBIX_URL, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json-rpc', // Hoặc 'application/json'
            'Authorization': API_TOKEN
        },
        body: JSON.stringify({
            jsonrpc: "2.0",
            method: "item.get",
            params: {
                output: ["itemid", "name", "key_"],
                hostids: hostId,
                search: { key_: "net.if.in" }, // Tìm traffic đầu vào
                sortfield: "name"
            },
            id: 2
        })
    });
    
    const itemData = await itemRes.json();
    if (itemData.result.length === 0) return console.log("Không tìm thấy item mạng.");
    
    const netItemId = itemData.result[0].itemid; // Lấy cái card mạng đầu tiên tìm thấy
    const netName = itemData.result[0].name;

    // BƯỚC 2: Lấy lịch sử băng thông
    const historyRes = await fetch(ZABBIX_URL, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json-rpc', // Hoặc 'application/json'
            'Authorization': API_TOKEN
        },
        body: JSON.stringify({
            jsonrpc: "2.0",
            method: "history.get",
            params: {
                output: "extend",
                history: 3, // <--- SỐ 3 LÀ KIỂU SỐ NGUYÊN (UNSIGNED) CHO BĂNG THÔNG
                itemids: netItemId,
                sortfield: "clock",
                sortorder: "DESC",
                limit: 1
            },
            id: 3
        })
    });

    const historyData = await historyRes.json();
    
    console.log(`--- LỊCH SỬ BĂNG THÔNG (${netName}) ---`);
    console.log(historyData);
    historyData.result.forEach(h => {
        const time = new Date(h.clock * 1000).toLocaleTimeString();
        // Zabbix lưu đơn vị là bps (bits per second), chia 1000*1000 ra Mbps
        const mbps = (h.value / 1000000).toFixed(2); 
        console.log(`[${time}] Tốc độ: ${mbps} Mbps`);
    });
};

getBandwidthHistory("10084"); // Thay 10084 bằng ID host bạn muốn kiểm tra