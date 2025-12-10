const chatbotForm = document.getElementById('chatbotForm');
const messageChat = document.getElementById('messageChat');
const chatbotList = document.querySelector('.chatbot-list .message-list');

chatbotForm.addEventListener('keypress', function(event) {
    // event.preventDefault();

    if(event.key === 'Enter') {
        let message = messageChat.value.trim();  
        if (message === '') return;

        appendMessage('user', message);
        setTimeout(() => {
            messageChat.value = '';
        }, 50);
        sendMessageToServer(message);
    }
});


function initChatbotMessages() {
    fetch("./chatbot/send", {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json', 
            'X-CSRF-TOKEN': chatbotForm.querySelector('input[name="_token"]').value
        }
    })
    .then(response => response.json())  
    .then(data => {
        if (data.messages && data.messages.length > 0) {
            data.messages.forEach(msg => {
                appendMessage(msg.sender, msg.message);
            });
        }
    })
    .catch(error => {
        console.error('Error:', error);
    }); 
}

initChatbotMessages();

function appendMessage(sender, message) {
    // const messageDiv = document.createElement('div');
    // messageDiv.classList.add('message-bot', sender);

    // messageDiv.textContent = message;
    // chatbotList.appendChild(messageDiv);

    let html = `
    <div class="message-${sender}">
        <div class="message-${sender}-content">
        <p class="mb-0 text">${message}</p>
        </div>
    </div>
    `;
    chatbotList.innerHTML += html;
    
    chatbotList.scrollTop = chatbotList.scrollHeight;
}

function sendMessageToServer(message) {
    // loading typing reply
    chatbotList.innerHTML += `
        <div class="message-bot loading">
            <div class="message-bot-content">
            <img src="https://media.tenor.com/cnb4G0hjQmwAAAAj/writing-loading.gif" alt="Loading" style="width:20px;"/>
            </div>
        </div>
    `;
    
    // get element of loading message
    let loadingMessage = chatbotList.querySelector('.message-bot.loading');

    fetch("./chatbot/send", {
        method: 'POST', 
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': chatbotForm.querySelector('input[name="_token"]').value
        },  
        body: JSON.stringify({ messageChat: message })
    })
    .then(response => response.json())
    .then(data => {
        if (data.reply) {
            loadingMessage.remove();
            appendMessage('bot', data.reply);
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

// function sendMessageToServer(message) {
//     axios.post('/chatbot/send', {
//     messageChat: message
//   })
//   .then(function (response) {
//     console.log(response);
//     if (data.reply) {
//             appendMessage('bot', data.reply);
//         }
//   })
//   .catch(function (error) {
//     console.log(error);
//   });
// }