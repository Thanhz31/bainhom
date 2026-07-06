
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- ========================================== -->
<!-- 1. NÚT ICON AI NỔI Ở GÓC DƯỚI BÊN PHẢI -->
<!-- ========================================== -->
<div id="ai-chat-icon" onclick="toggleAIChat()" style="position: fixed; bottom: 30px; right: 30px; cursor: pointer; z-index: 9999; box-shadow: 0 4px 15px rgba(230, 0, 0, 0.4); border-radius: 50%; width: 70px; height: 70px; background: white; display: flex; align-items: center; justify-content: center; transition: transform 0.3s ease;">
    <!-- CHÚ Ý: Đổi đuôi .png hoặc .jpg tùy thuộc vào file bạn đã lưu trong thư mục uploads -->
    <img src="uploads/iconai.png" alt="Trợ lý AI" style="width: 100%; height: 100%; border-radius: 50%; object-fit: cover;">
    
    <!-- Dấu chấm xanh báo Online -->
    <span style="position: absolute; bottom: 5px; right: 5px; width: 14px; height: 14px; background-color: #28a745; border: 2px solid white; border-radius: 50%;"></span>
</div>

<!-- ========================================== -->
<!-- 2. CỬA SỔ CHAT (MẶC ĐỊNH BỊ ẨN) -->
<!-- ========================================== -->
<div id="ai-chat-window" style="display: none; position: fixed; bottom: 110px; right: 30px; width: 360px; height: 520px; background: #ffffff; border-radius: 12px; box-shadow: 0 8px 25px rgba(0,0,0,0.2); z-index: 9999; flex-direction: column; overflow: hidden; border: 1px solid #e0e0e0;">
    
    <!-- Header của Chat -->
    <div style="background: linear-gradient(135deg, #e60000, #ff4d4d); color: white; padding: 12px 15px; display: flex; justify-content: space-between; align-items: center;">
        <div style="display: flex; align-items: center; gap: 10px;">
            <img src="uploads/iconai.png" style="width: 35px; height: 35px; border-radius: 50%; object-fit: cover; border: 2px solid white;">
            <div>
                <h6 style="margin: 0; font-weight: bold; font-size: 16px; letter-spacing: 0.5px;">Trợ lý AI MYSHOP</h6>
                <small style="font-size: 11px; opacity: 0.9;">🟢 Đang hoạt động</small>
            </div>
        </div>
        <!-- Nút Đóng cửa sổ (Dấu X) -->
        <button onclick="toggleAIChat()" style="background: none; border: none; color: white; font-size: 24px; cursor: pointer; line-height: 1; padding: 0;">&times;</button>
    </div>
    
    <!-- Khu vực nội dung chat -->
    <div id="ai-chat-content" style="flex: 1; padding: 15px; overflow-y: auto; background: #f4f6f9; display: flex; flex-direction: column; gap: 10px;">
        
        <!-- Tin nhắn chào mừng mặc định của Bot -->
        <div style="display: flex; gap: 10px; max-width: 85%;">
            <img src="uploads/iconai.png" style="width: 30px; height: 30px; border-radius: 50%; object-fit: cover;">
            <div style="background: white; padding: 12px; border-radius: 0 15px 15px 15px; border: 1px solid #e9ecef; box-shadow: 0 2px 5px rgba(0,0,0,0.02); font-size: 14px;">
                Dạ em chào Anh/Chị! Em là trợ lý ảo. Mời Anh/Chị chọn các gợi ý bên dưới hoặc nhập câu hỏi để em hỗ trợ nhé!
            </div>
        </div>

        <!-- Các nút gợi ý nhanh -->
        <div style="display: flex; flex-wrap: wrap; gap: 8px; margin-top: 5px; padding-left: 40px;">
            <button class="btn btn-sm btn-outline-danger" style="border-radius: 20px; font-size: 12px; font-weight: 500;" onclick="sendQuickReply('Sản phẩm giá rẻ')">🔥 Giá rẻ</button>
            <button class="btn btn-sm btn-outline-danger" style="border-radius: 20px; font-size: 12px; font-weight: 500;" onclick="sendQuickReply('Sản phẩm bán chạy')">⭐ Bán chạy</button>
            <button class="btn btn-sm btn-outline-danger" style="border-radius: 20px; font-size: 12px; font-weight: 500;" onclick="sendQuickReply('Xem khuyến mãi')">🎁 Khuyến mãi</button>
        </div>
    </div>

    <!-- Khu vực nhập tin nhắn -->
    <div style="padding: 12px; border-top: 1px solid #eee; background: white; display: flex; align-items: center; gap: 10px;">
        <input type="text" id="ai-chat-input" class="form-control" placeholder="Nhập câu hỏi..." style="border-radius: 20px; border: 1px solid #ccc; font-size: 14px; padding: 10px 15px;" onkeypress="if(event.key === 'Enter') handleSendMsg()">
        <button onclick="handleSendMsg()" class="btn btn-danger" style="border-radius: 50%; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; padding: 0;">
            <i class="fas fa-paper-plane"></i>
        </button>
    </div>
