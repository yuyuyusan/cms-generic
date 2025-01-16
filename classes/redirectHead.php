<?php
class RedirectHead {
  // パスとデフォルト値を最新のファイルに設定するコンストラクタ
  public function __construct(
    // 読み込むディレクトリパスを格納するプロパティ
    private string $directoryPath,
    // リダイレクトするファイル名を格納するプロパティ
    private string $redirectFileName
  ) {
    $this->directoryPath = $directoryPath;
    // 別のメソッドでファイル名を設定
    $this->setFileName($redirectFileName);
  }

  // ファイル名を設定するメソッド
  public function setFileName($redirectFileName) {
    // 引数が空の場合は、最新のファイル名を取得
    if ($redirectFileName === '') {
      $this->redirectFileName = $this->getFileName() . '.html';
    } else {
      $this->redirectFileName = $redirectFileName . '.html';
    }
  }
  // 最新のファイル名を取得するメソッド
  public function getFileName() {
    // ディレクトリ内のファイルを取得
    $dirArray = glob($this->directoryPath);
    // 取得した配列の文字列の「./」を削除
    $dirArrayFileName = str_replace('./', '', $dirArray);

    // .htmlの後ろの数字を取得して、文字列から数字に変換し配列に格納
    $IntFileName = array_map(function ($value) {
      return (int) substr($value, 0, -5);
    }, $dirArrayFileName);

    // ファイル名を降順に並び替え
    rsort($IntFileName);

    // 1桁の数字はゼロパディングをして、2桁にする
    $IntFileName = array_map(function ($value) {
      return sprintf('%02d', $value);
    }, $IntFileName);

    // .htmlの後ろの数字が3桁以上の場合は例外をスロー
    if (preg_match('/\d{3,}/', $IntFileName[0]) === 1) {
      var_dump($IntFileName);
      throw new Exception($IntFileName[0] . '.htmlはファイル名が3桁以上の数字です');
    }

    // ファイル名を返す
    return $IntFileName[0];
  }
  public function render() {
    echo <<<HTML
    <meta http-equiv="refresh" content="0 ; URL=$this->redirectFileName">
    HTML;
  }
}

