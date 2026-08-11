@extends('layouts.admin')

@section('title', 'Live Chat')
@section('page_title', 'Live Chat')

@section('breadcrumb')
    <li class="breadcrumb-item active">Live Chat</li>
@endsection

@section('content')

    <div class="row g-3">

        <div class="col-md-4">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span class="fw-semibold">Conversations</span>
                    <select id="statusFilter" class="form-select form-select-sm" style="width: 110px;">
                        <option value="">All</option>
                        <option value="open" selected>Open</option>
                        <option value="closed">Closed</option>
                    </select>
                </div>
                <div class="list-group list-group-flush" id="sessionList" style="max-height: 65vh; overflow-y: auto;"></div>
                <div class="text-center text-muted py-4 d-none" id="emptyState">No conversations yet.</div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card" style="min-height: 65vh;">
                <div id="noSessionSelected" class="d-flex align-items-center justify-content-center text-muted" style="height: 65vh;">
                    Select a conversation to view it.
                </div>

                <div id="chatPanel" class="d-none d-flex flex-column" style="height: 65vh;">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div>
                            <div class="fw-semibold" id="chatName"></div>
                            <div class="text-muted small" id="chatMeta"></div>
                        </div>
                        <button class="btn btn-sm btn-outline-secondary" id="btnCloseChat">Close Chat</button>
                    </div>

                    <div class="flex-grow-1 p-3 overflow-auto" id="chatMessages" style="background: #f8f9fa;"></div>

                    <div class="card-footer">
                        <form id="replyForm" class="d-flex gap-2">
                            <input type="text" id="replyInput" class="form-control" placeholder="Type a reply..." autocomplete="off">
                            <button type="submit" class="btn btn-primary">Send</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- ── Close-chat confirmation modal ────────────────────────────── -->
    <div class="modal fade" id="closeChatModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center py-4 px-4">
                    <div class="close-chat-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/><line x1="9" y1="10" x2="15" y2="14"/><line x1="15" y1="10" x2="9" y2="14"/></svg>
                    </div>
                    <h5 class="mt-3 mb-2">Close this conversation?</h5>
                    <p class="text-muted mb-0">The visitor won't be able to send further messages once this chat is closed. This can't be undone.</p>
                </div>
                <div class="modal-footer border-0 justify-content-center pb-4 pt-0">
                    <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-close-confirm px-4" id="confirmCloseChatBtn">Yes, Close Chat</button>
                </div>
            </div>
        </div>
    </div>

    <!-- ── Toast notifications ──────────────────────────────────────── -->
    <div class="lc-toast-container" id="lcToastContainer"></div>

@endsection

