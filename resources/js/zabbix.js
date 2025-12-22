// Cấu hình
const ZABBIX_URL = "http://192.168.1.25:8080/api_jsonrpc.php";
const API_TOKEN =
    "Bearer 7fc3a9d510605238994727c9a0eeb20f021ac9fcad6c0fbdfcf09f8436de58ac"; // Lấy trong Zabbix Admin

async function getZabbixHosts() {
    try {
        // Cấu hình payload theo chuẩn JSON-RPC 2.0
        const payload = {
            jsonrpc: "2.0",
            method: "host.get",
            params: {
                output: ["hostid", "name", "status"], // Các trường muốn lấy
                selectInterfaces: ["ip"], // Lấy thêm IP
            },
            // auth: API_TOKEN,
            id: 2,
        };

        // Thực hiện lệnh Fetch
        const response = await fetch(ZABBIX_URL, {
            method: "POST", // Zabbix luôn dùng POST
            headers: {
                "Content-Type": "application/json-rpc", // Hoặc 'application/json'
                Authorization: API_TOKEN,
            },
            body: JSON.stringify(payload), // Fetch không tự stringify như Axios
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
        // console.log("Danh sách thiết bị:", data.result);

        return data.result;
    } catch (error) {
        console.error("Lỗi khi gọi API:", error.message);
    }
}

const getSystemStats = async (hostid) => {
    const payload = {
        jsonrpc: "2.0",
        method: "item.get",
        params: {
            output: ["itemid", "name", "key_", "lastvalue", "units"], // Chỉ lấy các trường này
            hostids: hostid, // ID của host bạn muốn xem (10084 thường là Zabbix Server)
            search: {
                //key_: "system.cpu.util" // Tìm tất cả item có chữ "system.cpu" trong key
                // name: "CPU utilization"
            },
            sortfield: "name",
        },
        // auth: API_TOKEN,
        id: 1,
    };

    // Thực hiện lệnh Fetch
    const response = await fetch(ZABBIX_URL, {
        method: "POST", // Zabbix luôn dùng POST
        headers: {
            "Content-Type": "application/json-rpc",
            Authorization: API_TOKEN,
        },
        body: JSON.stringify(payload),
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

// Lấy log cảnh báo
// const getAlertLogs = async () => {
//     // get list log
//     const logList = document.getElementById('logList');
//     const countWarningEl = document.querySelector("#countWarning");
//     const countInfoEl = document.querySelector("#countInfo");
//     const countDangerEl = document.querySelector("#countDanger");


//     const payload = {
//         jsonrpc: "2.0",
//         method: "problem.get",
//         params: {
//             output: ["eventid", "clock", "name", "severity"],
//             // sortfield: "clock",
//             sortorder: "DESC",
//             limit: 100, // Lấy 100 lỗi mới nhất
//             severities: [1,2,3, 4, 5] 
//         },
//         id: 1
//     };

//     let response = await fetch(ZABBIX_URL, {
//         method: 'POST',
//         headers: {
//             'Content-Type': 'application/json-rpc',
//             'Authorization': API_TOKEN
//         },
//         body: JSON.stringify(payload)
//     });

//     let data = await response.json();
//     let problems = data.result;
//     let html = '';
//     let countWarning = 0;
//     let countInfo = 0;
//     let countDanger = 0;

//     problems.forEach(p => {
//         // Chuyển mã severity thành chữ cho dễ đọc
//         let level = "";
//         let classLevel = "secondary";

//         if (p.severity == 1) {
//             level = "Thông tin";
//             classLevel = "primary";
//             countInfo++;
//         }

//         if (p.severity == 2) {
//             level = "Cảnh báo";
//             classLevel = "warning";
//             countWarning++;
//         }
//         if (p.severity == 3) {
//             level = "Trung bình";
//             classLevel = "warning";
//             countWarning++;
//         }
//         if (p.severity == 4) {
//             level = "Cao";
//             classLevel = "danger";
//             countDanger++;
//         }
//         if (p.severity == 5) {
//             level = "Nguy hiểm";
//             classLevel = "danger";
//             countDanger++;
//         }

//         let time = new Date(p.clock * 1000).toLocaleString();
//         // console.log(`[${time}] [${level}] ${p.name}`);

//         // save log
//         fetch('api/savelog', {
//             method: 'POST',
//             headers: {
//                 'Content-Type': 'application/json',
//             },
//             body: JSON.stringify({
//                 severity: p.severity,
//                 name: p.name,
//                 eventid: p.eventid
//             })
//         });

//         html += `<div class="alert alert-${classLevel} mg-b-1" role="alert">
//                     <strong>[${level}]</strong> ${p.name} <br/>
//                     <small class="text-muted">${time}</small>
//                 </div>`;
//     });

//     logList.insertAdjacentHTML('beforeend', html);

//     countWarningEl.innerText = countWarning;
//     console.log(countWarning);
    
//     countInfoEl.innerText = countInfo;
//     countDangerEl.innerText = countDanger;
// };

// Lấy log cảnh báo
const getAlertLogs = () => {
    // get list log
    const logList = document.getElementById("logList");
    const countWarningEl = document.querySelector("#countWarning");
    const countInfoEl = document.querySelector("#countInfo");
    const countDangerEl = document.querySelector("#countDanger");
    let countWarning = 0;
    let countInfo = 0;
    let countDanger = 0;

    axios
        .post(
            ZABBIX_URL,
            {
                jsonrpc: "2.0",
                method: "problem.get",
                params: {
                    output: ["eventid", "clock", "name", "severity"],
                    // sortfield: "clock",
                    sortorder: "DESC",
                    limit: 100, // Lấy 100 lỗi mới nhất
                    severities: [1, 2, 3, 4, 5],
                },
                id: 1,
            },
            {
                headers: {
                    "Content-Type": "application/json-rpc",
                    Authorization: API_TOKEN,
                },
            }
        )
        .then(function (response) {
            let data = response.data;
            let problems = data.result;
            let html = "";

            problems.forEach((p) => {
                // Chuyển mã severity thành chữ cho dễ đọc
                let level = "";
                let classLevel = "secondary";

                if (p.severity == 1) {
                    level = "Thông tin";
                    classLevel = "primary";
                    countInfo++;
                }

                if (p.severity == 2) {
                    level = "Cảnh báo";
                    classLevel = "warning";
                    countWarning++;
                }
                if (p.severity == 3) {
                    level = "Trung bình";
                    classLevel = "warning";
                    countWarning++;
                }
                if (p.severity == 4) {
                    level = "Cao";
                    classLevel = "danger";
                    countDanger++;
                }
                if (p.severity == 5) {
                    level = "Nguy hiểm";
                    classLevel = "danger";
                    countDanger++;
                }

                let time = new Date(p.clock * 1000).toLocaleString();

                // save log
                fetch("api/savelog", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                    },
                    body: JSON.stringify({
                        severity: p.severity,
                        name: p.name,
                        eventid: p.eventid,
                    }),
                });

                html += `<div class="alert alert-${classLevel} mg-b-1" role="alert">
                        <strong>[${level}]</strong> ${p.name} <br/>
                        <small class="text-muted">${time}</small>
                    </div>`;
            });

            logList.insertAdjacentHTML("beforeend", html);

            countWarningEl.innerText = countWarning;
            countInfoEl.innerText = countInfo;
            countDangerEl.innerText = countDanger;
        })
        .catch(function (error) {
            console.log(error); // Handle any errors
        });
};

// Các code chạy
document.addEventListener("DOMContentLoaded", function () {
    getAlertLogs();

    // get list server status
    const cpuUtilizationText = document.querySelector(
        "#mikrotik #cpuUtilizationText"
    );
    const cpuUtilization = document.querySelector("#mikrotik #cpuUtilization");
    const memoryUtilizationText = document.querySelector(
        "#mikrotik #memoryUtilizationText"
    );
    const memoryUtilization = document.querySelector(
        "#mikrotik #memoryUtilization"
    );

    const zabbixCpuUtilizationText = document.querySelector(
        "#zabbix #cpuUtilizationText"
    );
    const zabbixCpuUtilization = document.querySelector(
        "#zabbix #cpuUtilization"
    );
    const zabbixMemoryUtilizationText = document.querySelector(
        "#zabbix #memoryUtilizationText"
    );
    const zabbixMemoryUtilization = document.querySelector(
        "#zabbix #memoryUtilization"
    );

    const memoryAvailableText = document.querySelector("#memoryAvailableText");
    const memoryAvailable = document.querySelector("#memoryAvailable");
    const memoryAvailableValue = document.querySelector(
        "#memoryAvailableValue"
    );

    getSystemStats(10770)
        .then((items) => {
            if (!items || !Array.isArray(items)) return; // Kiểm tra dữ liệu đầu vào

            let totalMemory = 0;
            let usedMemory = 0;
            let availableMemory = 0;

            items.forEach((item) => {
                // console.log(item);

                // Xử lý CPU
                if (item.name === "#1: CPU utilization") {
                    if (cpuUtilizationText && cpuUtilization) {
                        let float = parseFloat(item.lastvalue).toFixed(2);
                        let int = parseInt(item.lastvalue);

                        // console.log(int);

                        cpuUtilizationText.innerText = `CPU Mikrotik Utilization (${float}%)`;

                        let progressBar =
                            cpuUtilization.querySelector(".progress-bar");
                        if (progressBar) {
                            // --- ĐOẠN SỬA ---
                            // Không xóa class gốc để giữ màu sắc/style
                            // Dùng style.width để set chính xác %
                            progressBar.style.width = `${int}%`;
                            progressBar.setAttribute("aria-valuenow", int);
                            // ----------------
                        }
                    }
                }

                // Xử lý Memory
                if (item.name === "Memory utilization") {
                    if (memoryUtilizationText && memoryUtilization) {
                        let float = parseFloat(item.lastvalue).toFixed(2);
                        let int = parseInt(item.lastvalue);

                        memoryUtilizationText.innerText = `Memory Mikrotik Utilization (${float}%)`;

                        let progressBar =
                            memoryUtilization.querySelector(".progress-bar");
                        if (progressBar) {
                            // --- ĐOẠN SỬA ---
                            // Đảm bảo class nền (bg-teal) không bị mất
                            // Nếu bạn reset className = '...', nó sẽ mất style mặc định
                            if (!progressBar.classList.contains("bg-teal")) {
                                progressBar.classList.add("bg-teal");
                            }

                            progressBar.style.width = `${int}%`;
                            progressBar.setAttribute("aria-valuenow", int);
                        }
                    }
                }

                const cpuMikrotikValue =
                    document.querySelector("#cpuMikrotikValue");
                const memoryMikrotikAvailableValue = document.querySelector(
                    "#memoryMikrotikAvailableValue"
                );

                if (item.name === "Number of CPUs") {
                    if (cpuMikrotikValue) {
                        cpuMikrotikValue.innerText = item.lastvalue;
                    }
                }

                if (item.name === "Available memory") {
                    if (memoryMikrotikAvailableValue) {
                        memoryMikrotikAvailableValue.innerText = `${(
                            item.lastvalue /
                            1024 ** 3
                        ).toFixed(2)} GB`;
                    }
                }

                if (item.key_ === "vm.memory.total[hrStorageSize.Memory]") {
                    totalMemory = item.lastvalue;
                }

                if (item.key_ === "vm.memory.used[hrStorageUsed.Memory]") {
                    usedMemory = item.lastvalue;
                }
            });
            // Tính toán phần khả dụng
            availableMemory =
                (parseFloat(totalMemory) - parseFloat(usedMemory)) / 1024 ** 3;
            memoryAvailableValue.innerText = `${parseFloat(
                availableMemory
            ).toFixed(2)} GB`;
        })
        .catch((error) => {
            console.error("Lỗi khi lấy thông tin hệ thống:", error);
        });

    // Zabbix
    getSystemStats(10084)
        .then((items) => {
            if (!items || !Array.isArray(items)) return; // Kiểm tra dữ liệu đầu vào

            items.forEach((item) => {
                // console.log(item);

                // Xử lý CPU
                if (item.name === "CPU utilization") {
                    if (zabbixCpuUtilizationText && zabbixCpuUtilization) {
                        let float = parseFloat(item.lastvalue).toFixed(2);
                        let int = parseInt(item.lastvalue);

                        zabbixCpuUtilizationText.innerText = `CPU Zabbix Utilization (${float}%)`;

                        let progressBar =
                            zabbixCpuUtilization.querySelector(".progress-bar");
                        if (progressBar) {
                            // --- ĐOẠN SỬA ---
                            // Không xóa class gốc để giữ màu sắc/style
                            // Dùng style.width để set chính xác %
                            progressBar.style.width = `${int}%`;
                            progressBar.setAttribute("aria-valuenow", int);
                        }
                    }
                }

                // Xử lý Memory
                if (item.name === "Memory utilization") {
                    if (
                        zabbixMemoryUtilizationText &&
                        zabbixMemoryUtilization
                    ) {
                        let float = parseFloat(item.lastvalue).toFixed(2);
                        let int = parseInt(item.lastvalue);

                        zabbixMemoryUtilizationText.innerText = `Memory Zabbix Utilization (${float}%)`;

                        let progressBar =
                            zabbixMemoryUtilization.querySelector(
                                ".progress-bar"
                            );
                        if (progressBar) {
                            // --- ĐOẠN SỬA ---
                            // Đảm bảo class nền (bg-teal) không bị mất
                            // Nếu bạn reset className = '...', nó sẽ mất style mặc định
                            if (!progressBar.classList.contains("bg-teal")) {
                                progressBar.classList.add("bg-teal");
                            }

                            progressBar.style.width = `${int}%`;
                            progressBar.setAttribute("aria-valuenow", int);
                        }
                    }
                }

                const cpuZabbixValue =
                    document.querySelector("#cpuZabbixValue");
                const memoryZabbixAvailableValue = document.querySelector(
                    "#memoryZabbixAvailableValue"
                );

                if (item.name === "Number of CPUs") {
                    if (cpuZabbixValue) {
                        cpuZabbixValue.innerText = item.lastvalue;
                    }
                }

                if (item.name === "Available memory") {
                    if (memoryZabbixAvailableValue) {
                        memoryZabbixAvailableValue.innerText = `${(
                            item.lastvalue /
                            1024 ** 3
                        ).toFixed(2)} GB`;
                    }
                }

                if (item.key_ === "vm.memory.total[hrStorageSize.Memory]") {
                    totalMemory = item.lastvalue;
                }

                if (item.key_ === "vm.memory.used[hrStorageUsed.Memory]") {
                    usedMemory = item.lastvalue;
                }
            });
        })
        .catch((error) => {
            console.error("Lỗi khi lấy thông tin hệ thống:", error);
        });

    // Fortinet
    getSystemStats(10778)
        .then((items) => {
            if (!items || !Array.isArray(items)) return; // Kiểm tra dữ liệu đầu vào

            const memoryFortinetAvailableValue = document.querySelector(
                "#memoryFortinetAvailableValue"
            );

            items.forEach((item) => {
                // console.log(item);

                // Xử lý Memory Fortinet
                if (item.name === "Available memory") {
                    if (memoryFortinetAvailableValue) {
                        memoryFortinetAvailableValue.innerText = `${(
                            item.lastvalue /
                            1024 ** 3
                        ).toFixed(2)} GB`;
                    }
                }
            });
        })
        .catch((error) => {
            console.error("Lỗi khi lấy thông tin hệ thống:", error);
        });

    // Lấy danh sách thiết bị
    getZabbixHosts()
        .then((items) => {
            if (!items || !Array.isArray(items)) return; // Kiểm tra dữ liệu đầu vào

            const listDevice = document.querySelector("#listDevice");
            let html = "";

            items.forEach((item) => {
                // console.log(item.name);

                html += `
                    <p>${item.name} - ${item.interfaces[0].ip} - ${item.hostid}</p>
                `;

                listDevice.innerHTML = html;
            });
        })
        .catch((error) => {
            console.error("Lỗi khi lấy thông tin hệ thống:", error);
        });

    // Vẽ sơ đồ lịch sử CPU, RAM
    getHistoryStats();

    // Lịch sử tốc độ mạng 10770 mikrotik
    getBandwidthHistory(10770); // Thay 10084 bằng ID host bạn muốn kiểm tra

    const btnDiagnose = document.querySelector("#btnDiagnose");

    btnDiagnose.addEventListener("click", (e) => {
        e.preventDefault();
        console.log("ok");

        let diagnose = document.querySelector("#diagnose");

        // diagnose
        axios
            .get("api/getloglist")
            .then(function (response) {
                // diagnose.innerText = "Đang phân tích...";

                if (response.data.original.reply !== "") {
                    // handle success
                    diagnose.innerHTML = response.data.original.reply;
                    let t = response.data;
                    t = t.original.reply;
                    // console.log(t);
                }
            })
            .catch(function (error) {
                // handle error
                console.log(error);
            })
            .finally(function () {
                // always executed
            });
    });
});

// Lấy log user tác động
// const getAuditLog = async () => {
//     let payload = {
//         jsonrpc: "2.0",
//         method: "auditlog.get",
//         params: {
//             output: "extend",
//             // sortfield: "clock",
//             sortorder: "DESC",
//             limit: 10 // Lấy 10 hành động gần nhất
//         },
//         // auth: API_TOKEN,
//         id: 1
//     };

//     let response = await fetch(ZABBIX_URL, {
//         method: 'POST',
//         headers: {
//             'Content-Type': 'application/json-rpc', // Hoặc 'application/json'
//             'Authorization': API_TOKEN
//         },
//         body: JSON.stringify(payload)
//     });

//     let data = await response.json();
//     let problems = data.result;

//     console.log("--- problems ---");
//     console.log(problems);

// };

// getAuditLog();

const getBandwidthHistory = async (hostId) => {
    // BƯỚC 1: Tìm Item ID của Traffic Out (Upload) và In (Download)
    // Key chuẩn thường là: net.if.in[tên_card_mạng] hoặc net.if.out[...]
    const itemRes = await fetch(ZABBIX_URL, {
        method: "POST",
        headers: {
            "Content-Type": "application/json-rpc", // Hoặc 'application/json'
            Authorization: API_TOKEN,
        },
        body: JSON.stringify({
            jsonrpc: "2.0",
            method: "item.get",
            params: {
                output: ["itemid", "name", "key_"],
                hostids: hostId,
                search: { key_: "net.if.in" }, // Tìm traffic đầu vào
                sortfield: "name",
            },
            id: 2,
        }),
    });

    const itemData = await itemRes.json();
    if (itemData.result.length === 0)
        return console.log("Không tìm thấy item mạng.");

    const netItemId = itemData.result[0].itemid; // Lấy cái card mạng đầu tiên tìm thấy
    const netName = itemData.result[0].name;

    // BƯỚC 2: Lấy lịch sử băng thông
    const historyRes = await fetch(ZABBIX_URL, {
        method: "POST",
        headers: {
            "Content-Type": "application/json-rpc", // Hoặc 'application/json'
            Authorization: API_TOKEN,
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
                limit: 8,
            },
            id: 3,
        }),
    });

    const historyData = await historyRes.json();

    // console.log(`--- LỊCH SỬ BĂNG THÔNG (${netName}) ---`);
    // console.log(historyData);

    const logTraffic = document.querySelector("#logTraffic");

    let html = "";

    historyData.result.forEach((h) => {
        const time = new Date(h.clock * 1000).toLocaleTimeString();
        // Zabbix lưu đơn vị là bps (bits per second), chia 1000*1000 ra Mbps
        const mbps = (h.value / 1000000).toFixed(2);
        // console.log(`[${time}] Tốc độ: ${mbps} Mbps`);

        // html += `<p>[${time}] Tốc độ: ${mbps} Mbps</p>`;
        html += `<div class="alert alert-info mg-b-1" role="alert">
                    <strong>${mbps}</strong> Mbps<br/>
                    <small class="text-muted">${time}</small>
                </div>`;
    });

    logTraffic.innerHTML = html;

    // console.log(hz);
};

// Lấy lịch sử CPU, RAM
async function callZabbix(method, params) {
    const response = await fetch(ZABBIX_URL, {
        method: "POST",
        headers: {
            "Content-Type": "application/json-rpc", // Hoặc 'application/json'
            Authorization: API_TOKEN,
        },
        body: JSON.stringify({
            jsonrpc: "2.0",
            method: method,
            params: params,
            id: Date.now(),
        }),
    });
    const data = await response.json();
    if (data.error) throw new Error(data.error.data);
    return data.result;
}

async function getHistoryStats() {
    // khai báo array lưu lại
    const arrayNumber = [];
    const arrayNumberMemory = [];

    try {
        // console.log("1. Đang tìm Item ID cho CPU và RAM...");

        // Bước 1: Lấy thông tin Item để biết ID và Kiểu dữ liệu (value_type)
        // value_type: 0=Float, 3=Unsigned Int
        const items = await callZabbix("item.get", {
            output: ["itemid", "name", "key_", "value_type", "units"],
            hostids: "10770",
            search: {
                key_: ["system.cpu.util", "vm.memory.util"], // Tìm 2 key này
            },
            searchByAny: true,
        });

        // console.log(items);

        if (items.length === 0)
            return console.error("Không tìm thấy Item nào!");

        // Bước 2: Lặp qua từng Item để lấy lịch sử
        for (const item of items) {
            // console.log(`\n--- Đang lấy lịch sử cho: ${item.name} (${item.key_}) ---`);

            const historyData = await callZabbix("history.get", {
                output: "extend",
                history: item.value_type, // Tự động điền 0 hoặc 3 dựa vào item
                itemids: item.itemid,
                sortfield: "clock",
                sortorder: "DESC", // Mới nhất lấy trước
                limit: 20, // Lấy 10 dòng dữ liệu gần nhất
            });

            // In kết quả
            historyData.forEach((h) => {
                // const time = new Date(h.clock * 1000).toLocaleString();
                let value = parseFloat(h.value);

                // Nếu là RAM (Bytes) thì đổi sang GB cho dễ nhìn
                if (item.units === "B") {
                    value = (value / 1073741824).toFixed(2);
                } else {
                    value = value.toFixed(2);
                }

                if (item.key_ == "system.cpu.util[hrProcessorLoad.1]") {
                    arrayNumber.push(value);
                }

                if (
                    item.key_ == "vm.memory.util[memoryUsedPercentage.Memory]"
                ) {
                    arrayNumberMemory.push(value);
                }

                // console.log(value);

                // console.log(`[${time}] Giá trị: ${value}`);
            });
        }
    } catch (e) {
        console.error("Lỗi:", e);
    }

    new Chartist.Line(
        "#ch1",
        {
            // labels: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
            series: [
                //   [4, 9, 7, 8, 5, 3, 5, 4],
                //   [10, 15, 10, 17, 8, 11, 16, 10]
                arrayNumber,
                arrayNumberMemory,
            ],
        },
        {
            high: 100,
            low: 0,
            axisY: {
                onlyInteger: true,
            },
            showArea: true,
            fullWidth: true,
            chartPadding: {
                bottom: 0,
                left: 0,
            },
            // --- PHẦN ĐƯỢC THÊM VÀO ---
            plugins: [
                Chartist.plugins.tooltip({
                    appendToBody: true, // Giúp tooltip không bị che khuất
                    anchorToPoint: true, // Tooltip dính chặt vào điểm
                    class: "ct-tooltip", // Class mặc định để style
                }),
            ],
        }
    );
}
