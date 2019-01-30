import * as io from "socket.io-client";
const socket = io(SERVICE_URL || window.location.host);
const $tbody = document.getElementById('logs-tbody');

socket.on('message', console.info);
socket.on('log', ({ message, level, timestamp }) => {
    $tbody.insertAdjacentHTML(
        "afterbegin",
        `<tr class="${level === 'error' ? 'uk-background-error' : (level === 'warning' ? 'uk-background-warning' : '')}">
                    <td>${level}</td>
                    <td>${new Date(timestamp).toLocaleTimeString()}</td>
                    <td>${message}</td>
                </tr>`
    );
});
