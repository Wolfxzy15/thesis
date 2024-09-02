<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Family Registration Form</title>
    <style>
        body {
            margin: 20px;
            font-family: Arial, sans-serif;
        }

        .form-container {
            padding: 20px;
            border: 1px solid dodgerblue;
            border-radius: 5px;
            margin-bottom: 20px;
            display: flex;
            flex-direction: row;
            gap: 20px;
            align-items: flex-start;
            flex-wrap: wrap;
        }

        .form-container div {
            flex: 1;
            min-width: 200px;
        }

        label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="number"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        button {
            margin: 10px 0;
            padding: 10px 20px;
            background-color: darkblue;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: blue;
        }

    </style>
</head>
<body>
    <div>
        <h1>Family Registration Form</h1>
        <button onclick="addForm()">Add Family Member</button>
        <form id="familyForm" method="post">
            <button type="submit" form="familyForm" name="submit">Submit All</button>
        </form>
    </div>

    <script>
        let formCount = 0;

        function addForm() {
            formCount++;
            const formContainer = document.createElement('div');
            formContainer.className = 'form-container';
            formContainer.innerHTML = `
                <div>
                    <h3>Family Member ${formCount}</h3>
                    <label for="lastName${formCount}">Last Name:</label>
                    <input type="text" id="lastName${formCount}" name="lastName[]">
                    
                    <label for="firstName${formCount}">First Name:</label>
                    <input type="text" id="firstName${formCount}" name="firstName[]">
                    
                    <label for="middleName${formCount}">Middle Name:</label>
                    <input type="text" id="middleName${formCount}" name="middleName[]">
                </div>
                <div>
                    <label for="age${formCount}">Age:</label>
                    <input type="number" id="age${formCount}" name="age[]">
                    
                    <label for="relationship${formCount}">Relationship:</label>
                    <input type="text" id="relationship${formCount}" name="relationship[]">
                </div>
            `;
            document.getElementById('familyForm').appendChild(formContainer);
        }
    </script>
</body>
</html>
