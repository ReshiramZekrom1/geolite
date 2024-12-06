<?php 
    if($_SERVER['REQUEST_METHOD'] == "POST") 
    { 
?> 
<html> 
  <head> 
    <title>SA:MP Objects -> MOVED</title> 
  </head> 
  <body> 
  

<?php 

	//"16777216","16777471","AU","Australia"
    
	$CheckPointsCODE = explode("\n", nl2br($_POST['code'])); 
    
    
    function GetIDFromCountryCode($countrycode) {
    
    	$geoID = 1;
        
    	
		if(strcmp($countrycode, "-") == 0) $geoID = 1;
		if(strcmp($countrycode, "AF") == 0) $geoID = 1149361;
		if(strcmp($countrycode, "AX") == 0) $geoID = 661882;
		if(strcmp($countrycode, "AL") == 0) $geoID = 783754;
		if(strcmp($countrycode, "DZ") == 0) $geoID = 2589581;
		if(strcmp($countrycode, "AS") == 0) $geoID = 5880801;
		if(strcmp($countrycode, "AD") == 0) $geoID = 3041565;
		if(strcmp($countrycode, "AO") == 0) $geoID = 3351879;
		if(strcmp($countrycode, "AI") == 0) $geoID = 3573511;
		if(strcmp($countrycode, "AQ") == 0) $geoID = 6697173;
		if(strcmp($countrycode, "AG") == 0) $geoID = 3576396;
		if(strcmp($countrycode, "AR") == 0) $geoID = 3865483;
		if(strcmp($countrycode, "AM") == 0) $geoID = 174982;
		if(strcmp($countrycode, "AW") == 0) $geoID = 3577279;
		if(strcmp($countrycode, "AU") == 0) $geoID = 2077456;
		if(strcmp($countrycode, "AT") == 0) $geoID = 2782113;
		if(strcmp($countrycode, "AZ") == 0) $geoID = 587116;
		if(strcmp($countrycode, "BS") == 0) $geoID = 3572887;
		if(strcmp($countrycode, "BH") == 0) $geoID = 290291;
		if(strcmp($countrycode, "BD") == 0) $geoID = 1210997;
		if(strcmp($countrycode, "BB") == 0) $geoID = 3374084;
		if(strcmp($countrycode, "BY") == 0) $geoID = 630336;
		if(strcmp($countrycode, "BE") == 0) $geoID = 2802361;
		if(strcmp($countrycode, "BZ") == 0) $geoID = 3582678;
		if(strcmp($countrycode, "BJ") == 0) $geoID = 2395170;
		if(strcmp($countrycode, "BM") == 0) $geoID = 3573345;
		if(strcmp($countrycode, "BT") == 0) $geoID = 1252634;
		if(strcmp($countrycode, "BO") == 0) $geoID = 3923057;
		if(strcmp($countrycode, "BQ") == 0) $geoID = 7626844;
		if(strcmp($countrycode, "BA") == 0) $geoID = 3277605;
		if(strcmp($countrycode, "BW") == 0) $geoID = 933860;
		if(strcmp($countrycode, "BV") == 0) $geoID = 3371123;
		if(strcmp($countrycode, "BR") == 0) $geoID = 3469034;
		if(strcmp($countrycode, "IO") == 0) $geoID = 1282588;
		if(strcmp($countrycode, "BN") == 0) $geoID = 1820814;
		if(strcmp($countrycode, "BG") == 0) $geoID = 732800;
		if(strcmp($countrycode, "BF") == 0) $geoID = 2361809;
		if(strcmp($countrycode, "BI") == 0) $geoID = 433561;
		if(strcmp($countrycode, "KH") == 0) $geoID = 1831722;
		if(strcmp($countrycode, "CM") == 0) $geoID = 2233387;
		if(strcmp($countrycode, "CA") == 0) $geoID = 6251999;
		if(strcmp($countrycode, "CV") == 0) $geoID = 3374766;
		if(strcmp($countrycode, "KY") == 0) $geoID = 3580718;
		if(strcmp($countrycode, "CF") == 0) $geoID = 239880;
		if(strcmp($countrycode, "TD") == 0) $geoID = 2434508;
		if(strcmp($countrycode, "CL") == 0) $geoID = 3895114;
		if(strcmp($countrycode, "CN") == 0) $geoID = 1814991;
		if(strcmp($countrycode, "CX") == 0) $geoID = 2078138;
		if(strcmp($countrycode, "CC") == 0) $geoID = 1547376;
		if(strcmp($countrycode, "CO") == 0) $geoID = 3686110;
		if(strcmp($countrycode, "KM") == 0) $geoID = 921929;
		if(strcmp($countrycode, "CD") == 0) $geoID = 203312;
		if(strcmp($countrycode, "CG") == 0) $geoID = 2260494;
		if(strcmp($countrycode, "CK") == 0) $geoID = 1899402;
		if(strcmp($countrycode, "CR") == 0) $geoID = 3624060;
		if(strcmp($countrycode, "CI") == 0) $geoID = 2287781;
		if(strcmp($countrycode, "HR") == 0) $geoID = 3202326;
		if(strcmp($countrycode, "CU") == 0) $geoID = 3562981;
		if(strcmp($countrycode, "CW") == 0) $geoID = 7626836;
		if(strcmp($countrycode, "CY") == 0) $geoID = 146669;
		if(strcmp($countrycode, "CZ") == 0) $geoID = 3077311;
		if(strcmp($countrycode, "DK") == 0) $geoID = 2623032;
		if(strcmp($countrycode, "DJ") == 0) $geoID = 223816;
		if(strcmp($countrycode, "DM") == 0) $geoID = 3575830;
		if(strcmp($countrycode, "DO") == 0) $geoID = 3508796;
		if(strcmp($countrycode, "EC") == 0) $geoID = 3658394;
		if(strcmp($countrycode, "EG") == 0) $geoID = 357994;
		if(strcmp($countrycode, "SV") == 0) $geoID = 3585968;
		if(strcmp($countrycode, "GQ") == 0) $geoID = 2309096;
		if(strcmp($countrycode, "ER") == 0) $geoID = 338010;
		if(strcmp($countrycode, "EE") == 0) $geoID = 453733;
		if(strcmp($countrycode, "ET") == 0) $geoID = 337996;
		if(strcmp($countrycode, "FK") == 0) $geoID = 3474414;
		if(strcmp($countrycode, "FO") == 0) $geoID = 2622320;
		if(strcmp($countrycode, "FJ") == 0) $geoID = 2205218;
		if(strcmp($countrycode, "FI") == 0) $geoID = 660013;
		if(strcmp($countrycode, "FR") == 0) $geoID = 3017382;
		if(strcmp($countrycode, "GF") == 0) $geoID = 3381670;
		if(strcmp($countrycode, "PF") == 0) $geoID = 4030656;
		if(strcmp($countrycode, "TF") == 0) $geoID = 1546748;
		if(strcmp($countrycode, "GA") == 0) $geoID = 2400553;
		if(strcmp($countrycode, "GM") == 0) $geoID = 2413451;
		if(strcmp($countrycode, "GE") == 0) $geoID = 614540;
		if(strcmp($countrycode, "DE") == 0) $geoID = 2921044;
		if(strcmp($countrycode, "GH") == 0) $geoID = 2300660;
		if(strcmp($countrycode, "GI") == 0) $geoID = 2411586;
		if(strcmp($countrycode, "GR") == 0) $geoID = 390903;
		if(strcmp($countrycode, "GL") == 0) $geoID = 3425505;
		if(strcmp($countrycode, "GD") == 0) $geoID = 3580239;
		if(strcmp($countrycode, "GP") == 0) $geoID = 3579143;
		if(strcmp($countrycode, "GU") == 0) $geoID = 4043988;
		if(strcmp($countrycode, "GT") == 0) $geoID = 3595528;
		if(strcmp($countrycode, "GG") == 0) $geoID = 3042362;
		if(strcmp($countrycode, "GW") == 0) $geoID = 2372248;
		if(strcmp($countrycode, "GN") == 0) $geoID = 2420477;
		if(strcmp($countrycode, "GY") == 0) $geoID = 3378535;
		if(strcmp($countrycode, "HT") == 0) $geoID = 3723988;
		if(strcmp($countrycode, "HM") == 0) $geoID = 1547314;
		if(strcmp($countrycode, "VA") == 0) $geoID = 3164670;
		if(strcmp($countrycode, "HN") == 0) $geoID = 3608932;
		if(strcmp($countrycode, "HK") == 0) $geoID = 1819730;
		if(strcmp($countrycode, "HU") == 0) $geoID = 719819;
		if(strcmp($countrycode, "IS") == 0) $geoID = 2629691;
		if(strcmp($countrycode, "IN") == 0) $geoID = 1269750;
		if(strcmp($countrycode, "ID") == 0) $geoID = 1643084;
		if(strcmp($countrycode, "IR") == 0) $geoID = 130758;
		if(strcmp($countrycode, "IQ") == 0) $geoID = 99237;
		if(strcmp($countrycode, "IE") == 0) $geoID = 2963597;
		if(strcmp($countrycode, "IM") == 0) $geoID = 3042225;
		if(strcmp($countrycode, "IL") == 0) $geoID = 294640;
		if(strcmp($countrycode, "IT") == 0) $geoID = 3175395;
		if(strcmp($countrycode, "CI") == 0) $geoID = 2287781;
		if(strcmp($countrycode, "JM") == 0) $geoID = 3489940;
		if(strcmp($countrycode, "JP") == 0) $geoID = 1861060;
		if(strcmp($countrycode, "JE") == 0) $geoID = 3042142;
		if(strcmp($countrycode, "JO") == 0) $geoID = 248816;
		if(strcmp($countrycode, "KZ") == 0) $geoID = 1522867;
		if(strcmp($countrycode, "KE") == 0) $geoID = 192950;
		if(strcmp($countrycode, "KI") == 0) $geoID = 4030945;
		if(strcmp($countrycode, "KP") == 0) $geoID = 1873107;
		if(strcmp($countrycode, "KR") == 0) $geoID = 1835841;
		if(strcmp($countrycode, "XK") == 0) $geoID = 831053;
		if(strcmp($countrycode, "KW") == 0) $geoID = 285570;
		if(strcmp($countrycode, "KG") == 0) $geoID = 1527747;
		if(strcmp($countrycode, "LA") == 0) $geoID = 1655842;
		if(strcmp($countrycode, "LV") == 0) $geoID = 458258;
		if(strcmp($countrycode, "LB") == 0) $geoID = 272103;
		if(strcmp($countrycode, "LS") == 0) $geoID = 932692;
		if(strcmp($countrycode, "LR") == 0) $geoID = 2275384;
		if(strcmp($countrycode, "LY") == 0) $geoID = 2215636;
		if(strcmp($countrycode, "LI") == 0) $geoID = 3042058;
		if(strcmp($countrycode, "LT") == 0) $geoID = 597427;
		if(strcmp($countrycode, "LU") == 0) $geoID = 2960313;
		if(strcmp($countrycode, "MO") == 0) $geoID = 1821275;
		if(strcmp($countrycode, "MK") == 0) $geoID = 718075;
		if(strcmp($countrycode, "MG") == 0) $geoID = 1062947;
		if(strcmp($countrycode, "MW") == 0) $geoID = 927384;
		if(strcmp($countrycode, "MY") == 0) $geoID = 1733045;
		if(strcmp($countrycode, "MV") == 0) $geoID = 1282028;
		if(strcmp($countrycode, "ML") == 0) $geoID = 2453866;
		if(strcmp($countrycode, "MT") == 0) $geoID = 2562770;
		if(strcmp($countrycode, "MH") == 0) $geoID = 2080185;
		if(strcmp($countrycode, "MQ") == 0) $geoID = 3570311;
		if(strcmp($countrycode, "MR") == 0) $geoID = 2378080;
		if(strcmp($countrycode, "MU") == 0) $geoID = 934292;
		if(strcmp($countrycode, "YT") == 0) $geoID = 1024031;
		if(strcmp($countrycode, "MX") == 0) $geoID = 3996063;
		if(strcmp($countrycode, "FM") == 0) $geoID = 2081918;
		if(strcmp($countrycode, "MD") == 0) $geoID = 617790;
		if(strcmp($countrycode, "MC") == 0) $geoID = 2993457;
		if(strcmp($countrycode, "MN") == 0) $geoID = 2029969;
		if(strcmp($countrycode, "ME") == 0) $geoID = 3194884;
		if(strcmp($countrycode, "MS") == 0) $geoID = 3578097;
		if(strcmp($countrycode, "MA") == 0) $geoID = 2542007;
		if(strcmp($countrycode, "MZ") == 0) $geoID = 1036973;
		if(strcmp($countrycode, "MM") == 0) $geoID = 1327865;
		if(strcmp($countrycode, "NA") == 0) $geoID = 3355338;
		if(strcmp($countrycode, "NR") == 0) $geoID = 2110425;
		if(strcmp($countrycode, "NP") == 0) $geoID = 1282988;
		if(strcmp($countrycode, "AN") == 0) $geoID = 2750405;
		if(strcmp($countrycode, "NL") == 0) $geoID = 2750405;
		if(strcmp($countrycode, "NC") == 0) $geoID = 2139685;
		if(strcmp($countrycode, "NZ") == 0) $geoID = 2186224;
		if(strcmp($countrycode, "NI") == 0) $geoID = 3617476;
		if(strcmp($countrycode, "NE") == 0) $geoID = 2440476;
		if(strcmp($countrycode, "NG") == 0) $geoID = 2328926;
		if(strcmp($countrycode, "NU") == 0) $geoID = 4036232;
		if(strcmp($countrycode, "NF") == 0) $geoID = 2155115;
		if(strcmp($countrycode, "MP") == 0) $geoID = 4041468;
		if(strcmp($countrycode, "NO") == 0) $geoID = 3144096;
		if(strcmp($countrycode, "OM") == 0) $geoID = 286963;
		if(strcmp($countrycode, "PK") == 0) $geoID = 1168579;
		if(strcmp($countrycode, "PW") == 0) $geoID = 1559582;
		if(strcmp($countrycode, "PS") == 0) $geoID = 6254930;
		if(strcmp($countrycode, "PA") == 0) $geoID = 3703430;
		if(strcmp($countrycode, "PG") == 0) $geoID = 2088628;
		if(strcmp($countrycode, "PY") == 0) $geoID = 3437598;
		if(strcmp($countrycode, "PE") == 0) $geoID = 3932488;
		if(strcmp($countrycode, "PH") == 0) $geoID = 1694008;
		if(strcmp($countrycode, "PN") == 0) $geoID = 4030699;
		if(strcmp($countrycode, "PL") == 0) $geoID = 798544;
		if(strcmp($countrycode, "PT") == 0) $geoID = 2264397;
		if(strcmp($countrycode, "PR") == 0) $geoID = 4566966;
		if(strcmp($countrycode, "QA") == 0) $geoID = 289688;
		if(strcmp($countrycode, "RE") == 0) $geoID = 935317;
		if(strcmp($countrycode, "RO") == 0) $geoID = 798549;
		if(strcmp($countrycode, "RU") == 0) $geoID = 2017370;
		if(strcmp($countrycode, "RW") == 0) $geoID = 49518;
		if(strcmp($countrycode, "BL") == 0) $geoID = 3578476;
		if(strcmp($countrycode, "SH") == 0) $geoID = 3370751;
		if(strcmp($countrycode, "KN") == 0) $geoID = 3575174;
		if(strcmp($countrycode, "LC") == 0) $geoID = 3576468;
		if(strcmp($countrycode, "MF") == 0) $geoID = 3578421;
		if(strcmp($countrycode, "PM") == 0) $geoID = 3424932;
		if(strcmp($countrycode, "VC") == 0) $geoID = 3577815;
		if(strcmp($countrycode, "WS") == 0) $geoID = 4034894;
		if(strcmp($countrycode, "SM") == 0) $geoID = 3168068;
		if(strcmp($countrycode, "ST") == 0) $geoID = 2410758;
		if(strcmp($countrycode, "SA") == 0) $geoID = 102358;
		if(strcmp($countrycode, "SN") == 0) $geoID = 2245662;
		if(strcmp($countrycode, "RS") == 0) $geoID = 6290252;
		if(strcmp($countrycode, "SC") == 0) $geoID = 241170;
		if(strcmp($countrycode, "SL") == 0) $geoID = 2403846;
		if(strcmp($countrycode, "SG") == 0) $geoID = 1880251;
		if(strcmp($countrycode, "SX") == 0) $geoID = 7609695;
		if(strcmp($countrycode, "SK") == 0) $geoID = 3057568;
		if(strcmp($countrycode, "SI") == 0) $geoID = 3190538;
		if(strcmp($countrycode, "SB") == 0) $geoID = 2103350;
		if(strcmp($countrycode, "SO") == 0) $geoID = 51537;
		if(strcmp($countrycode, "ZA") == 0) $geoID = 953987;
		if(strcmp($countrycode, "GS") == 0) $geoID = 3474415;
		if(strcmp($countrycode, "SS") == 0) $geoID = 7909807;
		if(strcmp($countrycode, "ES") == 0) $geoID = 2510769;
		if(strcmp($countrycode, "LK") == 0) $geoID = 1227603;
		if(strcmp($countrycode, "SD") == 0) $geoID = 366755;
		if(strcmp($countrycode, "SR") == 0) $geoID = 3382998;
		if(strcmp($countrycode, "SJ") == 0) $geoID = 607072;
		if(strcmp($countrycode, "SZ") == 0) $geoID = 934841;
		if(strcmp($countrycode, "SE") == 0) $geoID = 2661886;
		if(strcmp($countrycode, "CH") == 0) $geoID = 2658434;
		if(strcmp($countrycode, "SY") == 0) $geoID = 163843;
		if(strcmp($countrycode, "TW") == 0) $geoID = 1668284;
		if(strcmp($countrycode, "TJ") == 0) $geoID = 1220409;
		if(strcmp($countrycode, "TZ") == 0) $geoID = 149590;
		if(strcmp($countrycode, "TH") == 0) $geoID = 1605651;
		if(strcmp($countrycode, "TL") == 0) $geoID = 1966436;
		if(strcmp($countrycode, "TG") == 0) $geoID = 2363686;
		if(strcmp($countrycode, "TK") == 0) $geoID = 4031074;
		if(strcmp($countrycode, "TO") == 0) $geoID = 4032283;
		if(strcmp($countrycode, "TT") == 0) $geoID = 3573591;
		if(strcmp($countrycode, "TN") == 0) $geoID = 2464461;
		if(strcmp($countrycode, "TR") == 0) $geoID = 298795;
		if(strcmp($countrycode, "TM") == 0) $geoID = 1218197;
		if(strcmp($countrycode, "TC") == 0) $geoID = 3576916;
		if(strcmp($countrycode, "TV") == 0) $geoID = 2110297;
		if(strcmp($countrycode, "UG") == 0) $geoID = 226074;
		if(strcmp($countrycode, "UA") == 0) $geoID = 690791;
		if(strcmp($countrycode, "AE") == 0) $geoID = 290557;
		if(strcmp($countrycode, "GB") == 0) $geoID = 2635167;
		if(strcmp($countrycode, "UM") == 0) $geoID = 5854968;
		if(strcmp($countrycode, "US") == 0) $geoID = 6252001;
		if(strcmp($countrycode, "UY") == 0) $geoID = 3439705;
		if(strcmp($countrycode, "UZ") == 0) $geoID = 1512440;
		if(strcmp($countrycode, "VU") == 0) $geoID = 2134431;
		if(strcmp($countrycode, "VE") == 0) $geoID = 3625428;
		if(strcmp($countrycode, "VN") == 0) $geoID = 1562822;
		if(strcmp($countrycode, "VG") == 0) $geoID = 3577718;
		if(strcmp($countrycode, "VI") == 0) $geoID = 4796775;
		if(strcmp($countrycode, "WF") == 0) $geoID = 4034749;
		if(strcmp($countrycode, "EH") == 0) $geoID = 2461445;
		if(strcmp($countrycode, "YE") == 0) $geoID = 69543;
		if(strcmp($countrycode, "ZM") == 0) $geoID = 895949;
		if(strcmp($countrycode, "ZW") == 0) $geoID = 878675;
    
    	return $geoID;
    }

	
	echo "ip_from, ip_to, geoname_id<br />";
    
	foreach($CheckPointsCODE as $CP) 
	{ 
		list($ipfrom, $ipto, $countrycode, $nome) = explode(",", $CP);
        
        $countrycode = str_replace(array('"'), '',$countrycode);
        
        $geoID = GetIDFromCountryCode($countrycode);
		echo "$ipfrom, $ipto, $geoID"; 
        echo "<br />";

	}
    
  
    

    
	

    
  	/*foreach($CheckPointsCODE as $CP) 
	{ 
		//list($ipfrom, $ipto, $countrycode, $nome, $aa, $bb) = explode(",", $CP);
		echo "if(strcmp(ktmurt, $CP)) kvmmm = ;"; 
        echo "<br />";

	}*/


?> 
  </body> 
</html> 
<?php 
    } 
    else 
    { 
?> 
<html> 
  <head> 
    <title>GEOIP LITE</title> 
  </head> 
  <body> 
    <form name="pcode" id="pcode" method="post" action="<?=htmlentities($_SERVER['REQUEST_URI']);?>"> 
      <textarea id="code" name="code" cols="50" rows="20"></textarea><br /><br /> 
      <input type="submit" value="Genera" /> <input type="reset">
    </form> 
  </body> 
</html> 
<?php 
    } 
?>