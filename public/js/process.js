const form = document.querySelector('form#process');
const button = document.querySelector('button#submitProcess');
const processTable = document.querySelector('table#process');

let deleteButtons = document.querySelectorAll('button#deleteProcess');
    deleteButtons.forEach(button => {
        button.addEventListener('click', async (e) => {
            const id = e.target.dataset.id;
            const response = await fetch(`/api/process/${id}`, {
                method: 'DELETE'
            });
            const json = await response.json();
            if (json.status === 'success') {
                e.target.parentNode.parentNode.remove();
            }
        });
    });
//async function to handle the form submission using button
button.addEventListener('click', async (e) => {
    e.preventDefault();
    const formData = new FormData(form);
    const data = Object.fromEntries(formData);
    const response = await fetch('/api/process', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    });
    const json = await response.json();

    console.log(json);

    if (json.status === 'success') {
        let data = json.data;
        const row = document.createElement('tr');
        row.innerHTML = `
            <td class="border px-4 py-2">${data.process_name}</td>
            <td class="border px-4 py-2">${data.process_input_material_id}</td>
            <td class="border px-4 py-2">${data.process_output_material_id}</td>
            <td class="border px-4 py-2">${data.process_input_quantity}</td>
            <td class="border px-4 py-2">${data.process_output_quantity}</td>
            <td class="border px-4 py-2">${data.process_start_date}</td>
            <td class="border px-4 py-2">${data.process_end_date}</td>
            <td class="border px-4 py-2">${data.process_status}</td>
            <td class="border px-4 py-2"><button class="bg-red-500 text-white" id="deleteProcess" data-id="${data.id}">Delete</button></td>
        `;
        console.log(processTable);
        processTable.appendChild(row);

        form.reset();
        
    }
    deleteButtons = document.querySelectorAll('button#deleteProcess');
    deleteButtons.forEach(button => {
        button.addEventListener('click', async (e) => {
            const id = e.target.dataset.id;
            const response = await fetch(`/api/process/${id}`, {
                method: 'DELETE'
            });
            const json = await response.json();
            if (json.status === 'success') {
                e.target.parentNode.parentNode.remove();
            }
        });
    });
    



});

//event listener to handle the form submission



