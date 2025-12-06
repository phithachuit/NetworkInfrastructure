<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    protected $data = NULL;
    protected $dataFake = '
    [
  {
    "logid": "0100020000",
    "type": "event",
    "subtype": "system",
    "level": "information",
    "datetime": "2025-01-06T09:22:14Z",
    "msg": "System started after power-loss",
    "serial": "FGT60E3U16012345",
    "hostname": "FG60E"
  },
  {
    "logid": "0100032003",
    "type": "event",
    "subtype": "system",
    "level": "notice",
    "datetime": "2025-01-06T09:23:01Z",
    "msg": "Admin admin logged in",
    "source_ip": "10.0.0.25",
    "ui": "https",
    "action": "login",
    "status": "success"
  },
  {
    "logid": "0100032005",
    "type": "event",
    "subtype": "system",
    "level": "warning",
    "datetime": "2025-01-06T09:24:14Z",
    "msg": "High memory usage detected",
    "memory_usage": 87
  },
  {
    "logid": "0100040001",
    "type": "event",
    "subtype": "network",
    "level": "notice",
    "datetime": "2025-01-06T09:26:44Z",
    "interface": "wan1",
    "status": "link-up",
    "speed": "1000Mbps",
    "duplex": "full"
  },
  {
    "logid": "0100040002",
    "type": "event",
    "subtype": "network",
    "level": "notice",
    "datetime": "2025-01-06T09:27:01Z",
    "interface": "wan2",
    "status": "link-down"
  },
  {
    "logid": "0200010000",
    "type": "traffic",
    "subtype": "forward",
    "level": "notice",
    "datetime": "2025-01-06T10:15:42Z",
    "srcip": "192.168.10.25",
    "srcport": 52321,
    "srcintf": "lan",
    "dstip": "8.8.8.8",
    "dstport": 53,
    "dstintf": "wan1",
    "proto": 17,
    "service": "DNS",
    "action": "accept",
    "policyid": 5,
    "sentbyte": 78,
    "rcvdbyte": 156
  },
  {
    "logid": "0200010001",
    "type": "traffic",
    "subtype": "forward",
    "level": "warning",
    "datetime": "2025-01-06T10:16:22Z",
    "srcip": "192.168.20.30",
    "srcport": 53422,
    "srcintf": "dmz",
    "dstip": "192.168.10.15",
    "dstport": 445,
    "dstintf": "lan",
    "proto": 6,
    "service": "SMB",
    "action": "deny",
    "policyid": 0,
    "policytype": "implicit-deny"
  },
  {
    "logid": "0200010002",
    "type": "traffic",
    "subtype": "forward",
    "level": "notice",
    "datetime": "2025-01-06T10:17:42Z",
    "srcip": "192.168.30.88",
    "srcport": 55122,
    "srcintf": "wifi",
    "dstip": "142.250.4.91",
    "dstport": 443,
    "proto": 6,
    "service": "HTTPS",
    "action": "accept",
    "policyid": 10,
    "sentbyte": 2041,
    "rcvdbyte": 4392
  },
  {
    "logid": "0300012000",
    "type": "utm",
    "subtype": "webfilter",
    "level": "warning",
    "datetime": "2025-01-06T11:06:33Z",
    "srcip": "192.168.30.25",
    "user": "student01",
    "category": "Adult/Mature Content",
    "action": "blocked",
    "url": "http://adult-site.com",
    "hostname": "adult-site.com"
  },
  {
    "logid": "0300021000",
    "type": "utm",
    "subtype": "app-ctrl",
    "level": "notice",
    "datetime": "2025-01-06T11:11:12Z",
    "srcip": "192.168.10.66",
    "app": "YouTube",
    "action": "monitor"
  },
  {
    "logid": "0400010000",
    "type": "utm",
    "subtype": "anomaly",
    "level": "warning",
    "datetime": "2025-01-06T11:02:22Z",
    "attack": "TCP.SYN.Flood",
    "srcip": "45.77.88.122",
    "dstip": "192.168.10.1",
    "action": "dropped"
  },
  {
    "logid": "0400020001",
    "type": "utm",
    "subtype": "virus",
    "level": "critical",
    "datetime": "2025-01-06T11:04:12Z",
    "virus": "Eicar-Test-File",
    "srcip": "192.168.10.55",
    "action": "blocked",
    "url": "http://testfile/eicar.com"
  },
  {
    "logid": "0500010000",
    "type": "event",
    "subtype": "vpn",
    "level": "notice",
    "datetime": "2025-01-06T10:27:35Z",
    "msg": "IPsec tunnel up",
    "tunnel": "Branch-VPNA",
    "src": "113.22.45.12",
    "dst": "42.117.10.55"
  },
  {
    "logid": "0500010001",
    "type": "event",
    "subtype": "vpn",
    "level": "warning",
    "datetime": "2025-01-06T10:28:14Z",
    "msg": "IPsec SA expired",
    "tunnel": "Branch-VPNA"
  },
  {
    "logid": "0500020000",
    "type": "event",
    "subtype": "vpn",
    "level": "notice",
    "datetime": "2025-01-06T10:31:12Z",
    "msg": "SSL VPN login succeeded",
    "user": "thach",
    "remip": "171.252.22.15"
  },
  {
    "logid": "0500020001",
    "type": "event",
    "subtype": "vpn",
    "level": "warning",
    "datetime": "2025-01-06T10:31:54Z",
    "msg": "SSL VPN login failed",
    "user": "anhvu",
    "remip": "171.252.22.77",
    "reason": "incorrect password"
  },
  {
    "logid": "0600010000",
    "type": "event",
    "subtype": "dhcp",
    "level": "notice",
    "datetime": "2025-01-06T10:11:14Z",
    "msg": "DHCP lease assigned",
    "ip": "192.168.10.152",
    "mac": "04:92:26:aa:91:12",
    "interface": "internal"
  },
  {
    "logid": "0600010001",
    "type": "event",
    "subtype": "dhcp",
    "level": "notice",
    "datetime": "2025-01-06T10:12:14Z",
    "msg": "DHCP lease expired",
    "ip": "192.168.10.122",
    "mac": "9c:ef:d5:44:55:a1"
  }
]';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = $this->data;
        $data = json_decode($this->dataFake, true);
        $count = [];
        
        foreach ($data as $item) {
            // Process each $item as needed
            // For example, you can log it or prepare it for the view
            // dd($item);
            if ($item['level'] === 'notice') {
                $count['notice'] = ($count['notice'] ?? 0) + 1;
                // array_push($count, $count['traffic']);
            }

            if ($item['level'] === 'warning') {
                $count['warning'] = ($count['warning'] ?? 0) + 1;
            }
            
            if ($item['level'] === 'critical') {
                $count['critical'] = ($count['critical'] ?? 0) + 1;
            }
        }

        return view('dashboard',compact('count', 'data'));
    }

    public function jsonData()
    {
        // $this->data = json_decode($this->dataFake, true);
        // dd(json_decode($this->dataFake, true));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
