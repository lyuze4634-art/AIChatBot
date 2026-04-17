<!-- Banner -->
フロントエンドは POST リクエストで chat.php に送信し、サーバー側が OpenAI API を呼び出して回答を生成し、その結果をページに返して表示します。
index.php：フロント側のチャット画面で、質問の入力と回答の表示を担当します。
chat.php：バックエンド側のインターフェースで、質問を受け取り、OpenAI API を呼び出し、結果を返します。
config.php：設定ファイルで、API Key、モデル名、ロボットの設定を保存します。

コアとなる流れ
ユーザーがページ上で質問を入力する
フロントエンドが chat.php にリクエストを送信する
chat.php が入力内容を確認し、OpenAI API を呼び出す
AI が SYSTEM_PROMPT に基づいて回答を生成する
サーバーが JSON データを返し、ページに結果を表示する

前端通过 POST 请求发送到 chat.php，服务器调用 OpenAI API 生成回答，再把结果返回给网页显示。
index.php：前端聊天界面，负责输入问题和显示回答
chat.php：后端接口，接收问题、调用 OpenAI API、返回结果
config.php：配置文件，存放 API Key、模型名称和机器人设定

核心流程
用户在网页输入问题
前端发送请求到 chat.php
chat.php 检查输入并调用 OpenAI API
AI 根据 SYSTEM_PROMPT 生成回答
服务器返回 JSON 数据，网页显示结果
