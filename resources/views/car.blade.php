<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Management</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f7fc;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        h1 {
            color: #4CAF50;
            margin-top: 20px;
        }

        #cars {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
            margin-top: 20px;
            width: 80%;
        }

        .car {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            width: 250px;
            transition: transform 0.2s ease-in-out;
        }

        .car:hover {
            transform: scale(1.05);
        }

        .car h3 {
            margin: 0;
            color: #333;
            font-size: 1.5em;
        }

        .car p {
            color: #555;
            margin: 5px 0;
        }

        .car button {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 8px 12px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            margin-top: 10px;
        }

        .car button:hover {
            background-color: #45a049;
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 350px;
            margin-top: 30px;
        }

        form input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        form button {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 5px;
            width: 100%;
            cursor: pointer;
            font-size: 1.1em;
            transition: background-color 0.3s ease;
        }

        form button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <h1>Car Management</h1>

    <div id="cars">
        <!-- Cars will be loaded here -->
    </div>

    <h2>Add New Car</h2>
    <form id="carForm">
        <input type="text" id="brand" placeholder="Brand" required>
        <input type="text" id="model" placeholder="Model" required>
        <input type="number" id="year" placeholder="Year" required>
        <input type="number" id="price" placeholder="Price" required>
        <input type="text" id="color" placeholder="Color" required>
        <button type="submit">Add Car</button>
    </form>

    <script>
        // Load cars on page load
        fetch('/api/cars')
            .then(response => response.json())
            .then(data => {
                const carsContainer = document.getElementById('cars');
                data.forEach(car => {
                    carsContainer.innerHTML += `
                        <div class="car" data-id="${car.id}">
                            <h3>${car.brand} ${car.model} (${car.year})</h3>
                            <p><strong>Price:</strong> $${car.price}</p>
                            <p><strong>Color:</strong> ${car.color}</p>
                            <button onclick="editCar(${car.id})">Edit</button>
                            <button onclick="deleteCar(${car.id})">Delete</button>
                        </div>
                    `;
                });
            });

        // Add new car
        document.getElementById('carForm').addEventListener('submit', function (e) {
            e.preventDefault();
            const brand = document.getElementById('brand').value;
            const model = document.getElementById('model').value;
            const year = document.getElementById('year').value;
            const price = document.getElementById('price').value;
            const color = document.getElementById('color').value;

            fetch('/api/cars', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ brand, model, year, price, color })
            })
            .then(response => response.json())
            .then(car => {
                const carsContainer = document.getElementById('cars');
                carsContainer.innerHTML += `
                    <div class="car" data-id="${car.id}">
                        <h3>${car.brand} ${car.model} (${car.year})</h3>
                        <p><strong>Price:</strong> $${car.price}</p>
                        <p><strong>Color:</strong> ${car.color}</p>
                        <button onclick="editCar(${car.id})">Edit</button>
                        <button onclick="deleteCar(${car.id})">Delete</button>
                    </div>
                `;
                document.getElementById('carForm').reset();
            });
        });

        // Delete car
        function deleteCar(id) {
            fetch(`/api/cars/${id}`, { method: 'DELETE' })
                .then(() => {
                    document.querySelector(`.car[data-id="${id}"]`).remove();
                });
        }

        // Edit car
        function editCar(id) {
            alert('Edit car functionality to be implemented');
        }
    </script>
</body>
</html>

