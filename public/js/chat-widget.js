/**
 * Nailla Chat Widget for Sixer0 Portfolio
 * Embed script for website integration
 * v4 — fixed SMTP, fixed window overwrite bug, clean idle detection
 */

(function() {
  'use strict';

  // ── CONFIG ────────────────────────────────────────────────────────────────
  const CONFIG = Object.freeze({
    agentId:  'nailla-cs',
    apiEndpoint: 'https://i-5dc40be347644e148c0516b639489d89.kiloclaw.ai/hooks/nailla-chat',
    hookToken:  'e19b60abed93b837d055dd15c3cada8ef529d42c4533c6d321145322bff61221',
    position:   'right',
    primaryColor: '#2563eb',
    title:      'Nailla',
    subtitle:   'Tim Pak Budi Kusharyanto',
    // Greeting is dynamic — computed at DOMContentLoaded based on time of day
    // Edit getGreeting() below to customise the opening line

    // Auto-trigger: idle/scroll → popup + silent pre-prompt
    autoTrigger: Object.freeze({
      enabled:   true,
      ms:        45000,
      onlyOnce:  true,
      sessionKey: 'hook:auto-nailla-',
      prePrompt: 'ada pengunjung di websitenya budi kusharyanto. Owner Email: sixer0.bk@gmail.com — CC ke sixer0.bk@live.com',
    }),
  });

  // ── ELEMENT REFS ──────────────────────────────────────────────────────────
  let _win, _btn, _input, _send, _msgs, _typing;
  let _idleTimer   = null;
  let _lastActive  = Date.now();
  let _triggered   = false;

  // ── BUILD DOM ─────────────────────────────────────────────────────────────
  // Time-of-day greeting — edit here
  // h 06-11 = pagi  |  12-17 = siang  |  18-21 = sore  |  22-05 = malam
  function getGreeting() {
    const h = new Date().getHours();
    let time;  // used inside the return statement below
    if (h >= 6 && h < 12)   time = 'pagi';
    else if (h >= 12 && h < 18) time = 'siang';
    else if (h >= 18 && h < 22) time = 'sore';
    else                    time = 'malam';
    return `Selamat ${time}! Saya <strong>Nailla</strong> dari tim Pak <strong>Budi Kusharyanto</strong>. Ada yang bisa saya bantu hari ini?`;
  }

  function build() {
    const wrap = document.createElement('div');
    wrap.id = 'nailla-chat-widget';
    wrap.innerHTML = `
      <style>
        #nailla-chat-widget { position:fixed; bottom:20px; right:20px; z-index:10000; font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,sans-serif; }
        .nailla-launcher {
          background:${CONFIG.primaryColor}; color:#fff; border:none; border-radius:50px;
          padding:14px 22px; cursor:pointer; box-shadow:0 4px 16px rgba(0,0,0,.2);
          display:flex; align-items:center; gap:8px; font-size:14px; font-weight:500;
          transition:transform .15s,box-shadow .2s;
        }
        .nailla-launcher:hover { transform:translateY(-2px); box-shadow:0 6px 22px rgba(0,0,0,.28); }
        .nailla-launcher:active { transform:scale(.97); }
        .nailla-window {
          position:absolute; bottom:72px; right:0; width:370px; height:490px;
          background:#fff; border-radius:14px; box-shadow:0 8px 40px rgba(0,0,0,.18);
          display:none; flex-direction:column; overflow:hidden;
        }
        .nailla-window.open { display:flex; }
        .nailla-header { background:${CONFIG.primaryColor}; color:#fff; padding:15px 18px; flex-shrink:0; }
        .nailla-header h3 { margin:0 0 3px; font-size:15px; }
        .nailla-header p  { margin:0; font-size:12px; opacity:.85; }
        .nailla-body { flex:1; padding:16px; overflow-y:auto; display:flex; flex-direction:column; gap:10px; }
        .nailla-msg { max-width:82%; padding:10px 14px; border-radius:12px; font-size:13.5px; line-height:1.45; word-break:break-word; }
        .nailla-msg.bot  { background:#f1f5f9; align-self:flex-start; border-bottom-left-radius:3px; }
        .nailla-msg.user { background:${CONFIG.primaryColor}; color:#fff; align-self:flex-end; border-bottom-right-radius:3px; }
        .nailla-typing { display:none; padding:6px 14px; background:#f1f5f9; border-radius:10px; align-self:flex-start; font-size:12px; color:#6b7280; }
        .nailla-footer { border-top:1px solid #e5e7eb; padding:10px 12px; display:flex; gap:8px; flex-shrink:0; }
        .nailla-footer input { flex:1; padding:9px 13px; border:1px solid #d1d5db; border-radius:18px; font-size:13px; outline:none; }
        .nailla-footer input:focus { border-color:${CONFIG.primaryColor}; }
        .nailla-footer button { background:${CONFIG.primaryColor}; color:#fff; border:none; border-radius:18px; padding:0 16px; font-size:13px; cursor:pointer; }
        .nailla-footer button:disabled { opacity:.5; cursor:not-allowed; }
      </style>

      <button class="nailla-launcher" id="naillaLauncher" aria-label="Chat dengan Nailla">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
        </svg>
        <span id="naillaLabel">Chat Nailla</span>
      </button>

      <div class="nailla-window" id="naillaWindow" role="dialog" aria-label="Chat Nailla">
        <div class="nailla-header">
          <h3>${CONFIG.title}</h3>
          <p>${CONFIG.subtitle}</p>
        </div>
        <div class="nailla-body" id="naillaBody">
          <div class="nailla-msg bot" id="greetingMsg"></div>
        </div>
        <div class="nailla-typing" id="naillaTyping">Nailla sedang menulis…</div>
        <div class="nailla-footer">
          <input id="naillaInput" type="text" placeholder="Ketik pesan…" autocomplete="off">
          <button id="naillaSend">Kirim</button>
        </div>
      </div>
    `;
    return wrap;
  }

  // ── API ───────────────────────────────────────────────────────────────────
  function postChat(text, sessionKey, isHidden) {
    return fetch(CONFIG.apiEndpoint, {
      method:  'POST',
      headers: { 'Content-Type':'application/json', 'X-OpenClaw-Token': CONFIG.hookToken },
      body: JSON.stringify({ message: text, sessionKey }),
    });
  }

  function postEmailReport(payload) {
    return fetch('/nailla-email.php', {
      method:  'POST',
      headers: { 'Content-Type':'application/json' },
      body: JSON.stringify(payload),
    });
  }

  // ── PARSE EMAIL REPORT SIGNAL ─────────────────────────────────────────────
  function maybeSendEmailReport(rawText) {
    if (typeof rawText !== 'string') return;
    const sig = rawText.match(/\[NAILLA_EMAIL_REPORT:([\s\S]*?)\]/i);
    if (!sig) return;
    try {
      const parsed = {};
      sig[1].replace(/(\w+)="([^"]*)"/g, (_, k, v) => { parsed[k] = v; });
      if (parsed.name || parsed.contact) {
        postEmailReport({
          name:     parsed.name     || 'Tidak diketahui',
          contact:  parsed.contact  || 'Tidak ada',
          reason:   parsed.reason   || 'tidak disebutkan',
          interest: parsed.interest || 'Umum',
          context:  parsed.context  || rawText.slice(0, 300),
        }).catch(() => {});
      }
    } catch (_) { /* never break the chat UI */ }
  }

  // ── SEND MESSAGE ──────────────────────────────────────────────────────────
  function send() {
    const text = _input.value.trim();
    if (!text) return;

    // User bubble
    const uEl = document.createElement('div');
    uEl.className = 'nailla-msg user';
    uEl.textContent = text;
    _msgs.appendChild(uEl);
    _input.value = '';
    _msgs.scrollTop = _msgs.scrollHeight;

    _typing.style.display = 'block';
    _send.disabled = true;

    const sk = 'hook:website-nailla-' + Date.now();

    postChat(text, sk, false)
      .then(r => r.json())
      .then(data => {
        _typing.style.display = 'none';
        _send.disabled = false;
        const raw = data.response || data.message || 'Maaf, saya mengalami kendala. Silakan coba lagi.';
        maybeSendEmailReport(raw);
        const display = raw.replace(/\s*\[NAILLA_EMAIL_REPORT:[\s\S]*?\]/i, '').trim();
        const bEl = document.createElement('div');
        bEl.className = 'nailla-msg bot';
        bEl.textContent = display;
        _msgs.appendChild(bEl);
        _msgs.scrollTop = _msgs.scrollHeight;
      })
      .catch(() => {
        _typing.style.display = 'none';
        _send.disabled = false;
        const eEl = document.createElement('div');
        eEl.className = 'nailla-msg bot';
        eEl.textContent = 'Koneksi bermasalah. Silakan coba lagi.';
        _msgs.appendChild(eEl);
        _msgs.scrollTop = _msgs.scrollHeight;
      });
  }

  // ── TOGGLE WINDOW ─────────────────────────────────────────────────────────
  function toggle() {
    const show = !_win.classList.contains('open');
    _win.classList.toggle('open', show);
    if (show) { _input.focus(); }
  }

  // ── IDLE / AUTO-TRIGGER ───────────────────────────────────────────────────
  function resetIdle() { _lastActive = Date.now(); }

  function startIdleWatch() {
    _idleTimer = setInterval(() => {
      if (_triggered && CONFIG.autoTrigger.onlyOnce) return;
      if (document.visibilityState === 'hidden') return;
      if (Date.now() - _lastActive < 3000) return; // user is active
      if (Date.now() - _lastActive >= CONFIG.autoTrigger.ms) {
        _triggered = true;
        // Open window silently
        _win.classList.add('open');
        // Send pre-prompt (hidden from UI)
        postChat(CONFIG.autoTrigger.prePrompt,
                 CONFIG.autoTrigger.sessionKey + Date.now(), true).catch(() => {});
      }
    }, 1000);
  }

  // ── INIT ──────────────────────────────────────────────────────────────────
  document.addEventListener('DOMContentLoaded', function init() {
    document.body.appendChild(build());

    // Inject dynamic greeting (time-of-day aware)
    var _gEl = document.getElementById('greetingMsg');
    if (_gEl && getGreeting) { _gEl.innerHTML = getGreeting(); }

    _win   = document.getElementById('naillaWindow');
    _btn   = document.getElementById('naillaLauncher');
    _input = document.getElementById('naillaInput');
    _send  = document.getElementById('naillaSend');
    _msgs  = document.getElementById('naillaBody');
    _typing= document.getElementById('naillaTyping');

    _btn.addEventListener('click', toggle);
    _send.addEventListener('click', send);
    _input.addEventListener('keypress', e => { if (e.key === 'Enter') send(); });

    document.addEventListener('mousemove',  resetIdle, { passive: true });
    document.addEventListener('keydown',    resetIdle, { passive: true });
    document.addEventListener('wheel',      resetIdle, { passive: true });
    document.addEventListener('touchstart', resetIdle, { passive: true });
    document.addEventListener('scroll',     resetIdle, { passive: true });

    if (CONFIG.autoTrigger.enabled) startIdleWatch();
  }, { once: true });

})();
