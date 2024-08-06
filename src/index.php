<?php

require("./dbconnect.php");


$sql = "SELECT name, date_of_birth, class_name, parent_name, parent_contact, status
    FROM children";
$result = pg_query($sql);
$rows = pg_num_rows($result);
$children = array();
if($rows > 0) {
    for($i=0; $i<$rows; $i++) {
        $this_name = pg_fetch_result($result, $i, 0);
        $this_date_of_birth = pg_fetch_result($result, $i, 1);
        $this_class_name = pg_fetch_result($result, $i, 2);
        $this_parent_name = pg_fetch_result($result, $i, 3);
        $this_parent_contact = pg_fetch_result($result, $i, 4);
        $this_status = pg_fetch_result($result, $i, 5);

        $children[$i]["name"] = $this_name;
        $children[$i]["age"] = $this_date_of_birth;
        $children[$i]["class"] = $this_class_name;
        $children[$i]["parent"] = $this_parent_name;
        $children[$i]["status"] = $this_status;
    }
}
$children = json_encode($children);
pg_free_result($result);

?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>園児情報一覧</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Arial, sans-serif;
            background-color: #f0f4f8;
            margin: 0;
            padding: 20px;
            color: #333;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }
        h1 {
            color: #4a6fa5;
            text-align: center;
            margin-bottom: 30px;
        }
        .search-bar {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        .search-bar input {
            flex-grow: 1;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
        }
        .search-bar button {
            background-color: #4a6fa5;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            margin-left: 10px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .search-bar button:hover {
            background-color: #3a5a8c;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            text-align: left;
            padding: 12px;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #4a6fa5;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        tr:hover {
            background-color: #e8eef5;
        }
        .status {
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.8em;
            font-weight: bold;
        }
        .status-present {
            background-color: #28a745;
            color: white;
        }
        .status-absent {
            background-color: #dc3545;
            color: white;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>園児情報一覧</h1>
        <div class="search-bar">
            <input type="text" id="searchInput" placeholder="園児名で検索...">
            <button onclick="searchStudents()">検索</button>
        </div>
        <table id="studentTable">
            <thead>
                <tr>
                    <th>名前</th>
                    <th>年齢</th>
                    <th>クラス</th>
                    <th>保護者名</th>
                    <th>連絡先</th>
                    <th>出欠状況</th>
                </tr>
            </thead>
            <tbody>
                <!-- JavaScriptで動的に生成される園児データがここに入ります -->
            </tbody>
        </table>
    </div>

    <script>
        // サンプルデータ
        const students = <?=$children?>

        // テーブルにデータを表示する関数
        function displayStudents(studentsToShow) {
            const tableBody = document.querySelector("#studentTable tbody");
            tableBody.innerHTML = "";
            studentsToShow.forEach(student => {
                const row = tableBody.insertRow();
                row.insertCell(0).textContent = student.name;
                row.insertCell(1).textContent = student.age;
                row.insertCell(2).textContent = student.class;
                row.insertCell(3).textContent = student.parent;
                row.insertCell(4).textContent = student.contact;
                const statusCell = row.insertCell(5);
                const statusSpan = document.createElement("span");
                statusSpan.textContent = student.status === "present" ? "出席" : "欠席";
                statusSpan.className = `status status-${student.status}`;
                statusCell.appendChild(statusSpan);
            });
        }

        // 検索機能
        function searchStudents() {
            const searchTerm = document.getElementById("searchInput").value.toLowerCase();
            const filteredStudents = students.filter(student => 
                student.name.toLowerCase().includes(searchTerm)
            );
            displayStudents(filteredStudents);
        }

        // 初期表示
        displayStudents(students);
    </script>
</body>
</html>

<?php
pg_close();
?>