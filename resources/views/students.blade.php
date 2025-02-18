<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Management</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px; }
        .container { max-width: 800px; margin: auto; background: white; padding: 20px; border-radius: 10px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); }
        .car { margin-bottom: 10px; padding: 10px; border: 1px solid #ccc; border-radius: 5px; background: #fff; }
        .car h3 { margin: 0; color: #333; }
        .car p { margin: 5px 0; color: #555; }
        button { padding: 5px 10px; margin-right: 5px; cursor: pointer; }
        .delete-btn { background-color: red; color: white; border: none; border-radius: 3px; }
        .edit-btn { background-color: blue; color: white; border: none; border-radius: 3px; }
    </style>
</head>
<body>
    <div class="container">
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
    </div>

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
                            <p>Price: $${car.price}</p>
                            <p>Color: ${car.color}</p>
                            <button class="edit-btn" onclick="editCar(${car.id})">Edit</button>
                            <button class="delete-btn" onclick="deleteCar(${car.id})">Delete</button>
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
                        <p>Price: $${car.price}</p>
                        <p>Color: ${car.color}</p>
                        <button class="edit-btn" onclick="editCar(${car.id})">Edit</button>
                        <button class="delete-btn" onclick="deleteCar(${car.id})">Delete</button>
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
    </script>
</body>
</html>

