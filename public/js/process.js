// const form = document.querySelector('form#process_2');
// console.log(form);
// const button = document.querySelector('form#process_2 button#submitProcess');
// console.log(button);


// // let deleteButtons = document.querySelectorAll('button#deleteProcess');
// //     deleteButtons.forEach(button => {
// //         button.addEventListener('click', async (e) => {
// //             const id = e.target.dataset.id;
// //             const response = await fetch(`/api/process/${id}`, {
// //                 method: 'DELETE'
// //             });
// //             const json = await response.json();
// //             if (json.status === 'success') {
// //                 e.target.parentNode.parentNode.remove();
// //             }
// //         });
// //     });
// //async function to handle the form submission using button
// button.addEventListener('click', async (e) => {
//     e.preventDefault();
//     const formData = new FormData(form);
//     const data = Object.fromEntries(formData);
//     console.log(data);
//     //
//     const response = await fetch('/api/process', {
//         method: 'POST',
//         headers: {
//             'Content-Type': 'application/json'
//         },
//         body: JSON.stringify(data)

//     });
    
//     const json = response.json();
//     console.log(json);
// sampe sini

    // if (json.status === 'success') {
    //     let data = json.data;
    //     const row = document.createElement('tr');
    //     row.innerHTML = `
    //         <td class="border px-4 py-2">${data.process_name}</td>
    //         <td class="border px-4 py-2">${data.process_input_material_id}</td>
    //         <td class="border px-4 py-2">${data.process_output_material_id}</td>
    //         <td class="border px-4 py-2">${data.process_input_quantity}</td>
    //         <td class="border px-4 py-2">${data.process_output_quantity}</td>
    //         <td class="border px-4 py-2">${data.process_start_date}</td>
    //         <td class="border px-4 py-2">${data.process_end_date}</td>
    //         <td class="border px-4 py-2">${data.process_status}</td>
    //         <td class="border px-4 py-2"><button class="bg-red-500 text-white" id="deleteProcess" data-id="${data.id}">Delete</button></td>
    //     `;
    //     console.log(processTable);
    //     processTable.appendChild(row);

    //     form.reset();
        
    // }
    // deleteButtons = document.querySelectorAll('button#deleteProcess');
    // deleteButtons.forEach(button => {
    //     button.addEventListener('click', async (e) => {
    //         const id = e.target.dataset.id;
    //         const response = await fetch(`/api/process/${id}`, {
    //             method: 'DELETE'
    //         });
    //         const json = await response.json();
    //         if (json.status === 'success') {
    //             e.target.parentNode.parentNode.remove();
    //         }
    //     });
    // });
    



// });
function closeDetail(id){
    let detail=document.getElementById('detail_'+id);     
    detail.classList.add("hidden");
    
    let button=document.getElementById('button_'+id);
    button.onclick = function () { openDetail(id); };
}

function openDetail(id){
    let detail=document.getElementById('detail_'+id);     
    detail.classList.remove("hidden");
    
    let button=document.getElementById('button_'+id);
    button.onclick = function () { closeDetail(id); };
}

function closeAllDetail(){
    let details=document.querySelectorAll('.detail');     
    console.log(details);
    for (let i = 0; i < details.length; i++) {
        details[i].classList.add("hidden");
    }
    
    let buttons=document.getElementsByClassName('button');     
    for (let i = 0; i < buttons.length; i++) {
        buttons[i].onclick = function () { openDetail(buttons[i].id); };
    }
}

//event listener to handle the form submission

const select= document.querySelector('select#process_output_material_id');
const lengthSelect = select.options.length;
for (i = 1; i < lengthSelect; i++) {
    select.options[i].disabled = true;
}
select.options[0].disabled = false;

const input = document.querySelector('input#process_output_quantity');

const ukuranBagian= document.querySelector('#ukuranBagian');

//see selected
if (select.value == "0") {
    ukuranBagian.classList.remove('hidden');
    ukuranBagian.classList.add('flex');
    input.classList.add('hidden');
    input.classList.remove('flex');
}
else {
    ukuranBagian.classList.add('hidden');
    ukuranBagian.classList.remove('flex');
    input.classList.remove('hidden');
    input.classList.add('flex');

}

select.addEventListener('change', (e) => {
    if (select.value == "0") {
        ukuranBagian.classList.remove('hidden');
        ukuranBagian.classList.add('flex');
        input.classList.remove('flex');
        input.classList.add('hidden');
    }
    else {
        ukuranBagian.classList.add('hidden');
        ukuranBagian.classList.remove('flex');
        input.classList.add('flex');
        input.classList.remove('hidden');
    }
});

