<?php
 goto W7zrF; NzvwE: P9oSG: goto H_xFR; ODMzu: $openid = $_W["\157\x70\x65\x6e\151\144"]; goto zCOy1; lDuj8: if (!$_GPC["\163\x63\162\x6f\x6c\154"]) { goto n_dfG; } goto u6xzZ; u6xzZ: if (!empty($list)) { goto loUUz; } goto aH8kk; C3vxC: if (empty($list)) { goto LtgQK; } goto rrk1o; eZXGG: $data = array("\x73\x74\141\164\x75\163" => "\61", "\154\x69\x73\x74\x73" => $list); goto NzvwE; GvI64: LtgQK: goto lDuj8; rll6f: $limit = "\x6c\151\155\151\x74\x20" . ($pageindex - 1) * $pagesize . "\54" . $pagesize; goto IMP4b; zCOy1: if (!empty($openid)) { goto ilbMR; } goto igLZw; aH8kk: $data = array("\x73\x74\x61\x74\x75\163" => "\x30"); goto Jb6CQ; vkjfX: $footerWith = 100 / count($footer); goto LFMr1; jOFRn: $mem = get("\x73\x65\x6c\x65\143\x74\x20\151\144\x20\146\x72\x6f\x6d\x20" . tb("\155\x65\x6d") . "\40\167\x68\x65\x72\x65\40\157\x70\x65\x6e\x69\144\x3d\47{$openid}\x27\x20\x61\x6e\144\x20\167\x65\x69\144\x3d\47{$_W["\165\x6e\x69\x61\x63\x69\x64"]}\x27"); goto Ct8S8; QZ4kC: $goods = getall("\x73\x65\154\145\x63\x74\40\151\x64\54\164\151\x74\154\x65\54\163\165\142\x5f\164\151\164\x6c\x65\x2c\x6c\x6f\x67\x6f\54\x70\x72\x69\x63\x65\54\x63\x6f\x73\x74\x70\x72\151\x63\145\54\x6c\x61\x62\145\154\x20\x66\162\157\x6d\x20" . tb("\x67\x6f\157\144") . "\40\x77\x68\145\x72\x65\40\x69\144\x20\151\156\x20\50" . implode("\54", $gids) . "\x29", "\x69\x64"); goto EypHw; bJGTS: $pageindex = max(1, intval($_GPC["\160\x61\x67\x65"])); goto rll6f; PzNaD: loUUz: goto eZXGG; tCncD: $txt = array("\155\171" => $cfg["\146\157\x6e\x74"]["\x6d\171"], "\x63\x6f\163\x74" => $cfg["\146\x6f\x6e\x74"]["\x63\157\163\x74"], "\x6e\157\164\150\x69\156\147" => $cfg["\x66\x6f\x6e\164"]["\156\x6f\164\x68\151\156\x67"], "\163\x65\154\x67\x6f\157\144" => $cfg["\146\157\156\x74"]["\163\145\154\147\157\x6f\144"]); goto Z76l1; rrk1o: foreach ($list as $k => $v) { $gids[] = $v["\147\x69\x64"]; Q7REk: } goto IdY8n; jrFIA: $share = $this->getShare($_W["\157\160\145\156\151\x64"], $cfg); goto O5cL_; IMP4b: $list = getall("\x73\145\x6c\145\x63\x74\40\x69\144\54\x6f\x72\144\145\x72\156\157\54\147\151\x64\54\x70\162\x69\x63\x65\54\x73\x74\141\164\x75\163\54\x6e\x75\x6d\54\x65\x78\x70\162\145\163\x73\x2c\145\170\x70\x72\x65\163\163\156\157\54\x77\170\x5f\x6e\157\x20\146\x72\157\x6d\x20" . tb("\x72\157\165\x67\145") . "\40\x77\150\145\162\x65\x20\167\x65\151\x64\x3d\47{$_W["\165\x6e\x69\x61\x63\151\x64"]}\47\40\x61\x6e\x64\40\155\x69\144\75\47{$mem["\151\x64"]}\x27\x20\141\x6e\144\x20\163\x74\141\x74\x75\163\76\x30\x20\x6f\x72\x64\x65\x72\40\x62\x79\x20\x69\144\x20\144\x65\x73\143\x20{$limit}"); goto C3vxC; z2szQ: ilbMR: goto jOFRn; Ct8S8: $cfg = $this->module["\143\157\156\146\151\147"]; goto XfPzL; igLZw: $openid = $_GPC["\157\160\x65\156\x69\x64"]; goto z2szQ; W7zrF: global $_GPC, $_W; goto ODMzu; X30Ts: n_dfG: goto tCncD; QOoOV: $pagesize = 10; goto bJGTS; IdY8n: x0JtP: goto QZ4kC; XfPzL: $express = getExpress(); goto V2Yn2; R4XDy: esXYk: goto GvI64; EypHw: foreach ($list as $k => $v) { goto la83A; TK2Tu: if ($v["\163\x74\x61\164\165\163"] == 1) { goto Sa_e0; } goto QCZCx; ktue2: $list[$k]["\163\x74\x61\164\165\x73\137\x64\145\163"] = "\345\267\262\xe5\217\x91\350\xb4\247"; goto sLZu2; snoz0: $list[$k]["\x73\x75\142\137\164\x69\x74\154\x65"] = $goods[$v["\147\151\144"]]["\x73\x75\142\x5f\164\x69\x74\x6c\145"]; goto GFXoe; Yas2J: UlSJY: goto Pl6qL; oQ6qd: goto gRNw8; goto WfJr_; nDJIc: $list[$k]["\145\x78\160\x72\145\163\163"] = $express[$v["\145\170\x70\162\145\163\x73"]]; goto s1Jeq; yqT9k: if (!($list[$k]["\x70\162\x69\x63\145"] <= 0)) { goto FupJx; } goto sMd6K; GFXoe: $list[$k]["\154\141\x62\x65\154"] = $goods[$v["\147\151\144"]]["\154\x61\142\x65\154"]; goto cLqwb; WfJr_: Sa_e0: goto q2PeJ; I0Vds: if (!($v["\163\164\141\x74\x75\163"] == 2 && empty($v["\x77\x78\137\x6e\157"]))) { goto UlSJY; } goto nDJIc; CHssC: goto gRNw8; goto AzeMa; NFXxe: $list[$k]["\x73\x74\x61\164\x75\x73\137\x64\x65\x73"] = "\xe5\276\205\346\224\xaf\xe4\273\x98"; goto oQ6qd; sMd6K: $list[$k]["\x70\x72\151\x63\145"] = $goods[$v["\x67\151\144"]]["\x70\x72\x69\x63\145"]; goto M87nW; K2UBg: $list[$k]["\143\157\163\x74\x70\x72\x69\x63\145"] = $goods[$v["\147\x69\144"]]["\x63\x6f\x73\x74\x70\162\151\143\145"]; goto TK2Tu; M87nW: FupJx: goto K2UBg; cLqwb: $list[$k]["\154\x6f\147\x6f"] = toimage($goods[$v["\x67\151\x64"]]["\x6c\x6f\x67\157"]); goto yqT9k; AzeMa: Sxbzx: goto ktue2; sLZu2: gRNw8: goto I0Vds; s1Jeq: $list[$k]["\145\170\160\162\145\x73\x73\116\141\x6d\x65"] = $expressNo[$v["\x65\x78\160\x72\145\x73\163"]]; goto Nrqt5; QCZCx: if ($v["\163\164\141\x74\165\x73"] == 2) { goto Sxbzx; } goto NFXxe; la83A: $list[$k]["\x74\151\164\x6c\x65"] = $goods[$v["\x67\x69\x64"]]["\164\x69\x74\154\x65"]; goto snoz0; q2PeJ: $list[$k]["\x73\x74\141\164\x75\x73\137\144\145\163"] = "\xe5\xbe\x85\xe5\x8f\221\350\264\247"; goto CHssC; Pl6qL: hxcGh: goto kiQ5H; Nrqt5: $list[$k]["\x65\170\x70\162\145\x73\x73\x55\162\154"] = "\x68\164\164\x70\163\x3a\57\x2f\155\56\153\165\x61\x69\144\151\61\60\x30\56\143\157\155\57\151\x6e\x64\x65\x78\137\141\x6c\154\x2e\150\x74\x6d\154\x3f\x74\x79\x70\145\75{$list[$k]["\145\170\x70\x72\145\x73\x73\x4e\x61\155\x65"]}\46\x70\x6f\163\x74\x69\x64\75{$v["\x65\x78\160\x72\145\163\163\x6e\157"]}"; goto Yas2J; kiQ5H: } goto R4XDy; H_xFR: die(json_encode($data)); goto X30Ts; Jb6CQ: goto P9oSG; goto PzNaD; Z76l1: $face = array("\162\x69\147\150\x74" => empty($cfg["\x66\141\143\145"]["\162\x69\x67\x68\164"]) ? '' : toimage($cfg["\x66\141\143\145"]["\x72\x69\147\150\x74"]), "\141\x70\x70\x5f\x6e\157\x74\150\x69\x6e\147" => empty($cfg["\x66\x61\143\145"]["\x61\160\x70\x5f\156\x6f\x74\150\x69\x6e\147"]) ? '' : toimage($cfg["\146\141\143\x65"]["\x61\x70\160\137\156\x6f\x74\x68\151\156\x67"])); goto jrFIA; V2Yn2: $expressNo = getExpressNo(); goto QOoOV; O5cL_: $footer = $cfg["\146\x6f\x6f\164\x65\162"]; goto vkjfX; LFMr1: include $this->template("\x72\x6f\165\147\x65");