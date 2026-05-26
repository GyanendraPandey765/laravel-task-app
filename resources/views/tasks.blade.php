<!DOCTYPE html>
<html>
<head>
    <title>Task App</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        body { font-family: Arial; padding: 20px; }
        .done { text-decoration: line-through; color: gray; }
        .msg { padding: 10px; margin: 10px 0; display:none; }
        .success { background: #d4edda; }
        .error { background: #f8d7da; }
        button { margin-left: 10px; }
    </style>
</head>
<body>

<h2>Task Manager</h2>

<div id="msg" class="msg"></div>

<input type="text" id="taskInput" placeholder="Enter task">
<button onclick="addTask()">Add</button>

<hr>

<ul id="taskList"></ul>

<script>
const api = "/api/tasks";
const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

function showMessage(text, type='success') {
    const msg = document.getElementById('msg');
    msg.innerText = text;
    msg.className = `msg ${type}`;
    msg.style.display = 'block';
    setTimeout(() => msg.style.display = 'none', 2000);
}

// Load tasks
async function loadTasks() {
    const res = await fetch(api);
    const data = await res.json();

    const list = document.getElementById('taskList');
    list.innerHTML = '';

    data.forEach(task => {
        list.innerHTML += `
            <li class="${task.is_done ? 'done' : ''}">
                ${task.title}
                <button onclick="toggleTask(${task.id})">
                    ${task.is_done ? 'Undo' : 'Done'}
                </button>
            </li>
        `;
    });
}

// Add task
async function addTask() {
    const title = document.getElementById('taskInput').value;

    const res = await fetch(api, {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": token,
            "Accept": "application/json"
        },
        body: JSON.stringify({ title })
    });

    const data = await res.json();

    if (res.ok) {
        showMessage(data.message, 'success');
        document.getElementById('taskInput').value = '';
        loadTasks();
    } else {
        showMessage("Failed to add task", 'error');
    }
}

// Toggle task
async function toggleTask(id) {
    const res = await fetch(`${api}/${id}/toggle`, {
        method: "PATCH",
        headers: {
            "X-CSRF-TOKEN": token,
            "Accept": "application/json"
        }
    });

    const data = await res.json();

    if (res.ok) {
        showMessage(data.message, 'success');
        loadTasks();
    } else {
        showMessage("Failed to update task", 'error');
    }
}

loadTasks();
</script>

</body>
</html>