function printExternal(url) {
    var printWindow = window.open( url, 'Print', 'toolbar=0, resizable=0');

    printWindow.addEventListener('load', function() {
        if (Boolean(printWindow.chrome)) {
            printWindow.print();
            setTimeout(function(){
                printWindow.close();
            }, 500);
        } else {
            printWindow.print();
            printWindow.close();
        }
    }, true);
}




const selectprocessid= document.querySelector('select#process_id');
console.log(selectprocessid);
const selectuserid= document.querySelector('select#user_id');

selectprocessid.addEventListener('change', (e) => {
    const lengthSelect = select.options.length;
    if(selectprocessid.value == 99){
        selectuserid.innerHTML = ``;
        selectuserid.innerHTML = `<option value="0">Penugasan pekerja saat konfirm</option>`;
        selectuserid.disabled = true;

        for (i = 1; i < lengthSelect; i++) {
            if (select.options[i].text.includes("(Rusak)")) {
                select.options[i].disabled = true;
            }
            else {
                select.options[i].disabled = false;
            }
        }

        select.options[1].selected = true;
        select.options[0].disabled = true;

        ukuranBagian.classList.add('hidden');
        ukuranBagian.classList.remove('flex');
        input.classList.remove('hidden');
        input.classList.add('flex');



        return;
    }
    //api request
    const response = fetch(`/api/process/${selectprocessid.value}`, {
        method: 'GET',
    }
    ).then(response => response.json());
    response.then(data => {
        console.log(data);
        //if data empty
        if (data.length == 0) {
            selectuserid.innerHTML = ``;
            selectuserid.innerHTML = `<option value="0">No User</option>`;
            //alert to hyperlink to add user
            confirms=confirm("No User Found. Do you want to add user?");
            if (confirms==true) {
                window.location.href = '/user/create';
            }
        }
        else {
            selectuserid.innerHTML = ``;
            data.forEach(element => {
                selectuserid.innerHTML += `<option value="${element.id}">${element.name}</option>`;
            });
        }
    });
    //if selected first option
    const lengthProcess = selectprocessid.options.length;


    if (selectprocessid[selectprocessid.selectedIndex].text.includes("Potong") || selectprocessid[selectprocessid.selectedIndex].text.includes("Bordir")) {
        for (i = 1; i < lengthSelect; i++) {
            select.options[i].disabled = true;
        }
        select.options[0].selected = true;
        select.options[0].disabled = false;
        ukuranBagian.classList.remove('hidden');
        ukuranBagian.classList.add('flex');
        input.classList.add('hidden');
        input.classList.remove('flex');
    }
    else if(selectprocessid[selectprocessid.selectedIndex].text.includes("Permak")) {
        for (i = 0; i < lengthSelect; i++) {
            //if name contains (rusak)
            if (select.options[i].text.includes("(Rusak)")) {
                select.options[i].disabled = false;
                select.options[i].selected = true;
            }
            else {
            select.options[i].disabled = true;
            }
        }
        ukuranBagian.classList.add('hidden');
        ukuranBagian.classList.remove('flex');
        input.classList.remove('hidden');
        input.classList.add('flex');
    }

    else {
        for (i = 1; i < lengthSelect; i++) {
            if (select.options[i].text.includes("(Rusak)")) {
                select.options[i].disabled = true;
            }
            else {
                select.options[i].disabled = false;
            }
        }
        select.options[1].selected = true;
        select.options[0].disabled = true;
        ukuranBagian.classList.add('hidden');
        ukuranBagian.classList.remove('flex');
        input.classList.remove('hidden');
        input.classList.add('flex');
    
    }

});

const tableSub = document.querySelectorAll('#subproses');

function createPaginationButton (index){
    let page, n, i, x, y ;
    let selectedPage= document.getElementById('selectedPage_'+index);
    let rows = [];
    tableSub[index].childNodes.forEach(tr => {
        if (tr.id == "row"){
            rows.push(tr);
        }
    });
    console.log(rows);
    n = rows.length;
    page = Math.ceil(n/5);
    for (i = 1; i <= page; i++) {
        let buttonContainer = document.createElement('div');
        buttonContainer.innerHTML = '<button id="page_'+index+'" value="'+i+'" class=" px-3 py-2.5 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 " onclick="pagination('+index+','+i+')">'+i+'</button>';
        document.getElementById('pagination_'+index).appendChild(buttonContainer);
    }
    const rowss = document.querySelectorAll('#page_'+index);
    rowss[0].classList.add('!bg-gray-100');
    rowss[0].setAttribute('disabled', 'disabled');

    selectedPage.value = 1;
    
    if(page == 1)
    {
        const nextButton = document.getElementById('nextButton_'+index);
        nextButton.classList.add('hidden');
    }
}

for (let index = 0; index < tableSub.length; index++) {
    createPaginationButton(index);
}

