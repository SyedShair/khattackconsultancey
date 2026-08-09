{{-- ============================================================
     Floating Assistant Widget
     - Click bubble to open a chat panel
     - "1. Book a Consultation" walks through name/phone/email/query
       then shows date + time-slot chips built from Settings hours
     - "2. Talk to Our Team" collects details, opens a live chat
       session that admins can reply to from /admin/live-chat
     - Any freeform typed message is answered by Groq AI
   ============================================================ --}}

<div id="assistantWidget">

    <button id="assistantLauncher" type="button" aria-label="Open chat assistant">
        <span id="assistantLauncherIcon">
            <svg width="26" height="26" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M21 11.5C21 16.75 16.75 21 11.5 21C9.86 21 8.32 20.58 7 19.84L3 21L4.16 17C3.42 15.68 3 14.14 3 12.5C3 7.25 7.25 3 12.5 3C17.75 3 21 7.25 21 11.5Z" stroke="white" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </span>
        <span id="assistantLauncherClose">&times;</span>
        <span id="assistantUnreadBadge">1</span>
    </button>

    <div id="assistantPanel">

        <div id="assistantHeader">
            <div class="d-flex align-items-center gap-2">
                @if($appSetting->logo_url ?? false)
                    <img src="{{ $appSetting->logo_url }}" alt="" id="assistantHeaderLogo">
                @endif
                <div>
                    <div id="assistantHeaderTitle">{{ $appSetting->app_name ?? config('app.name') }}</div>
                    <div id="assistantHeaderStatus"><span class="assistant-dot"></span> Online</div>
                </div>
            </div>
            <button type="button" id="assistantCloseBtn" aria-label="Close chat">&times;</button>
        </div>

        <div id="assistantMessages"></div>

        <form id="assistantInputForm">
            <input type="text" id="assistantInput" placeholder="Type a message..." autocomplete="off">
            <button type="submit" id="assistantSendBtn" aria-label="Send">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M22 2L11 13" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M22 2L15 22L11 13L2 9L22 2Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </button>
        </form>

    </div>
</div>

