<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Server status</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
        }
        h1 {
            text-align: center;
            color: #333;
        }
        table {
            width: 70%;
            margin: 20px auto;
            border-collapse: collapse;
            background-color: #fff;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        font {
            color: #FF0000;
        }
        .total-users {
            text-align: center;
            margin-top: 20px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <h1>Server status</h1>
   

    <script>

const servers = {
  'TH-01': 'http://116.206.125.12:82/server/online',
  'TH-02': 'http://116.206.125.13:82/server/online',
  'TH-03': 'http://116.206.125.14:82/server/online',
  'TH-04': 'http://116.206.125.15:82/server/online',
  'TH-05': 'http://103.114.203.93:81/server/online',
  'TH-06': 'http://103.114.202.148:82/server/online',
  'TH-07': 'http://103.114.202.146:82/server/online',
};

let totalOnlineCount = 0;

const table = document.createElement('table');
const headerRow = document.createElement('tr');
const statusHeader = document.createElement('th');
statusHeader.textContent = 'status';
const serverHeader = document.createElement('th');
serverHeader.textContent = 'Server';
headerRow.appendChild(statusHeader);
headerRow.appendChild(serverHeader);
table.appendChild(headerRow);

for (const [serverName, serverURL] of Object.entries(servers)) {
  fetch(serverURL)
    .then((response) => {
      if (!response.ok) {
        throw new Error('Failed to fetch');
      }
      return response.text();
    })
    .then((onlineCount) => {
      onlineCount = parseInt(onlineCount);
      const row = document.createElement('tr');
      const statusCell = document.createElement('td');
      statusCell.textContent = serverName;
      const serverCell = document.createElement('td');
      serverCell.innerHTML = `current online <font color='#FF0000'>${onlineCount}</font> person`;
      row.appendChild(statusCell);
      row.appendChild(serverCell);
      table.appendChild(row);
      totalOnlineCount += onlineCount;
    })
    .catch((error) => {
      const row = document.createElement('tr');
      const statusCell = document.createElement('td');
      statusCell.textContent = serverName;
      const serverCell = document.createElement('td');
      serverCell.textContent = `Unable to connect to server - Error: ${error.message}`;
      row.appendChild(statusCell);
      row.appendChild(serverCell);
      table.appendChild(row);
    });
}

document.body.appendChild(table);

// Check if loading takes too long and refresh the page if necessary
setTimeout(() => {
  if (navigator.connection.downlink === 0) {
    location.reload();
  }
}, 30000); // Refresh after 30 seconds

const totalUsersDiv = document.createElement('div');
totalUsersDiv.className = 'total-users';
totalUsersDiv.innerHTML = `All users on all servers: <font color='#3358FF'>${totalOnlineCount}</font> person`;
document.body.appendChild(totalUsersDiv);

    </script>

</body>

</html>
