document.addEventListener("DOMContentLoaded", function() {
    const tableBody = document.querySelector("#soilTable tbody");

    function deleteRow(row) {
        const id = row.dataset.rowId;

        fetch(`delete.php?id=${id}`, { method: 'GET' })
            .then(response => response.text())
            .then(data => {
                console.log(data);
                row.remove();
                resetNumbering();
            })
            .catch(error => console.error('Error:', error));
    }

    function updateRow(row) {
        const id = row.dataset.rowId;
        const cells = row.cells;
        const location = cells[1].textContent;
        const nutrientName = cells[2].textContent;
        const nutrientValue = cells[3].textContent;

        fetch(`update.php?id=${id}&location=${location}&nutrient_name=${nutrientName}&nutrient_value=${nutrientValue}`, { method: 'GET' })
            .then(response => response.text())
            .then(data => console.log(data))
            .catch(error => console.error('Error:', error));
    }

    tableBody.addEventListener("click", function(event) {
        const target = event.target;
        if (target.classList.contains("delete-btn")) {
            const row = target.closest("tr");
            deleteRow(row);
        } else if (target.classList.contains("edit-btn")) {
            const row = target.closest("tr");
            allowEditing(row);
        }
    });

    function allowEditing(row) {
        const cells = row.cells;
        for (let i = 1; i < cells.length - 1; i++) { // Skip ID and action cells
            const cell = cells[i];
            const oldValue = cell.textContent;

            // Check if it's the "nutrient_value" cell and set input type to "number"
            if (i === 3) {
                cell.innerHTML = `<input type="number" step="any" value="${oldValue}" />`;
            } else {
                cell.innerHTML = `<input type="text" value="${oldValue}" />`;
            }

            // Add event listener for Enter key
            cell.querySelector("input").addEventListener("keydown", function(event) {
                if (event.key === "Enter") {
                    saveRow(row);
                }
            });
        }

        // Replace Edit button with Save button
        const actionCell = cells[cells.length - 1];
        actionCell.innerHTML = `<button class="save-btn">Save</button>`;

        // Add event listener for the Save button
        actionCell.querySelector(".save-btn").addEventListener("click", function() {
            saveRow(row);
        });
    }

    function saveRow(row) {
        const cells = row.cells;
        const newLocation = cells[1].querySelector("input").value;
        const newNutrientName = cells[2].querySelector("input").value;
        const newNutrientValue = cells[3].querySelector("input").value;

        // Update the row with new values
        updateRowWithData(row, newLocation, newNutrientName, newNutrientValue);
    }

    function updateRowWithData(row, newLocation, newNutrientName, newNutrientValue) {
        const id = row.dataset.rowId;

        fetch(`update.php?id=${id}&location=${newLocation}&nutrient_name=${newNutrientName}&nutrient_value=${newNutrientValue}`, { method: 'GET' })
            .then(response => response.text())
            .then(data => {
                console.log(data);
                // Update the table cell values with new data
                row.cells[1].textContent = newLocation;
                row.cells[2].textContent = newNutrientName;
                row.cells[3].textContent = newNutrientValue;
                // Replace Save button with Edit button
                row.cells[row.cells.length - 1].innerHTML = `<button class="edit-btn">Edit</button> <button class="delete-btn">Delete</button>`;
            })
            .catch(error => console.error('Error:', error));
    }

    function resetNumbering() {
        const rows = tableBody.querySelectorAll("tr");
        rows.forEach((row, index) => {
            const newId = index + 1;
            row.cells[0].textContent = newId;
            row.dataset.rowId = newId;
            updateRowIdInDatabase(row.dataset.originalId, newId);
        });
    }

    function updateRowIdInDatabase(originalId, newId) {
        fetch(`update_id.php?original_id=${originalId}&new_id=${newId}`, { method: 'GET' })
            .then(response => response.text())
            .then(data => console.log(data))
            .catch(error => console.error('Error:', error));
    }
});
