const materialContainer = document.querySelector('.materialContainer');
const materialButton = document.getElementById('materialButton');
const totalMaterial = document.getElementById('totalMaterial');

materialButton.addEventListener('click', () => {
    const imgMaterial= document.querySelector('img#material_image_1');
    totalMaterial.value = parseInt(totalMaterial.value) + 1;
    const materialForm = document.createElement('div');
    materialForm.classList.add('flex');
    materialForm.setAttribute('id', 'materialForm_' + totalMaterial.value);
    materialForm.setAttribute('id', 'materialForm_' + totalMaterial.value);
    materialForm.innerHTML = `
    <div class="flex flex-col w-3/4">
            <div class=" w-full flex flex-row">
                <select name="category" id="selectType_${totalMaterial.value}" class=" border border-gray-400 p-3 m-0 w-1/3" onchange="changeSubtype(${totalMaterial.value})">
                    <option value="0" selected>Select to filter by Category...</option>
                    @foreach ($materialCategory as $category)
                        <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                        
                    @endforeach
                </select>

                <select name="type" id="selectSubType_${totalMaterial.value}" class="border border-gray-400 p-3 m-0 w-1/3" disabled>
                    <option value="0">Please select category first...</option>
                </select>
                <select name="material_id_${totalMaterial.value}" id="material_id_${totalMaterial.value}" class="border border-gray-400 rounded-sm p-3 h-12 w-1/3" disabled>
                    <option value="0" selected>Select subcategory first...</option>
                </select>
            </div>
        </div>
        <div class="flex flex-col w-1/4">
            <input type="number" name="input_quantity_${totalMaterial.value}" id="input_quantity_${totalMaterial.value}" class="border border-gray-400 rounded-sm p-3 h-12" min="0" >
        </div>
        <img src="${imgMaterial.src}" alt="" class="w-12 h-12 mt-0 object-cover" id="material_image_${totalMaterial.value}">
        <button type="button" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" id="removeMaterialButton_${totalMaterial.value}" onclick="removeMaterial(${totalMaterial.value})">Remove</button>
    </div>
</div>
    `;
    materialContainer.appendChild(materialForm);

    // const response = fetch(`/api/material/quantity/1`, {
    //     method: 'GET',
    // }
    // ).then(response => response.json());
    // response.then(data => {
    //   let input = document.querySelector('input#input_quantity_'+totalMaterial.value);
    //   input.value=data;
    // })
    // materialContainer.appendChild(materialForm);
    const selectType1 = document.querySelector('select#selectType_1');
    const selectType2 = document.querySelector('select#selectType_'+totalMaterial.value);
    selectType2.innerHTML = selectType1.innerHTML;
    
});

function inputQuantity(count){
    let selectMaterial = document.querySelector('select#material_id_'+count);
    let inputMaterial = document.querySelector('input#input_quantity_'+count);


    console.log(selectMaterial.value);
    console.log(inputMaterial)

    const response = fetch(`/api/material/quantity/${selectMaterial.value}`, {
        method: 'GET',
    }
    ).then(response => response.json());
    response.then(data => {
        inputMaterial.value=data
    }
    )
}

const colorSearch = document.querySelector('input#colorSearch');
const colorList = document.querySelector('div#colorList');

