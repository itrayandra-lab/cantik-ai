@extends('guest')

@section('title', 'Chatbot')

@section('content')
    <div class="flex flex-col h-screen bg-gray-900 text-white">
        <header class="bg-gray-800 border-b border-gray-700 p-4 flex justify-between items-center">
            <h1 class="text-lg font-semibold text-white">💬 ChatBot Kecantikan</h1>
            <button id="resetChat" class="text-sm bg-gray-700 hover:bg-gray-600 px-3 py-1 rounded-lg">Reset</button>
        </header>

        <main id="chatContainer" class="flex-1 overflow-y-auto px-4 py-6 space-y-6 bg-gray-900"></main>

        <footer class="border-t border-gray-700 bg-gray-800 p-4">
            <div class="relative max-w-4xl mx-auto">
                <input type="text" id="userInput" placeholder="Ketik pertanyaanmu di sini..."
                    class="w-full bg-gray-700 text-white rounded-full px-5 py-3 pr-12 focus:outline-none focus:ring-2 focus:ring-indigo-500 placeholder-gray-400">
                <button id="sendBtn"
                    class="absolute right-3 top-1/2 -translate-y-1/2 bg-indigo-600 hover:bg-indigo-700 text-white p-2 rounded-full transition-transform transform ">
                    <svg width="20px" height="20px" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M9.61109 12.4L10.8183 18.5355C11.0462 19.6939 12.6026 19.9244 13.1565 18.8818L19.0211 7.84263C19.248 7.41555 19.2006 6.94354 18.9737 6.58417M9.61109 12.4L5.22642 8.15534C4.41653 7.37131 4.97155 6 6.09877 6H17.9135C18.3758 6 18.7568 6.24061 18.9737 6.58417M9.61109 12.4L18.9737 6.58417M19.0555 6.53333L18.9737 6.58417"
                            stroke="white" stroke-width="2" />
                    </svg>

                </button>
            </div>
        </footer>
    </div>

@endsection

@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const chatBox = document.getElementById("chatContainer");
            const input = document.getElementById("userInput");
            const sendBtn = document.getElementById("sendBtn");
            const resetBtn = document.getElementById("resetChat");
            const apiUrl = "{{ route('chatbot') }}";
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute("content");

            function addMessage(text, sender = "bot") {
                let safeText = document.createElement("div");
                safeText.textContent = text;
                safeText = safeText.innerHTML;

                safeText = safeText
                    .replace(/\n/g, "<br>")
                    .replace(/\*\*(.*?)\*\*/g, "<strong>$1</strong>")
                    .replace(/\*(.*?)\*/g, "<em>$1</em>")
                    .replace(/__(.*?)__/g, "<u>$1</u>");

                const msgClass = sender === "user" ?
                    "bg-indigo-600 text-white rounded-2xl px-4 py-3 self-end max-w-[80%]" :
                    "bg-gray-800 text-gray-100 rounded-2xl px-4 py-3 self-start max-w-[80%]";

                const align = sender === "user" ? "justify-end" : "justify-start";

                const bubble = document.createElement("div");
                bubble.className = `flex ${align} animate-fadeIn`;
                bubble.innerHTML =
                    `<div class="${msgClass} whitespace-pre-line text-sm break-words">${safeText}</div>`;

                chatBox.appendChild(bubble);
                chatBox.scrollTop = chatBox.scrollHeight;
            }

            async function sendMessage() {
                const query = input.value.trim();
                if (!query) return;

                addMessage(query, "user");
                input.value = "";
                addMessage("⏳ Sedang memproses...", "bot");

                try {
                    const response = await fetch(apiUrl, {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": csrfToken
                        },
                        body: JSON.stringify({
                            query
                        })
                    });

                    const loaders = Array.from(chatBox.querySelectorAll(".flex"))
                        .filter(el => el.textContent.includes("⏳ Sedang memproses..."));
                    if (loaders.length > 0) loaders[loaders.length - 1].remove();

                    if (!response.ok) {
                        addMessage("⚠️ Terjadi kesalahan saat menghubungi server.", "bot");
                        return;
                    }

                    const data = await response.json();
                    addMessage(data.answer || "Tidak ada jawaban dari server.", "bot");

                } catch (error) {
                    const loaders = Array.from(chatBox.querySelectorAll(".flex"))
                        .filter(el => el.textContent.includes("⏳ Sedang memproses..."));
                    if (loaders.length > 0) loaders[loaders.length - 1].remove();

                    addMessage("⚠️ Terjadi kesalahan jaringan atau server.", "bot");
                }
            }

            sendBtn.addEventListener("click", sendMessage);

            input.addEventListener("keypress", (e) => {
                if (e.key === "Enter") sendMessage();
            });

            resetBtn.addEventListener("click", () => {
                chatBox.innerHTML =
                    '<div class="text-center text-gray-400 text-sm">Memulai percakapan baru...</div>';
                setTimeout(showGreeting, 400);
            });

            function showGreeting() {
                addMessage("🌸 Halo! Aku asisten virtual kecantikanmu 💕", "bot");
                addMessage("Tanyakan apa saja tentang produk, manfaat, atau rekomendasi skincare!", "bot");
            }

            showGreeting();
        });
    </script>
@endpush