@push('styles')
<style>
    :root{
        --lc-accent:#4F6B63;
        --lc-accent-dark:#3E5B54;
        --lc-accent-light:#607570;
    }

    .chat-bubble { max-width: 75%; padding: 8px 14px; border-radius: 14px; margin-bottom: 10px; font-size: 14px; line-height: 1.4; }
    .chat-bubble__visitor { background: #EEF3F1; border: 1px solid #D7E1DC; color: #262135; margin-right: auto; }
    .chat-bubble__admin { background: #4F6B63; color: #fff; margin-left: auto; }
    .chat-bubble__ai { background: #fff3cd; border: 1px solid #ffe69c; margin-right: auto; }
    .chat-bubble__time { font-size: 11px; opacity: .65; display: block; margin-top: 3px; }
    .session-item.unread .fw-semibold { font-weight: 700 !important; }
    .session-item.active { background-color: #4F6B63; }
    #sessionListError {
        margin: 10px 14px; padding: 10px 12px; border-radius: 8px;
        background: #fdecea; border: 1px solid #f5c2c0; color: #8a1f16;
        font-size: 12.5px; line-height: 1.4; display: none;
    }
    #sessionListError.show { display: block; }
    #chatSendError {
        font-size: 12px; color: #b42318; margin-top: 6px; display: none;
    }
    #chatSendError.show { display: block; }

    /* ── Close-chat confirmation modal ─────────────────────────────── */
    #closeChatModal .modal-content {
        border: none;
        border-radius: 18px;
        overflow: hidden;
        box-shadow: 0 24px 60px rgba(20, 30, 27, 0.25);
    }
    .close-chat-icon {
        width: 60px; height: 60px;
        margin: 0 auto;
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        background: linear-gradient(135deg, var(--lc-accent-dark), var(--lc-accent), var(--lc-accent-light));
        box-shadow: 0 10px 22px rgba(79, 107, 99, 0.35);
        animation: closeIconPop .4s cubic-bezier(.34,1.56,.64,1);
    }
    .close-chat-icon svg { width: 26px; height: 26px; color: #fff; }
    @keyframes closeIconPop {
        from { transform: scale(0.5); opacity: 0; }
        to { transform: scale(1); opacity: 1; }
    }
    #closeChatModal h5 { font-weight: 700; color: #1f2a26; }
    .btn-close-confirm {
        color: #fff;
        background: linear-gradient(120deg, var(--lc-accent-dark), var(--lc-accent));
        border: none;
        transition: transform .15s ease, box-shadow .15s ease;
    }
    .btn-close-confirm:hover { color:#fff; transform: translateY(-1px); box-shadow: 0 8px 18px rgba(79,107,99,0.35); }
    .btn-close-confirm:disabled { opacity: .6; transform: none; box-shadow: none; }
    #closeChatModal .btn-light { background:#f1f3f2; border:none; }
    #closeChatModal .btn-light:hover { background:#e6e9e7; }

    /* ── Toast ──────────────────────────────────────────────────────── */
    .lc-toast-container { position: fixed; top: 20px; right: 20px; z-index: 1080; }
    .lc-toast {
        display:flex; align-items:center; gap:.7rem;
        min-width: 300px; max-width: 380px;
        background:#fff;
        border-radius: 12px;
        padding: .85rem 1rem;
        box-shadow: 0 14px 34px rgba(20,30,27,0.22);
        border-left: 4px solid var(--lc-accent);
        transform: translateX(20px);
        opacity: 0;
        transition: transform .35s cubic-bezier(.22,1,.36,1), opacity .35s ease;
        pointer-events: none;
    }
    .lc-toast.show { transform: translateX(0); opacity: 1; pointer-events: auto; }
    .lc-toast.lc-toast--error { border-left-color: #c0392b; }
    .lc-toast-icon {
        flex-shrink:0; width:30px; height:30px; border-radius:50%;
        display:flex; align-items:center; justify-content:center;
        background: linear-gradient(135deg, var(--lc-accent-dark), var(--lc-accent));
        color:#fff;
    }
    .lc-toast--error .lc-toast-icon { background: linear-gradient(135deg, #a33224, #c0392b); }
    .lc-toast-icon svg { width:15px; height:15px; }
    .lc-toast-text { font-size: 13.5px; color:#26332f; line-height:1.4; }
    .lc-toast-text strong { display:block; font-size:13.5px; margin-bottom:1px; }
</style>
@endpush

@push('scripts')
<script>
(function () {
    // ── Guard against double-initialization ──────────────────────────
    // If this script block ever prints/runs twice on the same page
    // (duplicated @@stack('scripts') in the layout, an accidental
    // second @@include of this view, or SPA-style navigation that
    // doesn't do a full reload), every listener below would get bound
    // twice — which is exactly what causes "one click, message sent
    // twice." This flag makes re-running the script a no-op.
    if (window.__adminLiveChatInitialized) {
        console.warn('Live Chat admin script already initialized — skipping duplicate init. Check for a duplicated scripts-stack include in the layout.');
        return;
    }
    window.__adminLiveChatInitialized = true;

    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
    const routes = {
        data: "{{ route('live-chat.data') }}",
        show: uuid => `{{ url('admin/live-chat') }}/${uuid}`,
        poll: uuid => `{{ url('admin/live-chat') }}/${uuid}/poll`,
        typing: uuid => `{{ url('admin/live-chat') }}/${uuid}/typing`,
        reply: uuid => `{{ url('admin/live-chat') }}/${uuid}/reply`,
        close: uuid => `{{ url('admin/live-chat') }}/${uuid}/close`,
    };

    const sessionList = document.getElementById('sessionList');
    const emptyState = document.getElementById('emptyState');
    const statusFilter = document.getElementById('statusFilter');
    const noSessionSelected = document.getElementById('noSessionSelected');
    const chatPanel = document.getElementById('chatPanel');
    const chatMessages = document.getElementById('chatMessages');
    const chatName = document.getElementById('chatName');
    const chatMeta = document.getElementById('chatMeta');
    const replyForm = document.getElementById('replyForm');
    const replyInput = document.getElementById('replyInput');
    const replyBtn = replyForm.querySelector('button[type="submit"]');

    let activeUuid = null;
    let lastMessageId = 0;
    let pollTimer = null;
    let listTimer = null;
    let isSending = false; // second line of defense against double-submit

    // ── Small error banner helpers (so failures are visible, not silent) ──
    function ensureSessionListErrorEl() {
        let el = document.getElementById('sessionListError');
        if (!el) {
            el = document.createElement('div');
            el.id = 'sessionListError';
            sessionList.parentElement.insertBefore(el, sessionList);
        }
        return el;
    }

    function showSessionListError(message) {
        const el = ensureSessionListErrorEl();
        el.textContent = message;
        el.classList.add('show');
    }

    function clearSessionListError() {
        const el = document.getElementById('sessionListError');
        if (el) el.classList.remove('show');
    }

    function ensureChatSendErrorEl() {
        let el = document.getElementById('chatSendError');
        if (!el) {
            el = document.createElement('div');
            el.id = 'chatSendError';
            replyForm.insertAdjacentElement('afterend', el);
        }
        return el;
    }

    function showChatSendError(message) {
        const el = ensureChatSendErrorEl();
        el.textContent = message;
        el.classList.add('show');
    }

    function clearChatSendError() {
        const el = document.getElementById('chatSendError');
        if (el) el.classList.remove('show');
    }

    function escapeHtml(str) {
        const div = document.createElement('div');
        div.textContent = str;
        return div.innerHTML;
    }

    // Turns a failed fetch Response into a readable Error, since Laravel
    // usually returns JSON errors but may return an HTML redirect (e.g.
    // expired session -> /login) which res.json() can't parse.
    async function checkResponse(res) {
        if (res.ok) return res;

        let detail = `HTTP ${res.status}`;
        try {
            const contentType = res.headers.get('content-type') || '';
            if (contentType.includes('application/json')) {
                const body = await res.json();
                detail = body.message || detail;
            } else if (res.status === 401 || res.status === 419 || res.redirected) {
                detail = 'Your session may have expired. Try refreshing the page and logging in again.';
            }
        } catch (e) {
            // response body wasn't readable JSON — keep the generic detail
        }

        throw new Error(detail);
    }

    function renderBubble(m) {
        // Skip if this message id is already on screen — guards against
        // the same message being rendered twice if a poll and a reply
        // response race each other.
        if (chatMessages.querySelector(`[data-msg-id="${m.id}"]`)) {
            lastMessageId = Math.max(lastMessageId, m.id);
            return;
        }

        const cls = m.sender === 'admin' ? 'chat-bubble__admin' : (m.sender === 'ai' ? 'chat-bubble__ai' : 'chat-bubble__visitor');
        chatMessages.insertAdjacentHTML('beforeend', `
            <div class="chat-bubble ${cls}" data-msg-id="${m.id}">
                ${escapeHtml(m.message)}
                <span class="chat-bubble__time">${m.created_at}</span>
            </div>
        `);
        lastMessageId = Math.max(lastMessageId, m.id);
    }

    function loadSessions() {
        clearSessionListError();
        const params = new URLSearchParams({ status: statusFilter.value });

        fetch(`${routes.data}?${params.toString()}`, { headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' } })
            .then(checkResponse)
            .then(res => res.json())
            .then(payload => {
                sessionList.innerHTML = '';
                emptyState.classList.toggle('d-none', payload.sessions.length > 0);

                payload.sessions.forEach(s => {
                    const activeCls = s.uuid === activeUuid ? 'active' : '';
                    const unreadCls = s.has_unread ? 'unread' : '';
                    sessionList.insertAdjacentHTML('beforeend', `
                        <button type="button" class="list-group-item list-group-item-action session-item ${activeCls} ${unreadCls}" data-uuid="${s.uuid}">
                            <div class="d-flex justify-content-between">
                                <span class="${s.has_unread ? 'fw-semibold' : ''}">${escapeHtml(s.name)}</span>
                                ${s.has_unread ? '<span class="badge text-bg-danger">new</span>' : ''}
                            </div>
                            <div class="text-muted small">${escapeHtml(s.email ?? '')}</div>
                            <div class="text-muted small">${escapeHtml(s.last_active ?? '')} · ${escapeHtml(s.status)}${s.assigned_admin ? ' · with ' + escapeHtml(s.assigned_admin) : ''}</div>
                        </button>
                    `);
                });
            })
            .catch(err => {
                console.error('Failed to load chat sessions:', err);
                sessionList.innerHTML = '';
                emptyState.classList.add('d-none');
                showSessionListError(`Couldn't load conversations: ${err.message}`);
            });
    }

    sessionList.addEventListener('click', e => {
        const item = e.target.closest('.session-item');
        if (item) openSession(item.dataset.uuid);
    });

    function openSession(uuid) {
        activeUuid = uuid;
        lastMessageId = 0;
        clearInterval(pollTimer);
        clearChatSendError();

        fetch(routes.show(uuid), { headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' } })
            .then(checkResponse)
            .then(res => res.json())
            .then(s => {
                noSessionSelected.classList.add('d-none');
                chatPanel.classList.remove('d-none');
                chatPanel.classList.add('d-flex');

                chatName.textContent = s.name || 'Anonymous';
                chatMeta.textContent = [s.email, s.phone].filter(Boolean).join(' · ') + (s.status === 'closed' ? ' · Closed' : '');

                chatMessages.innerHTML = '';
                s.messages.forEach(renderBubble);
                chatMessages.scrollTop = chatMessages.scrollHeight;

                loadSessions(); // refresh unread state in the list

                pollTimer = setInterval(() => pollActiveSession(), 4000);
            })
            .catch(err => {
                console.error('Failed to open chat session:', err);
                noSessionSelected.classList.remove('d-none');
                noSessionSelected.textContent = `Couldn't load this conversation: ${err.message}`;
                chatPanel.classList.add('d-none');
                chatPanel.classList.remove('d-flex');
            });
    }

    function pollActiveSession() {
        if (!activeUuid) return;

        fetch(`${routes.poll(activeUuid)}?after_id=${lastMessageId}`, { headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' } })
            .then(checkResponse)
            .then(res => res.json())
            .then(payload => {
                if (payload.messages.length > 0) {
                    payload.messages.forEach(renderBubble);
                    chatMessages.scrollTop = chatMessages.scrollHeight;
                }
                if (payload.status === 'closed') {
                    chatMeta.textContent = chatMeta.textContent.includes('Closed')
                        ? chatMeta.textContent
                        : chatMeta.textContent + ' · Closed';
                    clearInterval(pollTimer);
                }
            })
            .catch(err => {
                // Don't spam the UI on every 4s poll failure — just log it,
                // and stop polling if the session genuinely can't be reached.
                console.error('Chat poll failed:', err);
            });
    }

    let typingSendTimer = null;
    replyInput.addEventListener('input', () => {
        if (!activeUuid) return;
        clearTimeout(typingSendTimer);
        typingSendTimer = setTimeout(() => {
            fetch(routes.typing(activeUuid), {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': csrfToken, 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' },
            })
                .then(checkResponse)
                .catch(err => console.error('Typing indicator failed to send:', err)); // non-critical, log only
        }, 250); // small debounce so we don't fire on every keystroke
    });

    replyForm.addEventListener('submit', e => {
        e.preventDefault();
        if (!activeUuid || !replyInput.value.trim()) return;

        // Second line of defense: if a send is already in flight (e.g. a
        // rapid double-click/double-Enter before the button finished
        // disabling), ignore the extra submit entirely.
        if (isSending) return;
        isSending = true;

        clearChatSendError();
        const message = replyInput.value.trim();
        replyInput.value = '';
        replyInput.disabled = true;
        replyBtn.disabled = true;

        fetch(routes.reply(activeUuid), {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ message }),
        })
            .then(checkResponse)
            .then(res => res.json())
            .then(payload => {
                renderBubble(payload.message);
                chatMessages.scrollTop = chatMessages.scrollHeight;
            })
            .catch(err => {
                console.error('Failed to send reply:', err);
                showChatSendError(`Message may not have sent: ${err.message}`);
                replyInput.value = message; // give the message back so it isn't lost
            })
            .finally(() => {
                isSending = false;
                replyInput.disabled = false;
                replyBtn.disabled = false;
                replyInput.focus();
            });
    });

    // ── Toast helper ───────────────────────────────────────────────
    function showToast(message, { title = 'Success', type = 'success', duration = 3200 } = {}) {
        const container = document.getElementById('lcToastContainer');
        const el = document.createElement('div');
        el.className = 'lc-toast' + (type === 'error' ? ' lc-toast--error' : '');

        const iconSvg = type === 'error'
            ? '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>'
            : '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>';

        el.innerHTML = `
            <div class="lc-toast-icon">${iconSvg}</div>
            <div class="lc-toast-text"><strong>${escapeHtml(title)}</strong>${escapeHtml(message)}</div>
        `;
        container.appendChild(el);

        requestAnimationFrame(() => el.classList.add('show'));

        setTimeout(() => {
            el.classList.remove('show');
            setTimeout(() => el.remove(), 350);
        }, duration);
    }

    // ── Close-chat confirmation modal ─────────────────────────────────
    // Falls back to the native confirm()/alert() if Bootstrap's JS
    // bundle isn't loaded on this page, so closing a chat still works
    // even without the modal.
    const closeChatModalEl = document.getElementById('closeChatModal');
    const confirmCloseChatBtn = document.getElementById('confirmCloseChatBtn');
    const hasBootstrapModal = typeof window.bootstrap !== 'undefined' && window.bootstrap.Modal;
    const closeChatModal = hasBootstrapModal ? new window.bootstrap.Modal(closeChatModalEl) : null;

    function performCloseChat() {
        const uuidToClose = activeUuid;

        confirmCloseChatBtn.disabled = true;
        confirmCloseChatBtn.textContent = 'Closing…';

        fetch(routes.close(uuidToClose), {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': csrfToken, 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' },
        })
            .then(checkResponse)
            .then(() => {
                if (closeChatModal) closeChatModal.hide();
                showToast('The conversation has been closed.', { title: 'Chat closed' });
                clearInterval(pollTimer);
                // Reload shortly after so the toast is visible before the
                // fresh page state (updated list, closed badge) lands.
                setTimeout(() => window.location.reload(), 1100);
            })
            .catch(err => {
                console.error('Failed to close chat:', err);
                if (closeChatModal) closeChatModal.hide();
                showToast(`Couldn't close this conversation: ${err.message}`, { title: 'Something went wrong', type: 'error' });
            })
            .finally(() => {
                confirmCloseChatBtn.disabled = false;
                confirmCloseChatBtn.textContent = 'Yes, Close Chat';
            });
    }

    document.getElementById('btnCloseChat').addEventListener('click', () => {
        if (!activeUuid) return;

        if (closeChatModal) {
            closeChatModal.show();
        } else if (confirm('Close this conversation?')) {
            performCloseChat();
        }
    });

    confirmCloseChatBtn.addEventListener('click', performCloseChat);

    statusFilter.addEventListener('change', loadSessions);

    loadSessions();
    listTimer = setInterval(loadSessions, 6000); // surface new incoming conversations
})();
</script>
@endpush