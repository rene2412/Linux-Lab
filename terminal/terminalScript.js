const terminal = document.querySelector('.terminal');
const command_line = document.querySelector('.command-line');
const command = document.querySelector('.input');
const history = document.querySelector('.history');
let currentDirectory = "/"; // Track current directory in JS

terminal.addEventListener('click',()=>{
   command_line.focus();
})

const keyHandler = {
    'Backspace': (e)=>backspace(e),
    'Meta': ()=> specialKeys(),
    'Enter': ()=> enter(),

    'ArrowLeft': (e)=> caretMovePos(e),
    'ArrowRight': (e)=> caretMovePos(e),

    'ArrowUp': ()=> arrowUp(),
    'ArrowDown': ()=> arrowDown(),
}

function specialKeys(){
    console.log(`special key used`);
    return;
}
function enter(){
    let actualPrevCommand = temp;
    let commandToSend = temp.trim(); // Make sure we send trimmed command
  //  console.log("Sending command: ", commandToSend);
    if (commandToSend === commandHistory.at(commandHistory.length-2) || commandToSend === ""){
        commandHistory[commandHistoryIndex] = commandHistoryClean[commandHistoryIndex];
        temp = "";
        commandHistoryIndex = commandHistory.length-1;
    } else {
        commandHistoryClean[commandHistoryClean.length-1] = commandToSend;
        commandHistoryClean.push("");
        commandHistory[commandHistory.length-1] = commandToSend;
        commandHistory.push("");
        commandHistory[commandHistoryIndex] = commandHistoryClean[commandHistoryIndex];
        temp = "";
        commandHistoryIndex = commandHistory.length-1;
    }
    // Send the command to the PHP backend "the post request"
    fetch('../api_commands.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `command=${encodeURIComponent(commandToSend)}`,
    })
    .then(response => response.json())
    .then(data => {
        console.log("Server response:", data);
        output(actualPrevCommand, data.output);
        updatePrompt(data.currentDirectory);
        temp = "";
        caretPos = 0;
        renderCaret();
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

function output(command, result) {
    // make this is result === clear
    if(command == "clear"){clear(); return;}
    const prevCommand = document.createElement("div");
    const prevOutput = document.createElement("div")

    prevCommand.classList.toggle("history-command");
    prevOutput.classList.toggle("history-output");

    const prompt = `<span class="prompt">example_user@Linux-Lab:${currentDirectory}$</span>`;

    const actualPrevCommand = command.replace(/ /g, '&nbsp')

    prevCommand.innerHTML= prompt + `${actualPrevCommand}`;
    prevOutput.innerText = result;

    history.appendChild(prevCommand);
    // if blank no newline
    if(command){history.appendChild(prevOutput);}
    terminal.scrollTop = terminal.scrollHeight;
}

function clear() {history.replaceChildren();}


function updatePrompt(newDirectory) {
    currentDirectory = newDirectory; // Update JS directory
    // Update visible prompt in command line
    document.querySelector('.command-line .prompt').textContent = 
        `example_user@Linux-Lab:${currentDirectory}$`;
}

function arrowUp(){
    if(commandHistory.length==0 || commandHistoryIndex==0)return;
    commandHistoryIndex-=1;
    temp = commandHistory.at(commandHistoryIndex);
    caretPos = temp.length;
}

function arrowDown(){
    if(commandHistory.length-1 === commandHistoryIndex)return;
    commandHistoryIndex+=1;
    temp = commandHistory.at(commandHistoryIndex);
    caretPos = temp.length;
}

function caretMovePos(e){
    if (e.key === `ArrowLeft`){
        if(caretPos === 0)return;
        caretPos-=1;
    }
    else{
        if(caretPos>=temp.length)return;
        caretPos+=1;
    }

}
function backspace(e){
    // option+del 
    if(e.metaKey){temp = ""; caretPos=0; 
        commandHistory[commandHistoryIndex] = temp;
        return;
    }
    // meta+del 
    if(e.ctrlKey){temp = ""; caretPos=temp.length;
        commandHistory[commandHistoryIndex] = temp;
        return;
    }
    // temp = temp.slice(0,temp.length - 1);
    inputLeft = temp.slice(0,caretPos-1);
    inputRight= temp.slice(caretPos,temp.length);
    temp = inputLeft+inputRight;
    commandHistory[commandHistoryIndex] = temp;
    caretPos-=1;
    return;
}

function ctrtDel(){
    temp = "ctrlDel";
    return;
}

function optDel(){
    temp ="";
    return;
}

input = "";
temp = input; 
char = " ";
cursor = `<span class="caret-block">${char}</span>`;
caretPos= 0;

inputLeft = "";
inputRight= "";

commandHistoryIndex = 3;

const commandHistory = [
    "ls | xargs code",
    "hello world",
    "this is test",
    "",
];
const commandHistoryClean= [
    "ls | xargs code",
    "hello world",
    "this is test",
    "",
];

command_line.addEventListener( "keydown",(e)=>{
    e.preventDefault()
    terminal.scrollTop = terminal.scrollHeight - terminal.clientHeight;
    const handler = keyHandler[e.key];
    if(handler) handler(e);
    else if(e.key.length==1 &&!e.altKey){
        // temp = temp + e.key;
        inputText(e.key);
        caretPos+=1 ;
    }
    renderCaret();
});

function inputText(value){
    inputLeft = temp.slice(0,caretPos);
    inputRight= temp.slice(caretPos,temp.length);
    temp = inputLeft + value + inputRight;
    commandHistory[commandHistoryIndex] = temp;
}


function renderCaret(){
    if(temp === ""){
        caretPos = 0;
        char = " ";
        cursor = `<span class="caret-block">${char}</span>`;
        command.innerHTML= temp+cursor;
    }
    else{
        if(temp.length === caretPos)char = " ";
            else {char = temp.charAt(caretPos);}
            console.log(`tempLength:${temp.length}\ncaretPos: ${caretPos}`)
            cursor = `<span class="caret-block">${char}</span>`;
    }
    inputLeft = temp.slice(0,caretPos);
    inputRight= temp.slice(caretPos+1,temp.length);

    
    const displayLeft = inputLeft.replace(/ /g, '&nbsp;');
    const displayRight = inputRight.replace(/ /g, '&nbsp;');
    
    cursor = `<span class="caret-block">${char}</span>`;
    command.innerHTML= displayLeft+cursor+displayRight;

}