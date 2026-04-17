<?php
// index.php
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>网站聊天助手</title>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, "Microsoft YaHei", sans-serif;
            background: #f5f7fb;
            color: #222;
        }

        .container {
            max-width: 900px;
            margin: 40px auto;
            padding: 20px;
        }

        .chat-wrapper {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
            overflow: hidden;
        }

        .chat-header {
            padding: 18px 20px;
            border-bottom: 1px solid #eee;
            background: #ffffff;
        }

        .chat-header h1 {
            margin: 0;
            font-size: 22px;
        }

        .chat-header p {
            margin: 8px 0 0;
            color: #666;
            font-size: 14px;
        }

        .chat-box {
            height: 500px;
            overflow-y: auto;
            padding: 20px;
            background: #fafbfc;
        }

        .message {
            max-width: 80%;
            margin-bottom: 14px;
            padding: 12px 14px;
            border-radius: 12px;
            line-height: 1.7;
            white-space: pre-wrap;
            word-break: break-word;
        }

        .message.user {
            margin-left: auto;
            background: #dbeafe;
        }

        .message.bot {
            margin-right: auto;
            background: #ececec;
        }

        .chat-input-area {
            border-top: 1px solid #eee;
            padding: 16px;
            background: #fff;
        }

        .chat-form {
            display: flex;
            gap: 12px;
        }

        .chat-form textarea {
            flex: 1;
            resize: none;
            height: 90px;
            border: 1px solid #dcdcdc;
            border-radius: 10px;
            padding: 12px;
            font-size: 14px;
            outline: none;
        }

        .chat-form textarea:focus {
            border-color: #999;
        }

        .chat-form button {
            width: 120px;
            border: none;
            border-radius: 10px;
            background: #111827;
            color: #fff;
            font-size: 15px;
            cursor: pointer;
        }

        .chat-form button:hover {
            opacity: 0.92;
        }

        .chat-form button:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }

        .tips {
            margin-top: 10px;
            font-size: 12px;
            color: #777;
        }

        @media (max-width: 768px) {
            .container {
                margin: 0;
                padding: 0;
            }

            .chat-wrapper {
                border-radius: 0;
                min-height: 100vh;
            }

            .chat-box {
                height: calc(100vh - 220px);
            }

            .chat-form {
                flex-direction: column;
            }

            .chat-form button {
                width: 100%;
                height: 44px;
            }

            .message {
                max-width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="chat-wrapper">
            <div class="chat-header">
                <h1>网站开发助手</h1>
                <p>仅回答IT开发的相关问题。</p>
            </div>

            <div id="chatBox" class="chat-box">
                <div class="message bot">请输入你的问题。</div>
            </div>

            <div class="chat-input-area">
                <form id="chatForm" class="chat-form">
                    <textarea id="messageInput" placeholder="InputSomething？"></textarea>
                    <button type="submit" id="sendBtn">发送</button>
                </form>
                <div class="tips">仅支持简短的问题，自己去改config.php。</div>
            </div>
        </div>
    </div>

    <script>
        const chatForm = document.getElementById('chatForm');
        const messageInput = document.getElementById('messageInput');
        const chatBox = document.getElementById('chatBox');
        const sendBtn = document.getElementById('sendBtn');

        function escapeHtml(text) {
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }

        function addMessage(role, text) {
            const div = document.createElement('div');
            div.className = 'message ' + role;
            div.innerHTML = escapeHtml(text);
            chatBox.appendChild(div);
            chatBox.scrollTop = chatBox.scrollHeight;
            return div;
        }

        chatForm.addEventListener('submit', async function (e) {
            e.preventDefault();

            const message = messageInput.value.trim();
            if (!message) return;

            addMessage('user', message);
            messageInput.value = '';
            sendBtn.disabled = true;

            const loadingMessage = addMessage('bot', '思考中...');

            try {
                const response = await fetch('chat.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ message: message })
                });

                const data = await response.json();

                loadingMessage.innerHTML = escapeHtml(data.reply || '没有返回内容');
            } catch (error) {
                loadingMessage.innerHTML = '请求失败，请检查环境。';
            }

            sendBtn.disabled = false;
            chatBox.scrollTop = chatBox.scrollHeight;
        });

        messageInput.addEventListener('keydown', function (e) {
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
                chatForm.dispatchEvent(new Event('submit'));
            }
        });
    </script>
</body>
</html>