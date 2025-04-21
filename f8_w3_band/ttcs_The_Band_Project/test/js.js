const apiKey = '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';
const chatEndpoint = 'https://api.openai.com/v1/chat';

// get DOM elements
const chatForm = document.querySelector('#chat-form');
const chatInput = document.querySelector('#chat-input');
const chatOutput = document.querySelector('#chat-output');

// add event listener to form
chatForm.addEventListener('submit', async (event) => {
  event.preventDefault();
  
  // get user input
  const userInput = chatInput.value;
  
  // add user message to output
  chatOutput.innerHTML += `
    <div class="message user-message">
      <p>${userInput}</p>
    </div>
  `;
  
  // clear input field
  chatInput.value = '';
  
  // make request to OpenAI API
  const response = await fetch(chatEndpoint, {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'Authorization': `Bearer ${apiKey}`
    },
    body: JSON.stringify({
      model: 'davinci',
      prompt: `${userInput}\nAI:`,
      max_tokens: 150,
      temperature: 0.7,
      n: 1,
      stop: 'AI:'
    })
  });
  
  const {choices} = await response.json();
  const aiResponse = choices[0].text.trim();
  
  // add AI message to output
  chatOutput.innerHTML += `
    <div class="message ai-message">
      <p>${aiResponse}</p>
    </div>
  `;
});