colorSearch.addEventListener('keyup', () => {
    colorList.classList.remove('hidden');
    colorList.classList.remove('hidden');
    const buttonadd= document.querySelector('button#colorAdd');

    if (buttonadd.hasAttribute('disabled')) {
        buttonadd.setAttribute('disabled', 'disabled');
    }
    //remove inner color list
    colorList.innerHTML = '';
    // fetch
    const response = fetch(`/api/colour/search?colour_name=${colorSearch.value}`, 
    { method: 'GET' }
    ).then(response => response.json());

    response.then(data => {
        colorList.innerHTML = '';
        //display 5 result
        if(data.length == 0){
            
            buttonadd.removeAttribute('disabled');
            colorList.innerHTML += `<div class="flex items-center justify-between"> 
                <div class="flex items
                -center">
                    <div class=" text-base font-bold py-2">There are no color please add new </div>
                    <div class=" text-base font-bold py-2">There are no color please add new </div>
                </div>
            </div>`
            buttonadd.setAttribute('onclick', `addColour('${colorSearch.value}')`);
           


        }
        else if (data.length > 5) {
            for (let i = 0; i < 5; i++) {
                colorList.innerHTML += `<button type="button" class="flex items-center justify-between w-full hover:bg-slate-100" onclick="selectColor(${data[i].id})">
                    <div class="flex items-center">
                        <div class="text-sm">${data[i].colour_name}</div>
                    </div>
                </button>`;

            }
            colorList.innerHTML += `<div class="flex items-center justify-between"> 
                <div class="flex items
                -center">
                    <div class="w-6 h-6 rounded-full mr-3" style="background-color: #fff"></div>
                    <div class="text-sm font-bold">There are any other color please specify</div>
                </div>
                </div>`;
    

        }
        else {
            for (let i = 0; i < data.length; i++) {
                colorList.innerHTML += `<button type="button" class="flex items-center justify-between w-full hover:bg-slate-100" onclick="selectColor(${data[i].id})">
                    <div class="flex items-center">
                        <div class="text-sm">${data[i].colour_name}</div>
                    </div>
                </button>`;
            }
        }


        
    })


});
let placeholder = document.querySelector('div#placeholderInput');
function selectColor(id) {
    const colorSearch = document.querySelector('input#colorSearch');
    colorList.classList.add('hidden');
    colorSearch.removeAttribute('required');
    const response = fetch(`/api/colour/${id}`, 
    { method: 'GET' }
    ).then(response => response.json());

    response.then(data => {



        //create label for child 
        let label = document.createElement('label');
        label.classList.add('font-bold');
        label.classList.add('mt-3');
        label.setAttribute('id', 'colour'+data.id);
        label.classList.add('font-bold');
        label.classList.add('mt-3');
        label.setAttribute('id', 'colour'+data.id);
        label.setAttribute('for', 'colour_id');
        label.innerHTML = `
        <div class="text-sm">${data.colour_name}</div>`
        label.classList.add('flex');
        placeholder.appendChild(label);

        //place output on placeholder
        let output=document.createElement('div');
        output.classList.add('flex');
        output.classList.add('w-full');
        output.setAttribute('id', "output_"+data.id);

        output.setAttribute('id', "output_"+data.id);

        output.innerHTML = `
        <input type="hidden" name="colour_id[]" value="${data.id}">
        <div class="flex flex-col">
        <label for="output_quantity">S</label>
        <input type="number" name="output_quantity[]" id="output_quantity[]" class="border border-gray-400 rounded-sm p-3 h-12" value="0" min="0">
        <input type="hidden" name="ukuran_id[]" value="1">
        </div>
        <div class="flex flex-col">
        <label for="output_quantity">M</label>
        <input type="number" name="output_quantity[]" id="output_quantity[]" class="border border-gray-400 rounded-sm p-3 h-12" value="0" min="0">
        <input type="hidden" name="ukuran_id[]" value="2">
        </div>
        <div class="flex flex-col">
        <label for="output_quantity">L</label>
        <input type="number" name="output_quantity[]" id="output_quantity[]" class="border border-gray-400 rounded-sm p-3 h-12" value="0" min="0">
        <input type="hidden" name="ukuran_id[]" value="3">
        </div>
        <div class="flex flex-col">
        <label for="output_quantity">XL</label>
        <input type="number" name="output_quantity[]" id="output_quantity[]" class="border border-gray-400 rounded-sm p-3 h-12" value="0" min="0">
        <input type="hidden" name="ukuran_id[]" value="4">
        </div>
        <div class="flex flex-col">
        <label for="output_quantity">XXL</label>
        <input type="number" name="output_quantity[]" id="output_quantity[]" class="border border-gray-400 rounded-sm p-3 h-12" value="0" min="0">
        <input type="hidden" name="ukuran_id[]" value="5">
        
        
        </div>
        <button type="button" class="bg-red-500 text-white rounded-md p-3 mt-6 w-40 " onclick="removeColor(${data.id})">Remove</button>
        
        
        `;
        placeholder.appendChild(output);

        colorList.innerHTML = '';
        colorSearch.value = '';


        
    })
}

function addColour(name) {
    fetch (`/api/colour`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            colour_name: name,
        })
    })
    .then(response => response.json())
    .then(data => {
        selectColor(data.id);
        colorSearch.value = '';
        colorList.innerHTML = '';
        buttonadd.setAttribute('disabled', 'disabled');
    })
}


function changeSubtype(id) {
    const selectType = document.querySelector(`select#selectType_${id}`);
    const selectSubType = document.querySelector(`select#selectSubType_${id}`);
    const selectMaterial= document.querySelector(`select#material_id_${id}`);

    if (selectSubType.hasAttribute('disabled')) {
        selectSubType.removeAttribute('disabled') 
    }

    //fetch to subcategory
    fetch(`/api/subcategory/${selectType.value}`)
        .then(response => response.json())
        .then(data => {

            //change options selected
            selectSubType.innerHTML = '';
            const option = document.createElement('option');
            option.value = '0';
            option.textContent = 'Select Subcategory';
            selectSubType.appendChild(option);
            data.forEach(subcategory => {
                const option = document.createElement('option');
                option.value = subcategory.id;
                option.textContent = subcategory.sub_category_name;
                selectSubType.appendChild(option);
            });

            selectSubType.addEventListener('change', function() {
                fetch(`/api/material/subcategory/${selectSubType.value}`)
                    .then(response => response.json())
                    .then(data => {
                        if (selectMaterial.hasAttribute('disabled')) {
                            selectMaterial.removeAttribute('disabled')
                        }
                            
                        selectMaterial.innerHTML = '';
                        const option = document.createElement('option');
                        option.value = '0';
                        option.textContent = 'Select Material';
                        selectMaterial.appendChild(option);
                        data.forEach(material => {
                            const option = document.createElement('option');
                            option.value = material.id;
                            option.textContent = material.material_name;
                            selectMaterial.appendChild(option);
                        });
                        selectMaterial.addEventListener('change', function() {
                            data.forEach(material => {
                                if (material.id == selectMaterial.value) {
                                    let material_image = document.querySelector(`img#material_image_${id}`);
                                    material_image.src = '/uploads/material/' + material.material_image;
                                    let inputMaterial = document.querySelector(`input#input_quantity_${id}`);
                                    inputMaterial.value= material.material_quantity;
                                    inputMaterial.setAttribute('max',material.material_quantity)
                                }
                                
                            });
                            
                        });
                    });

            });

        });
    selectSubType
};

const removeMaterial = (id) => {
    const material = document.querySelector(`div#materialForm_${id}`);
    const totalMaterial = document.querySelector(`input#totalMaterial`);
    totalMaterial.value= parseInt(totalMaterial.value)-1;
    material.remove();
}

const removeColor = (id) => {
    const label = document.querySelector(`label#colour${id}`);
    const output = document.querySelector(`div#output_${id}`);
    label.remove();
    output.remove();
}

