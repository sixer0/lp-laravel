
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat Nailla — Sixer0</title>
    <meta name="robots" content="noindex, nofollow">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <style>
        *, *::before, *::after { box-sizing: border-box; }

        body {
            margin: 0; padding: 0;
            min-height: 100vh;
            display: flex; flex-direction: column;
            background: #f0f4f8;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        }

        /* ── TOP BAR ── */
        .topbar {
            background: linear-gradient(135deg, #162828, #1e3a3a);
            color: rgba(255,255,255,.7);
            padding: .55rem 1.25rem;
            font-size: .8rem;
            letter-spacing: .6px;
            text-transform: uppercase;
            flex-shrink: 0;
        }
        .topbar a { color: #d4a843; text-decoration: none; }
        .topbar a:hover { text-decoration: underline; }

        /* ── CHAT AREA ── */
        .chat-page {
            flex: 1;
            display: flex;
            flex-direction: column;
            max-width: 820px;
            width: 100%;
            margin: 0 auto;
            height: calc(100vh - 42px);   /* ← full available viewport */
        }

        .chat-header {
            background: #162828;
            color: #fff;
            padding: 1rem 1.4rem;
            border-radius: 14px 14px 0 0;
            display: flex;
            align-items: center;
            gap: .9rem;
            flex-shrink: 0;
        }

        .avatar {
            width: 42px; height: 42px;
            border-radius: 50%;
            background: linear-gradient(135deg, #d4a843, #b8922e);
            display: flex; align-items: center; justify-content: center;
            font-size: 1.3rem; flex-shrink: 0;
        }

        .chat-info h5 { margin: 0; font-size: 1rem; color: #fff; font-weight: 700; }
        .chat-info p  { margin: 0; font-size: .78rem; color: rgba(255,255,255,.55); }

        .status-dot {
            width: 8px; height: 8px; border-radius: 50%;
            background: #22c55e;
            display: inline-block;
            animation: pulse 2s infinite;
        }
        @keyframes pulse { 0%,100%{opacity:1;transform:scale(1)} 50%{opacity:.5;transform:scale(.85)} }

        /* ── MESSAGES ── */
        .chat-messages {
            flex: 1;
            overflow-y: auto;
            padding: 1.4rem;
            background: #fff;
            display: flex;
            flex-direction: column;
            gap: .75rem;
            min-height: 300px;
        }

        .msg { max-width: 78%; display: flex; flex-direction: column; animation: fadeIn .25s ease; }
        @keyframes fadeIn { from{opacity:0;transform:translateY(8px)} to{opacity:1;transform:none} }

        .msg--bot  { align-self: flex-start; }
        .msg--user { align-self: flex-end; }

        .bubble {
            padding: .7rem 1rem;
            border-radius: 16px;
            font-size: .9rem;
            line-height: 1.55;
            word-break: break-word;
        }
        .msg--bot  .bubble { background: #f1f5f9; color: #1e293b; border-bottom-left-radius: 4px; }
        .msg--user .bubble { background: #162828; color: #fff;       border-bottom-right-radius: 4px; }

        .msg-time {
            font-size: .68rem; color: #94a3b8; margin-top: .2rem;
            padding: 0 .25rem;
        }
        .msg--user .msg-time { text-align: right; }

        .typing { color: #94a3b8; font-size: .82rem; font-style: italic; padding: 0 .25rem; }

        /* ── INPUT ── */
        .chat-input-wrap {
            background: #fff;
            border: 1px solid #e2e8f0;
            border-top: none;
            padding: .75rem 1rem;
            border-radius: 0 0 14px 14px;
            display: flex;
            gap: .6rem;
            align-items: center;
            flex-shrink: 0;
        }

        .chat-input {
            flex: 1;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            padding: .6rem 1rem;
            font-size: .9rem;
            outline: none;
            transition: border-color .2s;
        }
        .chat-input:focus { border-color: #d4a843; }

        .btn-send {
            background: #d4a843; color: #162828;
            border: none; border-radius: 10px;
            padding: .6rem 1.3rem; font-weight: 600;
            font-size: .88rem;
            cursor: pointer;
            transition: background .2s, transform .1s;
            white-space: nowrap;
        }
        .btn-send:hover  { background: #b8922e; }
        .btn-send:active { transform: scale(.96); }
        .btn-send:disabled { opacity: .5; cursor: not-allowed; }

        /* ── FOOTER CREDIT ── */
        .chat-footer {
            text-align: center;
            padding: .5rem;
            font-size: .73rem;
            color: #94a3b8;
            flex-shrink: 0;
        }
        .chat-footer a { color: #d4a843; text-decoration: none; }

        @media(max-width:576px) {
            .chat-page { height: calc(100vh - 38px); }
        }
    </style>
</head>
<body>

    <!-- TOP BAR -->
    <div class="topbar">
        <i class="bi bi-shield-check me-1"></i> Sixer0 &nbsp;|&nbsp;
        <a href="/">Kembali ke Beranda</a>
    </div>

    <!-- CHAT -->
    <div class="chat-page">
        <div class="chat-header">
            <div class="avatar"><i class="bi bi-chat-dots"></i></div>
            <div class="chat-info">
                <h5>Nailla</h5>
                <p><span class="status-dot"></span>&nbsp;Aktif</p>
            </div>
        </div>

        <div class="chat-messages" id="chat-messages">
            <div class="msg msg--bot">
                <div class="bubble">
                    Halo! Saya <strong>Nailla</strong> dari tim Pak Budi &amp; Budi. 😊
                    Ada yang bisa saya bantu hari ini? Anda mau ngobrol tentang layanan Sixer0, nggak?
                </div>
                <div class="msg-time">Baru saja</div>
            </div>
        </div>

        <div class="chat-input-wrap">
            <input
                type="text"
                id="chat-input"
                class="chat-input"
                placeholder="Ketik pesan…"
                autocomplete="off"
            >
            <button class="btn-send" id="btn-send">
                <i class="bi bi-send me-1"></i>Kirim
            </button>
        </div>

        <div class="chat-footer">
            <i class="bi bi-shield-check me-1"></i> Powered by Sixer0 &nbsp;·&nbsp;
            <a href="/">Beranda</a> &nbsp;·&nbsp;
            <a href="/privacy">Privasi</a>
        </div>
    </div>

    <!-- ── Widget script (same endpoint as homepage widget) ──────────────────── -->
    <script src="/public/js/chat-widget.js"></script>

    <!-- ── Override widget config: auto-trigger OFF, open immediately ─────────── -->
    <script>
    (function(){
        // Override Nailla widget config for this dedicated page
        if (typeof NaillaChat === 'undefined') return;

        NaillaChat.CONFIG = Object.assign({},
            NaillaChat.CONFIG || {},
            {
                position:     'right',
                primaryColor: '#d4a843',
                title:        'Nailla',
                subtitle:     'Tim Pak Budi Kusharyanto',
                // Auto-trigger OFF on this page — user is already in chat
                autoTrigger:  { enabled: false },
            }
        );

        // Open chat immediately so user never sees just the button
        setTimeout(function() {
            var btn = document.querySelector('.nailla-launcher');
            if (btn) btn.click();
        }, 150);
    })();
    </script>

</body>
</html>
<?php /**PATH /home/sixq7133/public_html/landing.sixer0-bk.my.id/resources/views/chat.blade.php ENDPATH**/ ?>