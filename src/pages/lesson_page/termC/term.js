export default class VanillaTerminal {
  constructor(options = {}) {
    // Default options
    this.options = {
      apiEndpoint: '../api_commands.php',
      username: 'example_user',
      hostname: 'LinuxLab',
      ...options
    };

    // Initial state
    this.currentDirectory = options.initialDirectory || '/';
    this.temp = '';
    this.caretPos = 0;
    this.inputLeft = '';
    this.inputRight = '';
    // history index at 1 is the latest
    // edge case: cannot be empty array
    this.commandHistoryIndex = 1;
    this.commandHistory = ['',''];
    this.commandHistoryClean = ['',''];

    // DOM elements (will be set in mount())
    this.terminal = null;
    this.commandLine = null;
    this.command = null;
    this.history = null;

    // Key handlers
    this.keyHandler = {
      'Backspace': (e) => this.backspace(e),
      'Meta': () => this.specialKeys(),
      'Enter': () => this.enter(),
      'ArrowLeft': (e) => this.caretMovePos(e),
      'ArrowRight': (e) => this.caretMovePos(e),
      'ArrowUp': () => this.arrowUp(),
      'ArrowDown': () => this.arrowDown(),
    };

    // Bound methods to maintain 'this' context
    this.handleKeyDown = this.handleKeyDown.bind(this);
    this.handleTerminalClick = this.handleTerminalClick.bind(this);
  }

  // Mount the terminal to a container element
  mount(containerSelector) {
    const container = document.querySelector(containerSelector);
    if (!container) {
      console.error(`Container not found: ${containerSelector}`);
      return false;
    }

    // Create terminal HTML structure
    container.innerHTML = `
      <div class="terminal">
        <div class="history"></div>
        <div class="command-line" contenteditable="plaintext-only" autofocus="true"><span class="prompt">${this.options.username}@${this.options.hostname}:${this.currentDirectory}$</span><span class="input"><span class="caret-block"> </span></span>
        </div>
      </div>
    `;

    // Set DOM references
    this.terminal = container.querySelector('.terminal');
    this.commandLine = container.querySelector('.command-line');
    this.command = container.querySelector('.input');
    this.history = container.querySelector('.history');

    // Add event listeners
    this.terminal.addEventListener('click', this.handleTerminalClick);
    this.commandLine.addEventListener('keydown', this.handleKeyDown);

    return true;
  }

  // Remove the terminal and clean up event listeners
  unmount() {
    if (this.terminal) {
      this.terminal.removeEventListener('click', this.handleTerminalClick);
      this.commandLine.removeEventListener('keydown', this.handleKeyDown);
      this.terminal.parentNode.removeChild(this.terminal);
      
      // Reset DOM references
      this.terminal = null;
      this.commandLine = null;
      this.command = null;
      this.history = null;
    }
  }

  handleTerminalClick() {
    this.commandLine.focus();
  }

  handleKeyDown(e) {
    e.preventDefault();
    this.terminal.scrollTop = this.terminal.scrollHeight - this.terminal.clientHeight;
    
    const handler = this.keyHandler[e.key];
    if (handler) {
      handler(e);
    } else if (e.key.length === 1 && !e.altKey) {
      this.inputText(e.key);
      this.caretPos += 1;
    }
    
    this.renderCaret();
  }

  specialKeys() {
    console.log(`special key used`);
    return;
  }

  enter() {
    let actualPrevCommand = this.temp;
    let commandToSend = this.temp.trim();

    if (commandToSend === this.commandHistory.at(this.commandHistory.length - 2) || commandToSend === "") {
      this.commandHistory[this.commandHistoryIndex] = this.commandHistoryClean[this.commandHistoryIndex];
      this.temp = "";
      this.commandHistoryIndex = this.commandHistory.length - 1;
    } else {
      this.commandHistoryClean[this.commandHistoryClean.length - 1] = commandToSend;
      this.commandHistoryClean.push("");
      this.commandHistory[this.commandHistory.length - 1] = commandToSend;
      this.commandHistory.push("");
      this.commandHistory[this.commandHistoryIndex] = this.commandHistoryClean[this.commandHistoryIndex];
      this.temp = "";
      this.commandHistoryIndex = this.commandHistory.length - 1;
    }

    // Send the command to the backend API
    fetch(this.options.apiEndpoint, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded',
      },
      body: `command=${encodeURIComponent(commandToSend)}`,
    })
    .then(response => response.json())
    
    .then(data => {
      console.log(data);
      this.output(actualPrevCommand, data.output);
      this.updatePrompt(data.currentDirectory);

      if(data.commandSuccess) {
        const successEvent = new CustomEvent('command-success', {
          // detail object 
          detail:{
            command: commandToSend,
            output: data.output
          }
        });
        document.dispatchEvent(successEvent);
      }
      this.temp = "";
      this.caretPos = 0;
      this.renderCaret();
    })
    .catch(error => {
      console.error('Error:', error);
      // Handle error gracefully - maybe output to terminal
      this.output(actualPrevCommand, `Error: Could not process command`);
    });
  }

  output(command, result) {
    // Handle clear command
    if (command === "clear") {
      this.clear();
      return;
    }

    const prevCommand = document.createElement("div");
    const prevOutput = document.createElement("div");

    prevCommand.classList.toggle("history-command");
    prevOutput.classList.toggle("history-output");

    const prompt = `<span class="prompt">${this.options.username}@${this.options.hostname}:${this.currentDirectory}$</span>`;
    const actualPrevCommand = command.replace(/ /g, '&nbsp');

    prevCommand.innerHTML = prompt + `${actualPrevCommand}`;
    prevOutput.innerText = result;

    this.history.appendChild(prevCommand);
    
    // Only append output if there's a command
    if (command) {
      this.history.appendChild(prevOutput);
    }
    
    this.terminal.scrollTop = this.terminal.scrollHeight;
  }

  clear() {
    this.history.replaceChildren();
  }

  updatePrompt(newDirectory) {
    this.currentDirectory = newDirectory;
    
    // Update visible prompt in command line
    if (this.commandLine) {
      const promptElement = this.commandLine.querySelector('.prompt');
      if (promptElement) {
        promptElement.textContent = `${this.options.username}@${this.options.hostname}:${this.currentDirectory}$`;
      }
    }
  }

  arrowUp() {
    if (this.commandHistory.length === 0 || this.commandHistoryIndex === 0) return;
    this.commandHistoryIndex -= 1;
    this.temp = this.commandHistory.at(this.commandHistoryIndex);
    this.caretPos = this.temp.length;
  }

  arrowDown() {
    if (this.commandHistory.length - 1 === this.commandHistoryIndex) return;
    this.commandHistoryIndex += 1;
    this.temp = this.commandHistory.at(this.commandHistoryIndex);
    this.caretPos = this.temp.length;
  }

  caretMovePos(e) {
    if (e.key === `ArrowLeft`) {
      if (this.caretPos === 0) return;
      this.caretPos -= 1;
    } else {
      if (this.caretPos >= this.temp.length) return;
      this.caretPos += 1;
    }
  }

  backspace(e) {
    // option+del (clear command)
    if (e.metaKey) {
      this.temp = "";
      this.caretPos = 0;
      this.commandHistory[this.commandHistoryIndex] = this.temp;
      return;
    }
    
    // meta+del (clear command)
    if (e.ctrlKey) {
      this.temp = "";
      this.caretPos = this.temp.length;
      this.commandHistory[this.commandHistoryIndex] = this.temp;
      return;
    }
    
    if (this.caretPos > 0) {
      this.inputLeft = this.temp.slice(0, this.caretPos - 1);
      this.inputRight = this.temp.slice(this.caretPos, this.temp.length);
      this.temp = this.inputLeft + this.inputRight;
      this.commandHistory[this.commandHistoryIndex] = this.temp;
      this.caretPos -= 1;
    }
  }

  inputText(value) {
    this.inputLeft = this.temp.slice(0, this.caretPos);
    this.inputRight = this.temp.slice(this.caretPos, this.temp.length);
    this.temp = this.inputLeft + value + this.inputRight;
    this.commandHistory[this.commandHistoryIndex] = this.temp;
  }

  renderCaret() {
    let char, cursor;
    
    if (this.temp === "") {
      this.caretPos = 0;
      char = " ";
      cursor = `<span class="caret-block">${char}</span>`;
      this.command.innerHTML = this.temp + cursor;
    } else {
      if (this.temp.length === this.caretPos) {
        char = " ";
      } else {
        char = this.temp.charAt(this.caretPos);
      }
      
      this.inputLeft = this.temp.slice(0, this.caretPos);
      this.inputRight = this.temp.slice(this.caretPos + 1, this.temp.length);

      const displayLeft = this.inputLeft.replace(/ /g, '&nbsp;');
      const displayRight = this.inputRight.replace(/ /g, '&nbsp;');
      
      cursor = `<span class="caret-block">${char}</span>`;
      this.command.innerHTML = displayLeft + cursor + displayRight;
    }
  }

  // Public methods for customization and extension
  setCurrentDirectory(directory) {
    this.updatePrompt(directory);
  }

  setCommandHistory(history) {
    this.commandHistory = [...history, ''];
    this.commandHistoryClean = [...history, ''];
    this.commandHistoryIndex = this.commandHistory.length - 1;
  }

  // Method to manually add output to the terminal (for custom commands or welcome message)
  addOutput(text) {
    const outputDiv = document.createElement("div");
    outputDiv.classList.add("history-output");
    outputDiv.innerText = text;
    this.history.appendChild(outputDiv);
    this.terminal.scrollTop = this.terminal.scrollHeight;
  }
}
