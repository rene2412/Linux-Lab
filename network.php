<?php 
global $ping, $ip, $route, $traceroute, $nslookup, $dig, $host, $curl, $curl_api, $wget, $index, $ip_route;
$ping = "PING google.com (2607:f8b0:4005:812::200e) 56 data bytes  
64 bytes from nuq04s45-in-x0e.1e100.net (2607:f8b0:4005:812::200e): icmp_seq=1 ttl=250 time=139 ms
64 bytes from nuq04s45-in-x0e.1e100.net (2607:f8b0:4005:812::200e): icmp_seq=2 ttl=250 time=161 ms
64 bytes from nuq04s45-in-x0e.1e100.net (2607:f8b0:4005:812::200e): icmp_seq=3 ttl=250 time=80.1 ms
64 bytes from nuq04s45-in-x0e.1e100.net (2607:f8b0:4005:812::200e): icmp_seq=4 ttl=250 time=44.8 ms
64 bytes from nuq04s45-in-x0e.1e100.net (2607:f8b0:4005:812::200e): icmp_seq=5 ttl=250 time=65.2 ms
64 bytes from nuq04s45-in-x0e.1e100.net (2607:f8b0:4005:812::200e): icmp_seq=6 ttl=250 time=250 ms
64 bytes from nuq04s45-in-x0e.1e100.net (2607:f8b0:4005:812::200e): icmp_seq=7 ttl=250 time=49.9 ms
64 bytes from nuq04s45-in-x0e.1e100.net (2607:f8b0:4005:812::200e): icmp_seq=8 ttl=250 time=90.1 ms
64 bytes from nuq04s45-in-x0e.1e100.net (2607:f8b0:4005:812::200e): icmp_seq=9 ttl=250 time=53.1 ms
64 bytes from nuq04s45-in-x0e.1e100.net (2607:f8b0:4005:812::200e): icmp_seq=10 ttl=250 time=57.5 ms
--- google.com ping statistics ---
10 packets transmitted, 10 received, 0% packet loss, time 9013ms
rtt min/avg/max/mdev = 44.763/98.985/249.913/62.369 ms";

$ip_route = 
"default via 192.168.1.1 dev wlp3s0 proto dhcp src 192.168.1.217 metric 600
192.168.1.0/24 dev wlp3s0 proto kernel scope link src 192.168.1.217 metric 600";
$telnet = "";
$ifconfig = 
    "enp1s0: flags=4099<UP,BROADCAST,MULTICAST>  mtu 1500
        ether 84:47:09:35:83:0e  txqueuelen 1000  (Ethernet)
        RX packets 0  bytes 0 (0.0 B)
        RX errors 0  dropped 0  overruns 0  frame 0
        TX packets 0  bytes 0 (0.0 B)
        TX errors 0  dropped 0 overruns 0  carrier 0  collisions 0
        device memory 0xfcc00000-fccfffff  

enp2s0: flags=4099<UP,BROADCAST,MULTICAST>  mtu 1500
        ether 84:47:09:35:83:11  txqueuelen 1000  (Ethernet)
        RX packets 0  bytes 0 (0.0 B)
        RX errors 0  dropped 0  overruns 0  frame 0
        TX packets 0  bytes 0 (0.0 B)
        TX errors 0  dropped 0 overruns 0  carrier 0  collisions 0
        device memory 0xfc900000-fc9fffff  

lo: flags=73<UP,LOOPBACK,RUNNING>  mtu 65536
        inet 127.0.0.1  netmask 255.0.0.0
        inet6 ::1  prefixlen 128  scopeid 0x10<host>
        loop  txqueuelen 1000  (Local Loopback)
        RX packets 15043  bytes 10527961 (10.5 MB)
        RX errors 0  dropped 0  overruns 0  frame 0
        TX packets 15043  bytes 10527961 (10.5 MB)
        TX errors 0  dropped 0 overruns 0  carrier 0  collisions 0

wlp3s0: flags=4163<UP,BROADCAST,RUNNING,MULTICAST>  mtu 1500
        inet 192.168.1.203  netmask 255.255.255.0  broadcast 192.168.1.255
        inet6 2600:1010:a121:9b5b:1aa1:9da1:8698:3a0  prefixlen 64  scopeid 0x0<global>
        inet6 2600:1010:a121:9b5b:3d70:e6fc:ffb1:8eab  prefixlen 64  scopeid 0x0<global>
        inet6 fe80::243a:9f1c:31c6:1048  prefixlen 64  scopeid 0x20<link>
        ether 50:e4:78:73:48:fd  txqueuelen 1000  (Ethernet)
        RX packets 3442836  bytes 4163221030my fault  (4.1 GB)
        RX errors 0  dropped 0  overruns 0  frame 0
        TX packets 1451503  bytes 303383335 (303.3 MB)
        TX errors 0  dropped 0 overruns 0  carrier 0  collisions 0
";

$route = "default via 192.168.X.1 dev eth0 proto dhcp src 192.168.X.100 metric 600  
192.168.X.0/24 dev eth0 proto kernel scope link src 192.168.X.100 metric 600";

$traceroute = "traceroute to google.com (142.251.46.206), 64 hops max
  1   192.168.1.1  1.085ms  1.341ms  0.938ms 
  2   10.200.50.1  300.480ms  310.785ms  303.548ms 
  3   10.200.50.2  306.879ms  307.119ms  307.481ms 
  4   *  10.200.50.3  68.641ms  * 
  5   172.18.5.20  68.616ms  306.989ms  307.136ms"; 

$nslookup =  
"Server:	129.8.15.50
Address:	129.8.15.50#53

Non-authoritative answer:
Name:	google.com
Address: 142.250.189.14";

