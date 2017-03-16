/**
 * čeština translation
 * @author Jay Gridley <gridley.jay@hotmail.com>
 * @author Karel Píč <Pic.k@seznam.cz>
 * @version 2016-04-13
 */

if (elFinder && elFinder.prototype && typeof(elFinder.prototype.i18) == 'object') {
	elFinder.prototype.i18.cs = {
		translator : 'Jay Gridley &lt;gridley.jay@hotmail.com&gt;, Karel Píč &lt;Pic.k@seznam.cz&gt;',
		language   : 'čeština',
		direction  : 'ltr',
		dateFormat : 'd. m. Y H:i', // Mar 13, 2012 05:27 PM
		fancyDateFormat : '$1 H:i', // will produce smth like: Today 12:25 PM
		messages   : {

			/********************************** errors **********************************/
			'error'                : 'Chyba',
			'errUnknown'           : 'Neznámá chyba.',
			'errUnknownCmd'        : 'Neznámý příkaz.',
			'errJqui'              : 'Nedostačující konfigurace jQuery UI. Musí být zahrnuty komponenty Selectable, Draggable a Droppable.',
			'errNode'              : 'elFinder vyžaduje vytvořený DOM Element.',
			'errURL'               : 'Chybná konfigurace elFinderu! Není nastavena hodnota URL.',
			'errAccess'            : 'Přístup zamítnut.',
			'errConnect'           : 'Nepodařilo se připojit k backendu (konektoru).',
			'errAbort'             : 'Připojení zrušeno.',
			'errTimeout'           : 'Vypšel limit pro připojení.',
			'errNotFound'          : 'Backend nenalezen.',
			'errResponse'          : 'Nesprávná odpověď backendu.',
			'errConf'              : 'Nepsrávná konfigurace backendu.',
			'errJSON'              : 'PHP modul JSON není nainstalován.',
			'errNoVolumes'         : 'Není dostupný čitelný oddíl.',
			'errCmdParams'         : 'Nesprávné parametry příkazu "$1".',
			'errDataNotJSON'       : 'Data nejsou ve formátu JSON.',
			'errDataEmpty'         : 'Data jsou prázdná.',
			'errCmdReq'            : 'Dotaz backendu vyžaduje název příkazu.',
			'errOpen'              : 'Chyba při otevírání "$1".',
			'errNotFolder'         : 'Objekt není složka.',
			'errNotFile'           : 'Objekt není soubor.',
			'errRead'              : 'Chyba při čtení "$1".',
			'errWrite'             : 'Chyba při zápisu do "$1".',
			'errPerm'              : 'Přístup odepřen.',
			'errLocked'            : '"$1" je uzamčený a nemůže být přejmenován, přesunut nebo smazán.',
			'errExists'            : 'Soubor s názvem "$1" již existuje.',
			'errInvName'           : 'Nesprávný název souboru.',
			'errFolderNotFound'    : 'Složka nenalezena.',
			'errFileNotFound'      : 'Soubor nenalezen.',
			'errTrgFolderNotFound' : 'Cílová složka "$1" nenalezena.',
			'errPopup'             : 'Prohlížeč zabránil otevření vyskakovacího okna. K otevření souboru, povolte vyskakovací okno v prohlížeči.',
			'errMkdir'             : 'Nepodařilo se vytvořit složku "$1".',
			'errMkfile'            : 'Nepodařilo se vytvořit soubor "$1".',
			'errRename'            : 'Nepodařilo se přejmenovat "$1".',
			'errCopyFrom'          : 'Kopírování souborů z oddílu "$1" není povoleno.',
			'errCopyTo'            : 'Kopírování souborů do oddílu "$1" není povoleno.',
			'errMkOutLink'         : 'Nelze vytvořit odkaz mimo kořenový svazek.', // from v2.1 added 03.10.2015
			'errUpload'            : 'Chyba nahrávání.',  // old name - errUploadCommon
			'errUploadFile'        : 'Nepodařilo se nahrát "$1".', // old name - errUpload
			'errUploadNoFiles'     : 'Nejsou vybrány žádné soubory k nahrání.',
			'errUploadTotalSize'   : 'Překročena maximální povolená velikost dat.', // old name - errMaxSize
			'errUploadFileSize'    : 'Překročena maximální povolená velikost souboru.', //  old name - errFileMaxSize
			'errUploadMime'        : 'Nepovolený typ souboru.',
			'errUploadTransfer'    : '"$1" chyba přenosu.',
			'errUploadTemp'        : 'Nelze vytvořit dočasný soubor pro nahrávání.', // from v2.1 added 26.09.2015
			'errNotReplace'        : 'Položka "$1" na tomto místě již existuje a nemůže být nahrazena položkou s jiným datovým typem.', // new
			'errReplace'           : '"$1" nelze nahradit.',
			'errSave'              : '"$1" nelze uložit.',
			'errCopy'              : '"$1" nelze zkopírovat.',
			'errMove'              : '"$1" nelze přemístit.',
			'errCopyInItself'      : '"$1" nelze zkopírovat do sebe sama.',
			'errRm'                : '"$1" nelze odstranit.',
			'errRmSrc'             : 'Nelze odstranit zdrojové soubor(y).',
			'errExtract'           : 'Nelze extrahovat soubory z "$1".',
			'errArchive'           : 'Nelze vytvořit archív.',
			'errArcType'           : 'Nepodporovaný typ archívu.',
			'errNoArchive'         : 'Soubor není archív nebo má nepodporovaný formát.',
			'errCmdNoSupport'      : 'Backend tento příkaz nepodporuje.',
			'errReplByChild'       : 'Složka "$1" nemůže být nahrazena souborem, který sama obsahuje.',
			'errArcSymlinks'       : 'Z bezpečnostních důvodů je zakázáno rozbalit archívy obsahující symlinky.', // edited 24.06.2012
			'errArcMaxSize'        : 'Soubory archívu překračují maximální povolenou velikost.',
			'errResize'            : 'Nepodařilo se změnit velikost obrázku "$1".',
			'errResizeDegree'      : 'Neplatné stupně otočení.',  // added 7.3.2013
			'errResizeRotate'      : 'Nelze otočit obraz.',  // added 7.3.2013
			'errResizeSize'        : 'Neplatná velikost obrazu.',  // added 7.3.2013
			'errResizeNoChange'    : 'Velikost obrazu nebude změněna.',  // added 7.3.2013
			'errUsupportType'      : 'Nepodporovaný typ souboru.',
			'errNotUTF8Content'    : 'Soubor "$1" není v UTF-8 a nemůže být upraven.',  // added 9.11.2011
			'errNetMount'          : '"$1" nelze připojit.', // added 17.04.2012
			'errNetMountNoDriver'  : 'Nepodporovaný protokol.',     // added 17.04.2012
			'errNetMountFailed'    : 'Nepodařilo se připojit.',         // added 17.04.2012
			'errNetMountHostReq'   : 'Používaný Host.', // added 18.04.2012
			'errSessionExpires'    : 'Relace vypršela z důvodu nečinnosti.',
			'errCreatingTempDir'   : 'Nelze vytvořit dočasný adresář: "$1"',
			'errFtpDownloadFile'   : 'Nelze stáhnout soubor z FTP: "$1"',
			'errFtpUploadFile'     : 'Nelze nahrát soubor na FTP: "$1"',
			'errFtpMkdir'          : 'Nelze vytvořit vzdálený adresář na FTP: "$1"',
			'errArchiveExec'       : 'Chyba při archivaci souborů: "$1"',
			'errExtractExec'       : 'Chyba při extrahování souborů: "$1"',
			'errNetUnMount'        : 'Nepodařilo se odpojit', // from v2.1 added 30.04.2012
			'errConvUTF8'          : 'Neprovedla se konverze na UTF-8', // from v2.1 added 08.04.2014
			'errFolderUpload'      : 'Vyzkoušejte Google Chrome, pokud chcete nahrát složku.', // from v2.1 added 26.6.2015
			'errSearchTimeout'     : 'Vypršel čas při hledání "$1". Výsledek vyhledávání je pouze částečný.', // from v2.1 added 12.1.2016
			'errReauthRequire'     : 'Je nutné se znovu přihlásit.', // from v2.1.10 added 3.24.2016

			/******************************* commands names ********************************/
			'cmdarchive'   : 'Vytvořit archív',
			'cmdback'      : 'Zpět',
			'cmdcopy'      : 'Kopírovat',
			'cmdcut'       : 'Vyjmout',
			'cmddownload'  : 'Stáhnout',
			'cmdduplicate' : 'Duplikovat',
			'cmdedit'      : 'Upravit soubor',
			'cmdextract'   : 'Rozbalit archív',
			'cmdforward'   : 'Vpřed',
			'cmdgetfile'   : 'Vybrat soubory',
			'cmdhelp'      : 'O softwaru',
			'cmdhome'      : 'Domů',
			'cmdinfo'      : 'Zobrazit informace',
			'cmdmkdir'     : 'Nová složka',
			'cmdmkdirin'   : 'Do nové složky', // from v2.1.7 added 19.2.2016
			'cmdmkfile'    : 'Nový textový soubor',
			'cmdopen'      : 'Otevřít',
			'cmdpaste'     : 'Vložit',
			'cmdquicklook' : 'Náhled',
			'cmdreload'    : 'Obnovit',
			'cmdrename'    : 'Přejmenovat',
			'cmdrm'        : 'Smazat',
			'cmdsearch'    : 'Najít soubory',
			'cmdup'        : 'Přejít do nadřazené složky',
			'cmdupload'    : 'Nahrát soubor(y)',
			'cmdview'      : 'Zobrazit',
			'cmdresize'    : 'Změnit velikost',
			'cmdsort'      : 'Seřadit',
			'cmdnetmount'  : 'Připojit síťovou jednotku', // added 18.04.2012
			'cmdnetunmount': 'Odpojit', // from v2.1 added 30.04.2012
			'cmdplaces'    : 'Pozice', // added 28.12.2014
			'cmdchmod'     : 'Změna módu', // from v2.1 added 20.6.2015
			'cmdopendir'   : 'Otevřít složku', // from v2.1 added 13.1.2016

			/*********************************** buttons ***********************************/
			'btnClose'  : 'Zavřít',
			'btnSave'   : 'Uložit',
			'btnRm'     : 'Odstranit',
			'btnApply'  : 'Použít',
			'btnCancel' : 'Zrušit',
			'btnNo'     : 'Ne',
			'btnYes'    : 'Ano',
			'btnMount'  : 'Připojit',  // added 18.04.2012
			'btnApprove': 'Přejít na $1 a schválit', // from v2.1 added 26.04.2012
			'btnUnmount': 'Odpojit', // from v2.1 added 30.04.2012
			'btnConv'   : 'Konvertovat', // from v2.1 added 08.04.2014
			'btnCwd'    : 'Zde',      // from v2.1 added 22.5.2015
			'btnVolume' : 'Jednotka',    // from v2.1 added 22.5.2015
			'btnAll'    : 'Všechno',       // from v2.1 added 22.5.2015
			'btnMime'   : 'MIME Typ', // from v2.1 added 22.5.2015
			'btnFileName':'Název souboru',  // from v2.1 added 22.5.2015
			'btnSaveClose': 'Uložit a zavřít', // from v2.1 added 12.6.2015
			'btnBackup' : 'Zálohovat', // fromv2.1 added 28.11.2015

			/******************************** notifications ********************************/
			'ntfopen'     : 'Otevírání složky',
			'ntffile'     : 'Otevírání souboru',
			'ntfreload'   : 'Obnovování obsahu složky',
			'ntfmkdir'    : 'Vytváření složky',
			'ntfmkfile'   : 'Vytváření souborů',
			'ntfrm'       : 'Mazání souborů',
			'ntfcopy'     : 'Kopírování souborů',
			'ntfmove'     : 'Přesunování souborů',
			'ntfprepare'  : 'Příprava ke kopírování souborů',
			'ntfrename'   : 'Přejmenovávání souborů',
			'ntfupload'   : 'Nahrávání souborů',
			'ntfdownload' : 'Stahování souborů',
			'ntfsave'     : 'Ukládání souborů',
			'ntfarchive'  : 'Vytváření archívu',
			'ntfextract'  : 'Rozbalování souborů z archívu',
			'ntfsearch'   : 'Vyhledávání souborů',
			'ntfresize'   : 'Změna velikosti obrázku',
			'ntfsmth'     : 'Čekejte prosím...',
			'ntfloadimg'  : 'Načítání obrázků',
			'ntfnetmount' : 'Připojit síťovou jednotku', // added 18.04.2012
			'ntfnetunmount': 'Odpojit síťovou jednotku', // from v2.1 added 30.04.2012
			'ntfdim'      : 'Získávání rozměrů obrazu', // added 20.05.2013
			'ntfreaddir'  : 'Čtení informací složky', // from v2.1 added 01.07.2013
			'ntfurl'      : 'Získávání URL odkazu', // from v2.1 added 11.03.2014
			'ntfchmod'    : 'Změna módu souboru', // from v2.1 added 20.6.2015
			'ntfpreupload': 'Ověřování nahrání názvu souboru', // from v2.1 added 31.11.2015
			'ntfzipdl'    : 'Vytváření souboru pro stažení', // from v2.1.7 added 23.1.2016

			/************************************ dates **********************************/
			'dateUnknown' : 'neznámý',
			'Today'       : 'Dnes',
			'Yesterday'   : 'Včera',
			'msJan'       : 'Led',
			'msFeb'       : 'Úno',
			'msMar'       : 'Bře',
			'msApr'       : 'Dub',
			'msMay'       : 'Kvě',
			'msJun'       : 'Čer',
			'msJul'       : 'Čec',
			'msAug'       : 'Srp',
			'msSep'       : 'Zář',
			'msOct'       : 'Říj',
			'msNov'       : 'Lis',
			'msDec'       : 'Pro',
			'January'     : 'Leden',
			'February'    : 'Únor',
			'March'       : 'Březen',
			'April'       : 'Duben',
			'May'         : 'Květen',
			'June'        : 'Červen',
			'July'        : 'Červenec',
			'August'      : 'Srpen',
			'September'   : 'Září',
			'October'     : 'Říjen',
			'November'    : 'Listopad',
			'December'    : 'Prosinec',
			'Sunday'      : 'Neděle',
			'Monday'      : 'Pondělí',
			'Tuesday'     : 'Úterý',
			'Wednesday'   : 'Středa',
			'Thursday'    : 'Čtvrtek',
			'Friday'      : 'Pátek',
			'Saturday'    : 'Sobota',
			'Sun'         : 'Ne',
			'Mon'         : 'Po',
			'Tue'         : 'Út',
			'Wed'         : 'St',
			'Thu'         : 'Čt',
			'Fri'         : 'Pá',
			'Sat'         : 'So',

			/******************************** sort variants ********************************/
			'sortname'          : 'dle jména',
			'sortkind'          : 'dle typu',
			'sortsize'          : 'dle velikosti',
			'sortdate'          : 'dle data',
			'sortFoldersFirst'  : 'Napřed složky',

			/********************************** new items **********************************/
			'untitled file.txt' : 'Novy soubor.txt', // added 10.11.2015
			'untitled folder'   : 'Nova slozka',   // added 10.11.2015
			'Archive'           : 'Nový archiv',  // from v2.1 added 10.11.2015

			/********************************** messages **********************************/
			'confirmReq'      : 'Požadováno potvrzení',
			'confirmRm'       : 'Opravdu chcete odstranit tyto soubory?<br/>Operace nelze vrátit!',
			'confirmRepl'     : 'Nahradit staré soubory novými?',
			'confirmConvUTF8' : 'Toto není v UTF-8<br/>Chcete převést do UTF-8?<br/>Obsah bude převeden po uložení na UTF-8.', // from v2.1 added 08.04.2014
			'confirmNotSave'  : 'Byly provedeny změny.<br/>Práce bude ztracena, pokud neprovedete uložení.', // from v2.1 added 15.7.2015
			'apllyAll'        : 'Pro všechny',
			'name'            : 'Název',
			'size'            : 'Velikost',
			'perms'           : 'Práva',
			'modify'          : 'Upravený',
			'kind'            : 'Typ',
			'read'            : 'čtení',
			'write'           : 'zápis',
			'noaccess'        : 'přístup odepřen',
			'and'             : 'a',
			'unknown'         : 'neznámý',
			'selectall'       : 'Vybrat všechny soubory',
			'selectfiles'     : 'Vybrat soubor(y)',
			'selectffile'     : 'Vybrat první soubor',
			'selectlfile'     : 'Vybrat poslední soubor',
			'viewlist'        : 'Seznam',
			'viewicons'       : 'Ikony',
			'places'          : 'Místa',
			'calc'            : 'Vypočítat',
			'path'            : 'Cesta',
			'aliasfor'        : 'Zástupce pro',
			'locked'          : 'Uzamčený',
			'dim'             : 'Rozměry',
			'files'           : 'Soubory',
			'folders'         : 'Složky',
			'items'           : 'Položky',
			'yes'             : 'ano',
			'no'              : 'ne',
			'link'            : 'Odkaz',
			'searcresult'     : 'Výsledky hledání',
			'selected'        : 'vybrané položky',
			'about'           : 'O softwaru',
			'shortcuts'       : 'Zkratky',
			'help'            : 'Nápověda',
			'webfm'           : 'Webový správce souborů',
			'ver'             : 'Verze',
			'protocolver'     : 'verze protokolu',
			'homepage'        : 'Domovská stránka projektu',
			'docs'            : 'Dokumentace',
			'github'          : 'Podpořte nás na Github',
			'twitter'         : 'Follow us on Twitter',
			'facebook'        : 'Join us on Facebook',
			'team'            : 'Tým',
			'chiefdev'        : 'séf vývojářů',
			'developer'       : 'vývojár',
			'contributor'     : 'spolupracovník',
			'maintainer'      : 'údržba',
			'translator'      : 'překlad',
			'icons'           : 'Ikony',
			'dontforget'      : 'a nezapomeňte si vzít plavky',
			'shortcutsof'     : 'Zkratky nejsou povoleny',
			'dropFiles'       : 'Sem přetáhněte soubory',
			'or'              : 'nebo',
			'selectForUpload' : 'Vyberte soubory',
			'moveFiles'       : 'Přesunout sobory',
			'copyFiles'       : 'Zkopírovat soubory',
			'rmFromPlaces'    : 'Odstranit z míst',
			'aspectRatio'     : 'Poměr stran',
			'scale'           : 'Měřítko',
			'width'           : 'Šířka',
			'height'          : 'Výška',
			'resize'          : 'Změnit vel.',
			'crop'            : 'Ořezat',
			'rotate'          : 'Otočit',
			'rotate-cw'       : 'Otočit o +90 stupňů',
			'rotate-ccw'      : 'Otočit o -90 stupňů',
			'degree'          : ' stupňů',
			'netMountDialogTitle' : 'Připojit síťovou jednotku', // added 18.04.2012
			'protocol'            : 'Protokol', // added 18.04.2012
			'host'                : 'Host', // added 18.04.2012
			'port'                : 'Port', // added 18.04.2012
			'user'                : 'Uživatel', // added 18.04.2012
			'pass'                : 'Heslo', // added 18.04.2012
			'confirmUnmount'      : 'Chcete odpojit $1?',  // from v2.1 added 30.04.2012
			'dropFilesBrowser': 'Přetáhněte nebo vložte soubory z prohlížeče', // from v2.1 added 30.05.2012
			'dropPasteFiles'  : 'Přetáhněte nebo vložte soubory a odkazy sem', // from v2.1 added 07.04.2014
			'encoding'        : 'Kódování', // from v2.1 added 19.12.2014
			'locale'          : 'Lokace',   // from v2.1 added 19.12.2014
			'searchTarget'    : 'Cíl: $1',                // from v2.1 added 22.5.2015
			'searchMime'      : 'Hledání podle vstupního MIME typu', // from v2.1 added 22.5.2015
			'owner'           : 'Majitel', // from v2.1 added 20.6.2015
			'group'           : 'Skupina', // from v2.1 added 20.6.2015
			'other'           : 'Ostatní', // from v2.1 added 20.6.2015
			'execute'         : 'Vykonat', // from v2.1 added 20.6.2015
			'perm'            : 'Povolení', // from v2.1 added 20.6.2015
			'mode'            : 'Mód', // from v2.1 added 20.6.2015
			'emptyFolder'     : 'Složka je prázdná', // from v2.1.6 added 30.12.2015
			'emptyFolderDrop' : 'Složka je prázdná\\A Přetažením přidáte položky', // from v2.1.6 added 30.12.2015
			'emptyFolderLTap' : 'Složka je prázdná\\A Podržením přidáte položky', // from v2.1.6 added 30.12.2015
			'quality'         : 'Kvalita', // from v2.1.6 added 5.1.2016
			'autoSync'        : 'Automatická synchronizace',  // from v2.1.6 added 10.1.2016
			'moveUp'          : 'Jít nahoru',  // from v2.1.6 added 18.1.2016
			'getLink'         : 'Získat URL adresu', // from v2.1.7 added 9.2.2016
			'selectedItems'   : 'Označeno položek ($1)', // from v2.1.7 added 2.19.2016
			'folderId'        : 'ID složky', // from v2.1.10 added 3.25.2016
			'offlineAccess'   : 'Povolit přistup offline', // from v2.1.10 added 3.25.2016
			'reAuth'          : 'Chcete-li znovu potvrdit', // from v2.1.10 added 3.25.2016

			/********************************** mimetypes **********************************/
			'kindUnknown'     : 'Neznámý',
			'kindFolder'      : 'Složka',
			'kindAlias'       : 'Odkaz',
			'kindAliasBroken' : 'Neplatný odkaz',
			// applications
			'kindApp'         : 'Aplikace',
			'kindPostscript'  : 'Dokument Postscriptu',
			'kindMsOffice'    : 'Dokument Microsoft Office',
			'kindMsWord'      : 'Dokument Microsoft Word',
			'kindMsExcel'     : 'Dokument Microsoft Excel',
			'kindMsPP'        : 'Prezentace Microsoft Powerpoint',
			'kindOO'          : 'Otevřít dokument Office',
			'kindAppFlash'    : 'Flash aplikace',
			'kindPDF'         : 'PDF',
			'kindTorrent'     : 'Soubor BitTorrent',
			'kind7z'          : 'Archív 7z',
			'kindTAR'         : 'Archív TAR',
			'kindGZIP'        : 'Archív GZIP',
			'kindBZIP'        : 'Archív BZIP',
			'kindXZ'          : 'Archív XZ',
			'kindZIP'         : 'Archív ZIP',
			'kindRAR'         : 'Archív RAR',
			'kindJAR'         : 'Soubor Java JAR',
			'kindTTF'         : 'True Type font',
			'kindOTF'         : 'Open Type font',
			'kindRPM'         : 'RPM balíček',
			// texts
			'kindText'        : 'Textový dokument',
			'kindTextPlain'   : 'Čistý text',
			'kindPHP'         : 'PHP zdrojový kód',
			'kindCSS'         : 'Kaskádové styly',
			'kindHTML'        : 'HTML dokument',
			'kindJS'          : 'Javascript zdrojový kód',
			'kindRTF'         : 'Rich Text Format',
			'kindC'           : 'C zdrojový kód',
			'kindCHeader'     : 'C hlavička',
			'kindCPP'         : 'C++ zdrojový kód',
			'kindCPPHeader'   : 'C++ hlavička',
			'kindShell'       : 'Unix shell skript',
			'kindPython'      : 'Python zdrojový kód',
			'kindJava'        : 'Java zdrojový kód',
			'kindRuby'        : 'Ruby zdrojový kód',
			'kindPerl'        : 'Perl skript',
			'kindSQL'         : 'SQL zdrojový kód',
			'kindXML'         : 'Dokument XML',
			'kindAWK'         : 'AWK zdrojový kód',
			'kindCSV'         : 'CSV',
			'kindDOCBOOK'     : 'Docbook XML dokument',
			'kindMarkdown'    : 'Označený text', // added 20.7.2015
			// images
			'kindImage'       : 'Obrázek',
			'kindBMP'         : 'Obrázek BMP',
			'kindJPEG'        : 'Obrázek JPEG',
			'kindGIF'         : 'Obrázek GIF',
			'kindPNG'         : 'Obrázek PNG',
			'kindTIFF'        : 'Obrázek TIFF',
			'kindTGA'         : 'Obrázek TGA',
			'kindPSD'         : 'Obrázek Adobe Photoshop',
			'kindXBITMAP'     : 'Obrázek X bitmapa',
			'kindPXM'         : 'Obrázek Pixelmator',
			// media
			'kindAudio'       : 'Audio sobory',
			'kindAudioMPEG'   : 'MPEG audio',
			'kindAudioMPEG4'  : 'MPEG-4 audio',
			'kindAudioMIDI'   : 'MIDI audio',
			'kindAudioOGG'    : 'Ogg Vorbis audio',
			'kindAudioWAV'    : 'WAV audio',
			'AudioPlaylist'   : 'MP3 playlist',
			'kindVideo'       : 'Video sobory',
			'kindVideoDV'     : 'DV video',
			'kindVideoMPEG'   : 'MPEG video',
			'kindVideoMPEG4'  : 'MPEG-4 video',
			'kindVideoAVI'    : 'AVI video',
			'kindVideoMOV'    : 'Quick Time video',
			'kindVideoWM'     : 'Windows Media video',
			'kindVideoFlash'  : 'Flash video',
			'kindVideoMKV'    : 'Matroska video',
			'kindVideoOGG'    : 'Ogg video'
		}
	};
}

