<?php
$baseDir = '/home/seqepi/ftp/zapisywacz/hdd/';
function str2url($str, $strtolower = true, $spaceReplacement = ' ') {
    $str = iconv('UTF-8', 'ASCII//TRANSLIT', $str);

    $charsArr = array('^', "'", '"', '`', '~');
    $str = str_replace($charsArr, '', $str);

    $str = ($strtolower ? strtolower($str) : $str);

    $return = trim(preg_replace('# +#', ' ', preg_replace('/[^a-zA-Z0-9\s]/', '', $str)));

    $return = preg_replace('/\s/', $spaceReplacement, $return);
    return $return;
}

function getMainCatalogId($dbh) {
    $sql = "SELECT `id` FROM `elfinder_file` WHERE `name`='NOWE!'";
    $query = $dbh->prepare($sql);
    $query->execute();
    $result = $query->fetchColumn();
    return $result;
}

function createMainCatalog($baseDir) {
    mkdir($baseDir.'NOWE');
}

function checkMainCatalog($baseDir) {    
    if (!file_exists($baseDir.'NOWE'))
    {        
        createMainCatalog($baseDir);
    }    
    return $baseDir.'NOWE'.DIRECTORY_SEPARATOR;
}

function saveImage($mainCatalog, $title, $url) {    
    $file = file_get_contents($url);    
    $filename = basename($url);
    file_put_contents($mainCatalog.$filename, $file);
}

function saveText($mainCatalog, $title, $data) {
    $filename = str2url($title).'.txt';
    file_put_contents($mainCatalog.$filename, $data);
}

function saveUrl($mainCatalog, $title, $url) {
    $file = '<meta http-equiv="refresh" content="0; url='.$url.'" />';
    $filename = str2url($title).'.html';
    file_put_contents($mainCatalog.$filename, $file);    
}

$mainCatalog = checkMainCatalog($baseDir);

if (isset($_POST['type']))
{
    switch($_POST['type']){
        case 0: saveUrl($mainCatalog, $_POST['title'], $_POST['data']); break;
        case 1: saveImage($mainCatalog, $_POST['title'], $_POST['data']); break;
        case 2: saveText($mainCatalog, $_POST['title'], $_POST['data']); break;
    }
    echo json_encode(array('result' => true));
}