$dig = 
"; <<>> DiG 9.10.6 <<>> google.com
;; global options: +cmd
;; Got answer:
;; ->>HEADER<<- opcode: QUERY, status: NOERROR, id: 4024
;; flags: qr rd ra; QUERY: 1, ANSWER: 1, AUTHORITY: 0, ADDITIONAL: 1

;; OPT PSEUDOSECTION:
; EDNS: version: 0, flags:; udp: 1220
;; QUESTION SECTION:
;google.com.			IN	A

;; ANSWER SECTION:
google.com.		149	IN	A	142.250.189.14

;; Query time: 11 msec
;; SERVER: 129.8.15.50#53(129.8.15.50)
;; WHEN: Tue Feb 18 14:33:12 PST 2025
;; MSG SIZE  rcvd: 55";

$host = 
"google.com has address 142.250.189.14
google.com mail is handled by 10 smtp.google.com.";

$curl = 
'1 <!DOCTYPE html>
2 <html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US" prefix="og: http://ogp.me/ns#" class="no-js" data-layout-name="valentines-takedown">
3 <head>
4
5
6 <meta charset="utf-8" />
7 <link rel="canonical" href="https://www.apple.com/" />
8
9
10         <script>
13
16         }
17
18         var endPoint = rootPath + "/shop/experience-meta";
19
20         if (!window.acTargetCustomSettings) {
21                 window.acTargetCustomSettings = {
22                         constants : {
23                                 asTexServiceEndpoint: endPoint
24                         }
25                 }
26         } else {
27                 if (!window.acTargetCustomSettings.constants) {
28                         window.acTargetCustomSettings.constants = {};
29                 }
30                 window.acTargetCustomSettings.constants.asTexServiceEndpoint = window.acTargetCustomSettings.constants.asTexServiceEndpoint || endPoint;
31         }
41
42
43                 <link rel="stylesheet" type="text/css" href="/api-www/global-elements/global-header/v1/assets/globalheader.css" />
44                 <link rel="stylesheet" type="text/css" href="/ac/globalfooter/8/en_US/styles/ac-globalfooter.built.css" />
45
46         <link rel="stylesheet" type="text/css" href="/ac/localnav/9/styles/ac-localnav.built.css" />
47
48         <title>Apple</title>
49         <meta property="analytics-track" content="Apple - Index/Tab" />
50         <meta property="analytics-s-channel" content="homepage" />
51
52         <meta property="analytics-s-bucket-0" content="applestoreww" />
53         <meta property="analytics-s-bucket-1" content="applestoreww" />
54         <meta property="analytics-s-bucket-2" content="applestoreww" />
55
56         <meta name="Description" content="Discover the innovative world of Apple and shop everything iPhone, iPad, Apple Watch, Mac, and Apple TV, plus explore accessories, ent     ertainment, and expert device support." />
57         <meta property="og:title" content="Apple" />
58         <meta property="og:description" content="Discover the innovative world of Apple and shop everything iPhone, iPad, Apple Watch, Mac, and Apple TV, plus explore accessori     es, entertainment, and expert device support." />
59         <meta property="og:url" content="https://www.apple.com/" />
60         <meta property="og:locale" content="en_US" />
61         <meta property="og:image" content="https://www.apple.com/ac/structured-data/images/open_graph_logo.png?202110180743" />
62         <meta property="og:type" content="website" />
63         <meta property="og:site_name" content="Apple" />
64         <link rel="stylesheet" href="/wss/fonts?families=SF+Pro,v3|SF+Pro+Icons,v3" type="text/css" media="all" />
65         <link rel="stylesheet" href="/v/home/ca/built/styles/main.built.css" type="text/css" />
66         <script src="/v/home/ca/built/scripts/head.built.js" type="text/javascript" charset="utf-8"></script>
67 </head>
68 <body  class="page-home ac-nav-overlap globalnav-scrim globalheader-dark" >
69
70         <h1 class="visuallyhidden">Apple</h1>';

$curl_api = 
"Los Angeles, California, United States: ☀️   +64°F";

$wget = "--2025-02-24 12:18:36--  http://example.com/
Resolving example.com (example.com)... 23.215.0.138, 96.7.128.175, 96.7.128.198, ...
Connecting to example.com (example.com)|23.215.0.138|:80... connected.
HTTP request sent, awaiting response... 200 OK
Length: 1256 (1.2K) [text/html]
Saving to: ‘index.html’

index.html          100%[===================>]   1.23K  --.-KB/s    in 0s

2025-02-24 12:18:36 (36.3 MB/s) - ‘index.html’ saved [1256/1256]";

$index = 
'<!doctype html>
<html>
<head>
    <title>Example Domain</title>

    <meta charset="utf-8" />
    <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <style type="text/css">
    body {
        background-color: #f0f0f2;
        margin: 0;
        padding: 0;
        font-family: -apple-system, system-ui, BlinkMacSystemFont, "Segoe UI", "Open Sans", "Helvetica Neue", Helvetica, Arial, sans-serif;

    }
    div {
        width: 600px;
        margin: 5em auto;
        padding: 2em;
        background-color: #fdfdff;
        border-radius: 0.5em;
        box-shadow: 2px 3px 7px 2px rgba(0,0,0,0.02);
    }
    a:link, a:visited {
        color: #38488f;
        text-decoration: none;
    }
    @media (max-width: 700px) {
        div {
            margin: 0 auto;
            width: auto;
        }
    }
    </style>
</head>

<body>
<div>
    <h1>Example Domain</h1>
    <p>This domain is for use in illustrative examples in documents. You may use this
    domain in literature without prior coordination or asking for permission.</p>
    <p><a href="https://www.iana.org/domains/example">More information...</a></p>
</div>
</body>
</html>';