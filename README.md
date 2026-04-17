<!-- Banner -->
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
