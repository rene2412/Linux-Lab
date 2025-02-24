<?php 
global $ping, $ip, $route, $traceroute, $nslookup, $dig, $host, $curl, $curl_api, $wget, $index;
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

$ip = "1: lo: <LOOPBACK,UP,LOWER_UP> mtu 65536 qdisc noqueue state UNKNOWN group default qlen 1000
    link/loopback 00:00:00:00:00:00 brd 00:00:00:00:00:00
    inet 127.0.0.1/8 scope host lo
       valid_lft forever preferred_lft forever
    inet6 ::1/128 scope host noprefixroute 
       valid_lft forever preferred_lft forever
2: enp1s0: <NO-CARRIER,BROADCAST,MULTICAST,UP> mtu 1500 qdisc mq state DOWN group default qlen 1000
    link/ether aa:bb:cc:11:22:33 brd ff:ff:ff:ff:ff:ff
3: enp2s0: <NO-CARRIER,BROADCAST,MULTICAST,UP> mtu 1500 qdisc mq state DOWN group default qlen 1000
    link/ether aa:bb:cc:44:55:66 brd ff:ff:ff:ff:ff:ff
4: wlp3s0: <BROADCAST,MULTICAST,UP,LOWER_UP> mtu 1500 qdisc noqueue state UP group default qlen 1000
    link/ether 11:22:33:44:55:66 brd ff:ff:ff:ff:ff:ff
    inet 192.168.50.100/24 brd 192.168.50.255 scope global dynamic noprefixroute wlp3s0
       valid_lft 60738sec preferred_lft 60738sec
    inet6 2001:db8::1234:5678:abcd:ef01/64 scope global temporary dynamic 
       valid_lft 86299sec preferred_lft 14299sec
    inet6 2001:db8::abcd:ef12:3456:7890/64 scope global dynamic mngtmpaddr noprefixroute 
       valid_lft 86299sec preferred_lft 14299sec
    inet6 fe80::abcd:1234:5678:9abc/64 scope link noprefixroute 
       valid_lft forever preferred_lft forever";

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