<style>
    #assistantWidget { position: fixed; right: 24px; bottom: 24px; z-index: 1060; font-family: inherit; }

    #assistantLauncher {
        width: 60px; height: 60px; border-radius: 50%; border: none;
        background: linear-gradient(135deg, #3E5B54, #4F6B63, #607570);
        box-shadow: 0 10px 24px rgba(79, 107, 99, 0.35);
        display: flex; align-items: center; justify-content: center;
        cursor: pointer; transition: transform .15s ease;
        position: relative;
    }
    #assistantLauncher:hover { transform: scale(1.06); }
    #assistantLauncherClose { display: none; color: #fff; font-size: 30px; line-height: 1; font-weight: 300; }
    #assistantWidget.open #assistantLauncherIcon { display: none; }
    #assistantWidget.open #assistantLauncherClose { display: block; }

    /* Blinking attention ring — animates continuously while the widget
       is closed, stops once opened. */
    #assistantLauncher::before {
        content: '';
        position: absolute;
        inset: 0;
        border-radius: 50%;
        background: linear-gradient(135deg, #3E5B54, #4F6B63, #607570);
        animation: assistantLauncherBlink 2.4s ease-out infinite;
        z-index: -1;
    }
    #assistantWidget.open #assistantLauncher::before { animation: none; opacity: 0; }
    @keyframes assistantLauncherBlink {
        0%   { transform: scale(1);   opacity: 0.55; }
        70%  { transform: scale(1.7); opacity: 0; }
        100% { transform: scale(1.7); opacity: 0; }
    }

    #assistantUnreadBadge {
        position: absolute;
        top: -4px;
        right: -4px;
        min-width: 20px;
        height: 20px;
        padding: 0 5px;
        border-radius: 10px;
        background: #ff3b30;
        color: #fff;
        font-size: 11px;
        font-weight: 700;
        display: none;
        align-items: center;
        justify-content: center;
        border: 2px solid #fff;
    }
    #assistantUnreadBadge.show { display: flex; }

    #assistantPanel {
        display: none;
        position: absolute;
        right: 0;
        bottom: 76px;
        width: 360px;
        max-width: calc(100vw - 32px);
        height: 520px;
        max-height: calc(100vh - 140px);
        background: #fff;
        border-radius: 18px;
        box-shadow: 0 20px 60px rgba(10, 6, 36, 0.25);
        overflow: hidden;
        flex-direction: column;
    }
    #assistantWidget.open #assistantPanel { display: flex; }

    #assistantHeader {
        background: linear-gradient(120deg, #3E5B54, #4F6B63, #607570);
        color: #fff;
        padding: 14px 16px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    #assistantHeaderLogo { width: 32px; height: 32px; border-radius: 50%; object-fit: cover; background: #fff; }
    #assistantHeaderTitle { font-weight: 700; font-size: 15px; }
    #assistantHeaderStatus { font-size: 12px; opacity: .9; display: flex; align-items: center; gap: 5px; }
    .assistant-dot { width: 7px; height: 7px; border-radius: 50%; background: #4ade80; display: inline-block; }
    #assistantCloseBtn { background: none; border: none; color: #fff; font-size: 22px; line-height: 1; cursor: pointer; }

    #assistantMessages {
        flex: 1;
        overflow-y: auto;
        padding: 16px;
        background: #f7f7fb;
        display: flex;
        flex-direction: column;
    }

    .assistant-msg { max-width: 82%; margin-bottom: 10px; font-size: 13.5px; line-height: 1.45; }
    .assistant-msg--bot { align-self: flex-start; }
    .assistant-msg--user { align-self: flex-end; }
    .assistant-msg__bubble { padding: 9px 13px; border-radius: 14px; display: inline-block; }
    .assistant-msg--bot .assistant-msg__bubble { background: #fff; border: 1px solid #e9e7f3; border-bottom-left-radius: 4px; color: #262135; }
    .assistant-msg--user .assistant-msg__bubble { background: linear-gradient(120deg, #3E5B54, #4F6B63); color: #fff; border-bottom-right-radius: 4px; }

    .assistant-chips { display: flex; flex-wrap: wrap; gap: 8px; margin: 4px 0 14px; align-self: flex-start; max-width: 100%; }
    .assistant-chip {
        border: 1.5px solid #4F6B63; color: #4F6B63; background: #fff;
        border-radius: 20px; padding: 7px 14px; font-size: 13px; font-weight: 600;
        cursor: pointer; transition: background .15s ease, color .15s ease;
    }
    .assistant-chip:hover { background: #4F6B63; color: #fff; }
    .assistant-chip:disabled { opacity: .4; cursor: not-allowed; }
    .assistant-chip--closed { border-color: #d1d5db; color: #9ca3af; }
    .assistant-chip--closed:hover { background: #fff; color: #9ca3af; cursor: not-allowed; }

    .assistant-typing { align-self: flex-start; margin-bottom: 10px; }
    .assistant-typing .assistant-msg__bubble { background: #fff; border: 1px solid #e9e7f3; display: flex; gap: 4px; align-items: center; padding: 11px 15px; }
    .assistant-typing span { width: 6px; height: 6px; border-radius: 50%; background: #b9b6c9; animation: assistantTypingBlink 1.2s infinite ease-in-out; }
    .assistant-typing span:nth-child(2) { animation-delay: .2s; }
    .assistant-typing span:nth-child(3) { animation-delay: .4s; }
    @keyframes assistantTypingBlink { 0%, 80%, 100% { opacity: .3; } 40% { opacity: 1; } }

    #assistantInputForm { display: flex; gap: 8px; padding: 12px; border-top: 1px solid #eee; background: #fff; }
    #assistantInput {
        flex: 1; border: 1.5px solid #e5e3ee; border-radius: 22px; padding: 9px 16px;
        font-size: 13.5px; outline: none; transition: border-color .15s ease;
    }
    #assistantInput:focus { border-color: #4F6B63; }
    #assistantInput:disabled { background: #f3f3f6; }
    #assistantSendBtn {
        width: 40px; height: 40px; border-radius: 50%; border: none;
        background: linear-gradient(120deg, #3E5B54, #4F6B63);
        color: #fff; display: flex; align-items: center; justify-content: center;
        cursor: pointer; flex-shrink: 0;
    }
    #assistantSendBtn:disabled { opacity: .5; cursor: not-allowed; }

    @media (max-width: 480px) {
        #assistantWidget { right: 16px; bottom: 16px; }
        #assistantPanel { width: calc(100vw - 32px); right: -8px; }
    }
</style>
<script>
(function () {
    const COMPANY_NAME = @json($appSetting->app_name ?? config('app.name'));
    const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').content;
    const STORAGE_KEY = 'assistant_chat_uuid';

    const widget = document.getElementById('assistantWidget');
    const launcher = document.getElementById('assistantLauncher');
    const unreadBadge = document.getElementById('assistantUnreadBadge');
    const closeBtn = document.getElementById('assistantCloseBtn');
    const messagesEl = document.getElementById('assistantMessages');
    const headerStatus = document.getElementById('assistantHeaderStatus');
    const headerTitle = document.getElementById('assistantHeaderTitle');
    const form = document.getElementById('assistantInputForm');
    const input = document.getElementById('assistantInput');
    const sendBtn = document.getElementById('assistantSendBtn');

    // ── Conversation state machine ──────────────────────────────────
    // mode: null | 'booking' | 'team-intake' | 'team-chat'
    // step: current field being collected within that mode
    let state = { mode: null, step: null, data: {} };
    let activeSubmitHandler = handleFreeformInput;
    let hasOpenedOnce = false;
    let chatPollTimer = null;
    let lastChatMessageId = 0;
    let unreadCount = 0;
    let assignedAdminName = null;
    let adminTypingIndicatorShown = false;

    function scrollToBottom() {
        messagesEl.scrollTop = messagesEl.scrollHeight;
    }

    function bumpUnreadBadge() {
        if (widget.classList.contains('open')) return;
        unreadCount++;
        unreadBadge.textContent = unreadCount > 9 ? '9+' : String(unreadCount);
        unreadBadge.classList.add('show');
    }

    function clearUnreadBadge() {
        unreadCount = 0;
        unreadBadge.classList.remove('show');
    }

    function setHeaderStatus(text, online = true) {
        headerStatus.innerHTML = `<span class="assistant-dot"></span> ${text}`;
        if (!online) headerStatus.querySelector('.assistant-dot').style.background = '#f59e0b';
    }

    function addBotMessage(html) {
        const el = document.createElement('div');
        el.className = 'assistant-msg assistant-msg--bot';
        el.innerHTML = `<div class="assistant-msg__bubble">${html}</div>`;
        messagesEl.appendChild(el);
        scrollToBottom();
        bumpUnreadBadge();
    }

    function addUserMessage(text) {
        const el = document.createElement('div');
        el.className = 'assistant-msg assistant-msg--user';
        el.innerHTML = `<div class="assistant-msg__bubble"></div>`;
        el.querySelector('.assistant-msg__bubble').textContent = text;
        messagesEl.appendChild(el);
        scrollToBottom();
    }

    function showTyping() {
        if (document.getElementById('assistantTypingIndicator')) return; // already shown, avoid duplicates
        const el = document.createElement('div');
        el.className = 'assistant-typing';
        el.id = 'assistantTypingIndicator';
        el.innerHTML = `<div class="assistant-msg__bubble"><span></span><span></span><span></span></div>`;
        messagesEl.appendChild(el);
        scrollToBottom();
    }

    function hideTyping() {
        document.getElementById('assistantTypingIndicator')?.remove();
    }

    function showChips(chips) {
        const wrap = document.createElement('div');
        wrap.className = 'assistant-chips';
        chips.forEach(chip => {
            const btn = document.createElement('button');
            btn.type = 'button';
            btn.className = 'assistant-chip' + (chip.disabled ? ' assistant-chip--closed' : '');
            btn.textContent = chip.label;
            btn.disabled = !!chip.disabled;
            btn.addEventListener('click', () => {
                if (chip.disabled) return;
                Array.from(wrap.querySelectorAll('.assistant-chip')).forEach(b => b.disabled = true);
                chip.onClick();
            });
            wrap.appendChild(btn);
        });
        messagesEl.appendChild(wrap);
        scrollToBottom();
    }

    function setInputMode({ placeholder = 'Type a message...', disabled = false } = {}) {
        input.placeholder = placeholder;
        input.disabled = disabled;
        sendBtn.disabled = disabled;
    }

    // ── Panel open/close ─────────────────────────────────────────────
    launcher.addEventListener('click', () => {
        widget.classList.toggle('open');
        if (widget.classList.contains('open') && !hasOpenedOnce) {
            hasOpenedOnce = true;
            startWelcome();
        }
        if (widget.classList.contains('open')) {
            input.focus();
            clearUnreadBadge();
        }
    });
    closeBtn.addEventListener('click', () => widget.classList.remove('open'));

    // ── Welcome / main menu ──────────────────────────────────────────
    function startWelcome() {
        addBotMessage(`👋 Welcome to <b>${COMPANY_NAME}</b>! How can we help you today?`);
        showMainMenu();

        // Resume an existing live-chat session if this browser has one.
        const existingUuid = localStorage.getItem(STORAGE_KEY);
        if (existingUuid) {
            resumeTeamChat(existingUuid);
        }
    }

    function showMainMenu() {
        state = { mode: null, step: null, data: {} };
        activeSubmitHandler = handleFreeformInput;
        setInputMode({ placeholder: 'Type a message, or choose below...' });
        clearInterval(chatPollTimer);
        hideTyping();
        adminTypingIndicatorShown = false;
        assignedAdminName = null;
        setHeaderStatus('Online');

        showChips([
            { label: '1️⃣ Book a Consultation', onClick: () => { addUserMessage('1. Book a Consultation'); startBookingFlow(); } },
            { label: '2️⃣ Talk to Our Team', onClick: () => { addUserMessage('2. Talk to Our Team'); startTeamIntake(); } },
        ]);
    }

    // ── Freeform → Groq AI ────────────────────────────────────────────
    let aiHistory = [];

    function handleFreeformInput(text) {
        addUserMessage(text);
        showTyping();

        fetch('{{ route('assistant.ai') }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': CSRF_TOKEN,
                'Content-Type': 'application/json',
                'Accept': 'application/json',
            },
            body: JSON.stringify({ message: text, history: aiHistory.slice(-6) }),
        })
            .then(res => res.json())
            .then(payload => {
                hideTyping();
                addBotMessage(escapeHtml(payload.reply));
                aiHistory.push({ role: 'user', content: text });
                aiHistory.push({ role: 'assistant', content: payload.reply });
                showChips([
                    { label: '1️⃣ Book a Consultation', onClick: () => { addUserMessage('1. Book a Consultation'); startBookingFlow(); } },
                    { label: '2️⃣ Talk to Our Team', onClick: () => { addUserMessage('2. Talk to Our Team'); startTeamIntake(); } },
                ]);
            })
            .catch(() => {
                hideTyping();
                addBotMessage("Sorry, something went wrong reaching our assistant. Please try again, or use the options below.");
                showMainMenu();
            });
    }

    function escapeHtml(str) {
        const div = document.createElement('div');
        div.textContent = str;
        return div.innerHTML;
    }

    // ══════════════════════════════════════════════════════════════
    // OPTION 1: Book a Consultation
    // ══════════════════════════════════════════════════════════════
    function startBookingFlow() {
        state = { mode: 'booking', step: 'name', data: {} };
        addBotMessage("Great! Let's get you booked in. First, what's your full name?");
        setInputMode({ placeholder: 'Your full name...' });
        activeSubmitHandler = (text) => {
            addUserMessage(text);
            state.data.name = text;
            state.step = 'phone';
            addBotMessage(`Thanks, ${escapeHtml(text)}! What's the best phone number to reach you?`);
            setInputMode({ placeholder: 'Phone number...' });
            activeSubmitHandler = (text2) => {
                addUserMessage(text2);
                state.data.phone = text2;
                state.step = 'email';
                addBotMessage("And your email address?");
                setInputMode({ placeholder: 'Email address...' });
                activeSubmitHandler = (text3) => {
                    addUserMessage(text3);
                    if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(text3)) {
                        addBotMessage("That doesn't look like a valid email — could you double check it?");
                        return; // keep same handler, let them retry
                    }
                    state.data.email = text3;
                    state.step = 'query';
                    addBotMessage("What would you like to discuss in the consultation?");
                    setInputMode({ placeholder: 'Briefly describe what you need...' });
                    activeSubmitHandler = (text4) => {
                        addUserMessage(text4);
                        state.data.query = text4;
                        loadBookingDates();
                    };
                };
            };
        };
    }

    function loadBookingDates() {
        setInputMode({ placeholder: 'Please choose a date above...', disabled: true });
        showTyping();

        fetch('{{ route('assistant.availableDates') }}')
            .then(res => res.json())
            .then(payload => {
                hideTyping();
                addBotMessage("Perfect. Here are the next available days — pick one:");
                const openDates = payload.dates.filter(d => d.is_open);

                if (openDates.length === 0) {
                    addBotMessage("We don't have any upcoming open days configured right now — please use \"Talk to Our Team\" instead and we'll sort out a time with you directly.");
                    showMainMenu();
                    return;
                }

                showChips(openDates.slice(0, 8).map(d => ({
                    label: d.label,
                    onClick: () => { addUserMessage(d.label); loadBookingSlots(d.date, d.label); },
                })));
            })
            .catch(() => {
                hideTyping();
                addBotMessage("Sorry, I couldn't load our availability just now. Please try again in a moment.");
                showMainMenu();
            });
    }

    function loadBookingSlots(date, dateLabel) {
        showTyping();

        fetch(`{{ route('assistant.availableSlots') }}?date=${encodeURIComponent(date)}`)
            .then(res => res.json())
            .then(payload => {
                hideTyping();

                if (payload.slots.length === 0) {
                    addBotMessage("That day is fully booked. Please pick another date:");
                    loadBookingDates();
                    return;
                }

                addBotMessage(`Available times on ${dateLabel}:`);
                showChips(payload.slots.map(slot => ({
                    label: slot.label,
                    onClick: () => { addUserMessage(slot.label); confirmBooking(date, dateLabel, slot); },
                })));
            })
            .catch(() => {
                hideTyping();
                addBotMessage("Sorry, I couldn't load time slots just now. Please try again.");
                showMainMenu();
            });
    }

    function confirmBooking(date, dateLabel, slot) {
        showTyping();

        fetch('{{ route('assistant.book') }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': CSRF_TOKEN,
                'Content-Type': 'application/json',
                'Accept': 'application/json',
            },
            body: JSON.stringify({
                name: state.data.name,
                phone: state.data.phone,
                email: state.data.email,
                query: state.data.query,
                date: date,
                start: slot.start,
            }),
        })
            .then(async res => {
                const payload = await res.json();
                if (!res.ok) throw payload;
                return payload;
            })
            .then(payload => {
                hideTyping();
                addBotMessage(
                    `✅ <b>Your booking is confirmed!</b><br>${payload.booking.date} at ${payload.booking.start} - ${payload.booking.end}.<br>We'll be in touch at ${escapeHtml(state.data.email)} if anything changes.`
                );
                showMainMenu();
            })
            .catch(err => {
                hideTyping();
                addBotMessage(escapeHtml(err.message || 'Sorry, something went wrong booking that slot.'));
                loadBookingSlots(date, dateLabel);
            });
    }

    // ══════════════════════════════════════════════════════════════
    // OPTION 2: Talk to Our Team (live chat handoff)
    // ══════════════════════════════════════════════════════════════
    function startTeamIntake() {
        state = { mode: 'team-intake', step: 'name', data: {} };
        addBotMessage("No problem! Let's get you connected. What's your name?");
        setInputMode({ placeholder: 'Your full name...' });
        activeSubmitHandler = (text) => {
            addUserMessage(text);
            state.data.name = text;
            state.step = 'email';
            addBotMessage("And your email address, so we can follow up if needed?");
            setInputMode({ placeholder: 'Email address...' });
            activeSubmitHandler = (text2) => {
                addUserMessage(text2);
                if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(text2)) {
                    addBotMessage("That doesn't look like a valid email — could you double check it?");
                    return;
                }
                state.data.email = text2;
                state.step = 'phone';
                addBotMessage("Phone number (optional — type 'skip' to continue without it):");
                setInputMode({ placeholder: 'Phone number, or "skip"...' });
                activeSubmitHandler = (text3) => {
                    addUserMessage(text3);
                    state.data.phone = text3.toLowerCase() === 'skip' ? null : text3;
                    state.step = 'query';
                    addBotMessage("What would you like to talk to us about?");
                    setInputMode({ placeholder: 'Briefly describe what you need...' });
                    activeSubmitHandler = (text4) => {
                        addUserMessage(text4);
                        state.data.query = text4;
                        submitTeamIntake();
                    };
                };
            };
        };
    }

    function submitTeamIntake() {
        showTyping();

        fetch('{{ route('assistant.chat.start') }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': CSRF_TOKEN,
                'Content-Type': 'application/json',
                'Accept': 'application/json',
            },
            body: JSON.stringify(state.data),
        })
            .then(res => res.json())
            .then(payload => {
                hideTyping();
                localStorage.setItem(STORAGE_KEY, payload.session_uuid);
                addBotMessage(escapeHtml(payload.message));
                enterTeamChatMode(payload.session_uuid);
            })
            .catch(() => {
                hideTyping();
                addBotMessage("Sorry, something went wrong sending that to our team. Please try again.");
                showMainMenu();
            });
    }

    function resumeTeamChat(uuid) {
        fetch(`{{ url('assistant/chat') }}/${uuid}/messages?after_id=0`)
            .then(res => res.json())
            .then(payload => {
                if (payload.status === 'closed') {
                    localStorage.removeItem(STORAGE_KEY);
                    return;
                }
                addBotMessage("Welcome back! Continuing your conversation with our team below.");
                payload.messages.forEach(m => {
                    if (m.sender === 'visitor') addUserMessage(m.message);
                    else addBotMessage(escapeHtml(m.message));
                    lastChatMessageId = Math.max(lastChatMessageId, m.id);
                });
                if (payload.assigned_admin_name) {
                    announceAssignedAdmin(payload.assigned_admin_name, false);
                }
                enterTeamChatMode(uuid, false);
            })
            .catch(() => { /* silently ignore — user can still start fresh */ });
    }

    function announceAssignedAdmin(name, withMessage = true) {
        if (assignedAdminName === name) return; // already announced this admin
        assignedAdminName = name;
        setHeaderStatus(`Chatting with ${escapeHtml(name)}`);
        headerTitle.textContent = COMPANY_NAME;
        if (withMessage) {
            addBotMessage(`👤 <b>${escapeHtml(name)}</b> from our team has joined the chat.`);
        }
    }

    function enterTeamChatMode(uuid, resetLastId = true) {
        state = { mode: 'team-chat', step: null, data: { uuid } };
        if (resetLastId) lastChatMessageId = 0;
        setInputMode({ placeholder: 'Message our team...' });
        activeSubmitHandler = (text) => sendTeamMessage(uuid, text);
        if (!assignedAdminName) setHeaderStatus('Waiting for a team member...');

        clearInterval(chatPollTimer);
        chatPollTimer = setInterval(() => pollTeamChat(uuid), 4000);
    }

    function sendTeamMessage(uuid, text) {
        addUserMessage(text);

        fetch(`{{ url('assistant/chat') }}/${uuid}/message`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': CSRF_TOKEN,
                'Content-Type': 'application/json',
                'Accept': 'application/json',
            },
            body: JSON.stringify({ message: text }),
        }).catch(() => {
            addBotMessage("That message may not have sent — please check your connection and try again.");
        });
    }

    function pollTeamChat(uuid) {
        fetch(`{{ url('assistant/chat') }}/${uuid}/messages?after_id=${lastChatMessageId}`)
            .then(res => res.json())
            .then(payload => {
                if (payload.status === 'closed' && state.mode === 'team-chat') {
                    clearInterval(chatPollTimer);
                    hideTyping();
                    adminTypingIndicatorShown = false;
                    addBotMessage("This conversation has been closed by our team. Feel free to start a new one anytime!");
                    localStorage.removeItem(STORAGE_KEY);
                    setHeaderStatus('Online');
                    assignedAdminName = null;
                    showMainMenu();
                    return;
                }

                if (payload.assigned_admin_name) {
                    announceAssignedAdmin(payload.assigned_admin_name);
                }

                // WhatsApp-style "is typing..." reflecting the real admin,
                // not just AI wait states.
                if (payload.admin_typing && !adminTypingIndicatorShown) {
                    adminTypingIndicatorShown = true;
                    showTyping();
                } else if (!payload.admin_typing && adminTypingIndicatorShown) {
                    adminTypingIndicatorShown = false;
                    hideTyping();
                }

                if (payload.messages.length > 0) {
                    hideTyping();
                    adminTypingIndicatorShown = false;
                    payload.messages.forEach(m => {
                        if (m.sender !== 'visitor') addBotMessage(escapeHtml(m.message));
                        lastChatMessageId = Math.max(lastChatMessageId, m.id);
                    });
                }
            })
            .catch(() => { /* silent — will retry on next interval */ });
    }

    // ── Input submit routing ──────────────────────────────────────────
    form.addEventListener('submit', e => {
        e.preventDefault();
        const text = input.value.trim();
        if (!text || input.disabled) return;
        input.value = '';
        activeSubmitHandler(text);
    });
})();
</script>