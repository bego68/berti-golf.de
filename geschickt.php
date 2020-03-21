<html><head><title>Berti-Golf</title>

<link rel="STYLESHEET" type="text/css" href="css/style.css">
<script language="JavaScript1.2" type="text/javascript" src="hoover.js"></script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"></head>
<body onload="imgPreload()" leftmargin="0" topmargin="0" alink="#ff9900" bgcolor="#476c8b" link="#ffffff" marginheight="0" marginwidth="0" text="#ffffff" vlink="#ffffff">

<?
  $subst_Verband = $_POST[subst_Verband];
 $subst_Anrede = $_POST[subst_Anrede];
 $subst_Name = $_POST[subst_Name];
 $subst_Vorname = $_POST[subst_Vorname];
 $subst_Titel = $_POST[subst_Titel];
 $subst_Position = $_POST[subst_Position];
 $subst_Strasse = $_POST[subst_Strasse];
 $subst_PLZ = $_POST[subst_PLZ];
 $subst_Telefon = $_POST[subst_Telefon];
 $subst_Mobil = $_POST[subst_Mobil];
 $subst_Fax = $_POST[subst_Fax];
 $subst_Email = $_POST[subst_Email];
 $subst_Web = $_POST[subst_Web];
 $subst_Anfrage = $_POST[subst_Anfrage];
 $subst_Anrufen = $_POST[subst_Anrufen];

 $subject="Anfrage von www.berti-golf.de";
 
 $emailtext='  
  <h1>Anfrage von www.berti-golf.de</h1>
  
   <p> <b><br />'.$subst_Verband.'</b><br />
	'.$subst_Anrede.' '.$subst_Titel.' '.$subst_Vorname.' '.$subst_Name.'  <br /> 
	'.$subst_Position.'<br />
	'.$subst_PLZ.'<br />
	'.$subst_Email.'<br />
	Telefon: '.$subst_Telefon.' <br />Mobil: '.$subst_Mobil.'<br />
	Fax:'.$subst_Fax.' <br />WWW: '.$subst_Web.'<br /><br />
	'.$subst_Anfrage.'<br /><br />
	Anrufen:'.$subst_Anrufen.' <br /><br />
   </p>';
   

	//echo $emailtext;

     $headers  = "MIME-Version: 1.0\r\n";
     $headers .= "Content-type: text/html; charset=iso-8859-1\r\n";

     /* zusätzliche Header */
      $headers .= "To: Berti Golf <info@golf-net.de>\r\n";
      $headers .= "From: www.berti-golf.de <mail@berti-golf.de>\r\n\r\n";
      
     
   /* Verschicken der Mail */
    mail($to, $subject, $emailtext, $headers);
 ?>

<table border="0" cellpadding="0" cellspacing="0" width="100%">
  <tbody><tr><td><img src="images/1x1_trans.gif" alt="" border="0" height="20" width="2"></td>
  </tr>
  <tr><td align="center" valign="top">
          <table border="0" cellpadding="0" cellspacing="0" width="644">
            <tbody><tr valign="top">
<!-- LOGO -->
                <td><a href="index.html"><img src="images/logo.gif" alt="" border="0" height="31" width="254"></a></td>
                <td><img src="images/1x1_trans.gif" alt="" border="0" height="56" width="1"><br><img src="images/1x1_trans.gif" alt="" border="0" height="1" width="15"></td>
                <td><img src="images/1x1_trans.gif" alt="" border="0" height="1" width="1"></td>
                <td><img src="images/1x1_trans.gif" alt="" border="0" height="1" width="8"></td>
<!-- HAUPTNAVIGATION -->                
                <td><table border="0" cellpadding="0" cellspacing="0">
                      <tbody><tr><td align="right">
                              <table border="0" cellpadding="0" cellspacing="0">
                                <tbody><tr><td><a href="kontakt.html"><img name="roll_menu_kontakt" src="images/menu_kontakt-a.gif" alt="" border="0" height="11" width="75"></a></td>
                                                                      
                          </tr>
                              </tbody></table></td>      
                      </tr>
                      <tr><td><img src="images/1x1_trans.gif" alt="" border="0" height="4" width="1"></td>
                      </tr>
                      <tr><td bgcolor="#ffffff"><img src="images/1x1_trans.gif" alt="" border="0" height="1" width="1"></td>
                      </tr>
                      <tr><td><img src="images/1x1_trans.gif" alt="" border="0" height="4" width="1"></td>
                      </tr>
                      <tr><td><table border="0" cellpadding="0" cellspacing="0">
                                <tbody><tr><td><a href="referenz.html" onmouseover="imgHi('menu_referenzen')" onmouseout="imgLo('menu_referenzen')">
                                        <img name="roll_menu_referenzen" src="images/menu_referenzen.gif" alt="" border="0" height="11" width="97"></a></td>
                                    <td><img src="images/1x1_trans.gif" alt="" border="0" height="1" width="23"></td>
				    <td><a href="leistung.html" onmouseover="imgHi('menu_leistungen')" onmouseout="imgLo('menu_leistungen')">
                                        <img name="roll_menu_leistungen" src="images/menu_leistungen.gif" alt="" border="0" height="11" width="99"></a></td>
                                    <td><img src="images/1x1_trans.gif" alt="" border="0" height="1" width="21"></td>
				    <td><a href="partner.html" onmouseover="imgHi('menu_team_partner')" onmouseout="imgLo('menu_team_partner')">
                                        <img name="roll_menu_team_partner" src="images/menu_team_partner.gif" alt="" border="0" height="11" width="125"></a></td>
                                </tr>
                              </tbody></table></td>
                      </tr>
                    </tbody></table></td>
            </tr>
            <tr valign="top">
