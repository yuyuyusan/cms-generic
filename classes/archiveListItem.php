<?php
class ArchiveListItem {
  // パスと表示件数を受け取るコンストラクタ
  public function __construct(
    // パスを格納するプロパティ
    private string $directoryPath,
    // 表示件数を格納するプロパティ
    private int $itemCount,
    // 取得するタイトルのidを格納するプロパティ
    private $titleIdName = 'singleTitle'
  ) {
    $this->directoryPath = $directoryPath;
    $this->itemCount = $itemCount;
  }

  public function render() {
    // ディレクトリ内のファイルを取得
    $dir = glob($this->directoryPath);
    // ファイル名の降順に並び替え
    $dir = array_reverse($dir);
    foreach ($dir as $key => $value) {
      // ファイル名から日付を取得
      $getDateName = mb_substr($value, -15, 10);
      // ファイル名の形式が、yyyy-mm-ddでない場合は例外をスロー
      if (preg_match('/\d{4}\-\d{2}\-\d{2}/', $getDateName) == 0) {
        throw new Exception($getDateName . 'は「yyyy-mm-dd」形式ではないファイル名です');
      }
      // ハイフンをドットに変換
      $changeDateName = str_replace('-', '.', $getDateName);
      // DOMDocumentクラスのインスタンスを生成
      $doc = new DOMDocument();
      // エラーハンドリングを有効にする
      libxml_use_internal_errors(true);
      // HTMLファイルを読み込む
      $doc->loadHTMLFile($value);
      // マークアップのエラーを無効にする
      libxml_clear_errors();
      // id=singleTitleの要素を取得
      $titleElement = $doc->getElementById($this->titleIdName);
      // idが見つからない場合は例外をスロー
      if ($titleElement === null) {
        throw new Exception($getDateName . '.htmlに' . $this->titleIdName . ' idが見つかりません');
      }
      // ノードのテキストを取得
      $titleInnerText = htmlspecialchars($titleElement->textContent, ENT_QUOTES, 'UTF-8');

      echo <<<HTML
      <div class="newsListBox">
        <a href="$value">
          <dl>
            <dt>$changeDateName</dt>
            <dd>$titleInnerText</dd>
          </dl>
        </a>
      </div>
      HTML;

      if ($key === $this->itemCount - 1) {
        break;
      }
    }
  }
}