function pagination(index,page) {
    let  i, x, y;
    let selectedPage = document.getElementById('selectedPage_'+index);
    let totalPage = document.querySelectorAll('#page_'+index);
    page = parseInt(page);
    totalPage[selectedPage.value-1].classList.remove('!bg-gray-100');
    totalPage[selectedPage.value-1].removeAttribute('disabled');

    let rows = [];
    tableSub[index].childNodes.forEach(tr => {
        if (tr.id == "row"){
            rows.push(tr);
        }
    });
    console.log(rows);
    for (i = 1; i < rows.length; i++) {
        if (i > page*5 || i <= (page-1)*5) {
            rows[i].style.display = "none";
        } 
        else {
            rows[i].style.display = "";
        }
    }
    
    closeAllDetail();

    selectedPage.value = page;


    if (selectedPage.value == 1) {
        const previousButton = document.getElementById('previousButton_'+index);
        previousButton.classList.add('hidden');

        const nextButton = document.getElementById('nextButton_'+index);
        nextButton.classList.remove('hidden');
    } 
    else if (selectedPage.value == totalPage.length) {
        const previousButton = document.getElementById('previousButton_'+index);
        previousButton.classList.remove('hidden');

        const nextButton = document.getElementById('nextButton_'+index);
        nextButton.classList.add('hidden');
    }
    else {
        const previousButton = document.getElementById('previousButton_'+index);
        previousButton.classList.remove('hidden');

        const nextButton = document.getElementById('nextButton_'+index);
        nextButton.classList.remove('hidden');
    }

    totalPage[selectedPage.value-1].classList.add('!bg-gray-100');
    totalPage[selectedPage.value-1].setAttribute('disabled', 'disabled');
}

function previousPage(index) {
    let selectedPage = document.getElementById('selectedPage_'+index);
    let page = selectedPage.value;
    page = parseInt(page);
    pagination(index, page-1);
}

function nextPage(index) {
    let selectedPage = document.getElementById('selectedPage_'+index);
    let page = selectedPage.value;
    page = parseInt(page);
    pagination(index, page+1);
}

function submitAll(index,subProcess){
    const submitAll = document.getElementById('submitAll_'+index);
    const inputUser = document.getElementById('user_'+subProcess);
    const inputSubProcess = document.getElementById('process_'+subProcess);
    const inputQty = document.getElementById('quantity_'+subProcess);
    let buttonSubmitAll= document.getElementById('buttonSubmitAll_'+index);

    if (submitAll.childNodes == 0){
        const hiddenInput= document.createElement('div');
        hiddenInput.innerHTML = '<input type="hidden" name="user[]" value="'+inputUser.value+'"><input type="hidden" name="process[]" value="'+inputSubProcess.value+'"><input type="hidden" name="quantity[]" value="'+inputQty.value+'" id="quantityAll_'+subProcess+'"><input type="hidden" name="subProcess[]" value="'+subProcess+'">';
        submitAll.appendChild(hiddenInput);
        //change text in button
        buttonSubmitAll.value = parseInt(buttonSubmitAll.value)+1;

        buttonSubmitAll.innerHTML = 'Submit All ('+buttonSubmitAll.value+')';
    }
    else {
        let inputquantity= document.getElementById('quantityAll_'+subProcess);
        if (inputquantity != null){
            inputquantity.value = inputQty.value;
        }
        else {
            const hiddenInput= document.createElement('div');
            hiddenInput.innerHTML = '<input type="hidden" name="user[]" value="'+inputUser.value+'"><input type="hidden" name="process[]" value="'+inputSubProcess.value+'"><input type="hidden" name="quantity[]" value="'+inputQty.value+'" id="quantityAll_'+subProcess+'"><input type="hidden" name="subProcess[]" value="'+subProcess+'">';
            submitAll.appendChild(hiddenInput);
            buttonSubmitAll.value = parseInt(buttonSubmitAll.value)+1;
            buttonSubmitAll.innerHTML = 'Submit All ('+buttonSubmitAll.value+')';
        }
    }

}

const showInput = (id) =>{
    inputs = document.querySelectorAll('.list_'+id);
    inputs.forEach(input => {
        if (input.classList.contains('hidden')){
            input.classList.remove('hidden');
        }
    });
    document.querySelector('#hideInput_'+id).classList.remove('hidden');  

    document.querySelector('#showInput_'+id).classList.add('hidden');
}

const hideInput = (id) =>{
    count = 0
    inputs = document.querySelectorAll('.list_'+id);

    inputs.forEach(input => {
        if (count < 5){

        }
        else {
            input.classList.add('hidden');
        }
        count++;
    });
    document.querySelector('#hideInput_'+id).classList.add('hidden');
    document.querySelector('#showInput_'+id).classList.remove('hidden');

}




