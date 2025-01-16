<!-- <meta http-equiv="refresh" content="0 ; URL=/works/web/16.html"> -->

<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/templates/redirectHead.php');
// 読み込むファイルパスを指定 (ディレクトリ内のファイル名が数字のみの場合)
// ファイル名が空の場合は、最新のファイル名を取得
$redirectFile = new RedirectHead(directoryPath: './[0-9]*.html', redirectFileName: '');
$redirectFile->render();