</div>

<!-- ========================================== -->
<!-- 3. JAVASCRIPT XỬ LÝ ĐÓNG/MỞ -->
<!-- ========================================== -->
<script>
// Hàm đóng/mở cửa sổ chat
function toggleAIChat() {
    const chatWindow = document.getElementById('ai-chat-window');
    const icon = document.getElementById('ai-chat-icon');
    
    if (chatWindow.style.display === 'none' || chatWindow.style.display === '') {
        // Mở chat
        chatWindow.style.display = 'flex';
        icon.style.transform = 'scale(0.8)'; // Thu nhỏ icon một chút khi mở
        icon.style.opacity = '0.5';
    } else {
        // Đóng chat
        chatWindow.style.display = 'none';
        icon.style.transform = 'scale(1)';   // Phục hồi kích thước icon
        icon.style.opacity = '1';
    }
}

// Các hàm tạm thời để hiển thị tin nhắn (sẽ kết nối Backend sau)
function sendQuickReply(text) {
    document.getElementById('ai-chat-input').value = text;
    handleSendMsg();
}

function handleSendMsg() {
    const input = document.getElementById('ai-chat-input');
    const msg = input.value.trim();
    if (msg === "") return;

    const chatContent = document.getElementById('ai-chat-content');

    // 1. In tin nhắn của khách hàng lên màn hình
    chatContent.innerHTML += `
        <div style="display: flex; justify-content: flex-end; margin-top: 10px;">
            <div style="background: #e60000; color: white; padding: 10px 15px; border-radius: 15px 15px 0 15px; font-size: 14px; max-width: 80%;">
                ${msg}
            </div>
        </div>
    `;
    
    // 2. Hiển thị hiệu ứng "Bot đang gõ..."
    const typingId = 'typing-' + Date.now();
    chatContent.innerHTML += `
        <div id="${typingId}" style="display: flex; gap: 10px; max-width: 85%; margin-top: 10px;">
            <img src="uploads/icon_ai.png" style="width: 30px; height: 30px; border-radius: 50%; object-fit: cover;">
            <div style="background: white; padding: 10px 15px; border-radius: 0 15px 15px 15px; border: 1px solid #e9ecef; font-style: italic; color: gray; font-size: 13px;">
                Đang tìm kiếm...
            </div>
        </div>
    `;
    chatContent.scrollTop = chatContent.scrollHeight; // Cuộn xuống cuối
    input.value = ""; // Xóa ô nhập

    // 3. Gửi AJAX xuống BotController
    fetch(`index.php?controller=bot&action=tu_van&q=${encodeURIComponent(msg)}`)
        .then(response => response.text())
        .then(htmlData => {
            // Xóa hiệu ứng "Đang tìm kiếm..."
            document.getElementById(typingId).remove();
            
            // In kết quả Bot trả về
            chatContent.innerHTML += `
                <div style="display: flex; gap: 10px; max-width: 85%; margin-top: 10px;">
                    <img src="uploads/iconai.png" style="width: 30px; height: 30px; border-radius: 50%; object-fit: cover;">
                    <div style="background: white; padding: 12px; border-radius: 0 15px 15px 15px; border: 1px solid #e9ecef; box-shadow: 0 2px 5px rgba(0,0,0,0.02); font-size: 14px; width: 100%;">
                        ${htmlData}
                    </div>
                </div>
            `;
            chatContent.scrollTop = chatContent.scrollHeight;
        })
        .catch(error => {
            document.getElementById(typingId).remove();
            chatContent.innerHTML += `<div class="text-danger small mt-2">Lỗi kết nối. Vui lòng thử lại!</div>`;
        });
}
</script>
</body>
</html>