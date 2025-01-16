<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>

<body>
  <main>
    <section>
      <h1>トップページ</h1>
    </section>
    <section>
      <ul class="newsList">
        <?php
        // NewsListクラスのインスタンスを生成し、ディレクトリと表示件数を引数に渡す
        require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/newsListItem.php';
        $newsList = new ArchiveListItem(directoryPath: './news/[0-9]*.html', itemCount: 3);
        $newsList->render();
        ?>
      </ul>
    </section>
  </main>
</body>

</html>