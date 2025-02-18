<?php 
global $ping, $ip, $route, $traceroute;
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