<!-- SUBNAVIGATION -->                
                <td><table border="0" cellpadding="0" cellspacing="0">
                      <tbody><tr><td><img src="images/1x1_trans.gif" alt="" border="0" height="1" width="253"><br><img src="images/1x1_trans.gif" alt="" border="0" height="2" width="1"></td></tr>
                      <tr><td align="right">&nbsp;</td></tr>
                      <tr><td><img src="images/1x1_trans.gif" alt="" border="0" height="14" width="1"></td></tr>
                    </tbody></table></td>
<!-- ABSTANDHALTER und WEISSE LINIE SENKRECHT -->
                <td>&nbsp;</td>
                <td bgcolor="#ffffff"><img src="images/1x1_476c8b.gif" alt="" border="0" height="5" width="1"></td>
                <td>&nbsp;</td>
                <td>

<!-- BEGINN CONTENT -->
                <table border="0" cellpadding="0" cellspacing="0">
                      <tbody><tr><td class="header">KONTAKT</td>
                      </tr>
                      <tr><td><img src="images/1x1_trans.gif" alt="" border="0" height="7" width="1"></td>
                      </tr>
                      <tr><td class="textnormal">


<p>Unsere Anschrift:</p>
<p>
<table border="0" cellpadding="0" cellspacing="1">
  <tbody><tr><td class="textnormal" align="right" valign="top">&nbsp;</td><td class="textnormal" valign="top">&nbsp;</td><td class="textnormal">Hubertus Golf<br>Waldeslust 11<br>81377 München</td></tr>
  <tr><td class="textnormal" align="right">Tel.</td><td class="textnormal"> : </td><td class="textnormal">+49 173  514 95 68</td></tr>
  <tr><td class="textnormal" align="right">Fax.</td><td class="textnormal"> : </td><td class="textnormal">+49 9415 99 21 43 68</td></tr>
  <tr><td class="textnormal" align="right">Email</td><td class="textnormal"> : </td><td class="textnormal"><a href="mailto:berti@golf-net.de">berti@golf-net.de</a></td></tr>
  <tr><td class="textnormal" align="right">WWW</td><td class="textnormal"> : </td><td class="textnormal"><a href="/" target="_new">www.berti-golf.de</a></td></tr>
</tbody></table>
</p>  
<p>Vielen dank f&uuml;r das Senden der Nachricht. Wir bem&uuml;hen uns die Nachricht m&ouml;glichst schnell zu beantworten!</p>
<p>&nbsp;</p>

                        </td>
                      </tr>
                    </tbody></table>
<!-- ENDE CONTENT -->

            </td></tr>
<!-- ABSTAND ZU SUBNAVIGATION UND CONTENT -->
            <tr><td>&nbsp;</td>
                <td>&nbsp;</td>
                <td bgcolor="#ffffff"><img src="images/1x1_trans.gif" alt="" border="0" height="20" width="1"></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr valign="bottom">
<!-- COPYRIGHT -->
                <td class="copyright" align="right">© 2001-2005 by Berti Golf</td>
                <td>&nbsp;</td>
                <td bgcolor="#ffffff"><img src="images/1x1_476c8b.gif" alt="" border="0" height="1" width="1"></td>
                <td>&nbsp;</td>
<!-- METANAVIGATION -->
                <td><table border="0" cellpadding="0" cellspacing="0">
                      <tbody><tr valign="bottom">
				      <td><a href="referenz.html" class="metanav">REFERENZEN</a></td>
                          <td class="metanav2">&nbsp;|&nbsp;</td>
                          <td><a href="leistung.html" class="metanav">LEISTUNGEN</a></td>
                          <td class="metanav2">&nbsp;|&nbsp;</td>
                          <td><a href="partner.html" class="metanav">TEAM&nbsp;/&nbsp;PARTNER</a></td>
                          <td class="metanav2">&nbsp;|&nbsp;</td>
                          <td><a href="kontakt.html" class="metanavhigh">KONTAKT</a></td>
                          <td class="metanav2">&nbsp;|&nbsp;</td>
                          
                      </tr>
                    </tbody></table></td>  
            </tr>
            </tbody></table></td>
  </tr>
</tbody></table>
&nbsp;<br>
</body></html>
