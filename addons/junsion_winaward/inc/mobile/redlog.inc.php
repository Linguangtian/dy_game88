<?php
 goto mQ4LY; G9BwN: if (!empty($list)) { goto Hb0_s; } goto yamTP; rK83m: foreach ($list as $k => $v) { $list[$k]["\x63\162\145\141\x74\x65\164\x69\x6d\145"] = date("\131\55\155\x2d\144\40\110\72\x69", $v["\143\162\145\141\164\x65\164\151\x6d\x65"]); X1sBV: } goto CQHDO; m6sIo: ej6Gf: goto zwYru; FgRoW: $list = getall("\163\145\154\x65\143\x74\x20\143\162\x65\144\x69\x74\x2c\x72\145\155\141\x72\x6b\x2c\x63\162\145\141\x74\145\164\x69\155\145\40\x66\x72\x6f\x6d\x20" . tb("\x72\143\x72\145\144\151\164") . "\x20\x77\x68\145\162\145\x20\x6d\x69\144\x3d\47{$mem["\x69\x64"]}\x27\x20\157\162\x64\x65\x72\40\x62\171\x20\x63\x72\x65\x61\x74\145\164\x69\155\x65\x20\x64\x65\163\x63\x20{$limit}"); goto cM8IF; kik8C: YPGXl: goto p4vJE; zwYru: die(json_encode($data)); goto kik8C; exDtZ: goto ej6Gf; goto tTiWT; wrfYe: $footer = $cfg["\x66\x6f\x6f\x74\145\162"]; goto GlgkW; WyW0A: $openid = $_W["\157\160\145\x6e\x69\144"]; goto qHo_t; EbX0S: $share = $this->getShare($_W["\157\160\x65\x6e\x69\x64"], $cfg); goto wrfYe; U4nrx: $pagesize = 15; goto N0PT8; qEIh4: pG_bx: goto KsSM1; op_U7: $data = array("\x73\164\141\x74\x75\163" => "\x31", "\154\x69\163\x74\x73" => $list); goto m6sIo; CQHDO: p6Cnj: goto qEIh4; eVV1p: $face = array("\x61\160\x70\x5f\x6e\157\x74\150\x69\x6e\147" => empty($cfg["\x66\x61\x63\x65"]["\x6e\157\164\150\151\156\147"]) ? '' : toimage($cfg["\146\x61\143\145"]["\141\160\x70\137\156\157\x74\x68\x69\x6e\x67"])); goto EbX0S; p4vJE: $txt = array("\x72\x65\144\160\141\143\153\x65\164" => $cfg["\146\x6f\156\164"]["\162\x65\144\160\141\x63\x6b\x65\164"], "\162\145\144\x4c\157\x67" => $cfg["\146\157\x6e\164"]["\x72\145\x64\x4c\157\147"], "\156\x6f\164\150\151\x6e\147" => $cfg["\146\x6f\156\164"]["\x6e\x6f\x74\150\151\156\147"], "\163\145\154\x67\x6f\157\x64" => $cfg["\146\x6f\156\x74"]["\x73\145\x6c\147\x6f\x6f\x64"]); goto eVV1p; yamTP: $data = array("\163\164\x61\x74\165\163" => "\60"); goto exDtZ; wnbV9: $limit = "\x6c\151\x6d\x69\x74\40" . ($pageindex - 1) * $pagesize . "\x2c" . $pagesize; goto FgRoW; GlgkW: $footerWith = 100 / count($footer); goto KPnDB; VTKGx: $openid = $_GPC["\x6f\x70\145\156\151\x64"]; goto ZT710; mQ4LY: global $_GPC, $_W; goto WyW0A; ZT710: xtMoj: goto kLhns; N0PT8: $pageindex = max(1, intval($_GPC["\160\141\x67\145"])); goto wnbV9; KsSM1: if (!$_GPC["\x73\143\162\157\154\154"]) { goto YPGXl; } goto G9BwN; qHo_t: if (!empty($openid)) { goto xtMoj; } goto VTKGx; cM8IF: if (empty($list)) { goto pG_bx; } goto rK83m; kLhns: $mem = get("\x73\145\x6c\145\x63\x74\40\x69\144\x20\x66\x72\x6f\x6d\x20" . tb("\x6d\145\x6d") . "\x20\x77\150\145\162\x65\x20\x6f\160\145\156\151\x64\x3d\x27{$openid}\x27\x20\141\156\144\40\167\145\x69\x64\x3d\x27{$_W["\x75\x6e\x69\x61\143\151\x64"]}\x27"); goto nZJ0F; tTiWT: Hb0_s: goto op_U7; nZJ0F: $cfg = $this->module["\x63\157\156\146\151\147"]; goto U4nrx; KPnDB: include $this->template("\x72\x65\144\x6c\x6f\x67");