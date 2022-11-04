const materialContainer = document.querySelector('.materialContainer');
const materialButton = document.getElementById('materialButton');
const totalMaterial = document.getElementById('totalMaterial');

materialButton.addEventListener('click', () => {
    totalMaterial.value = parseInt(totalMaterial.value) + 1;
  const materialForm = document.createElement('div');
  materialForm.classList.add('flex');
    materialForm.innerHTML = `
        <div class="flex flex-col">
            <label for="input_quantity">Input Quantit Material `+totalMaterial.value+`</label>
            <input type="number" name="input_quantity_`+totalMaterial.value+`" id="input_quantity_`+totalMaterial.value+`" class="border border-gray-400 p-2">
        </div>
        <div class="flex flex-col">
            <label for="material_id">Material Type `+totalMaterial.value+`</label>
            <select name="material_id_`+totalMaterial.value+`" id="material_id_`+totalMaterial.value+`" class="border border-gray-400 
            p-2">
            </select>

        </div> 
    `
    materialContainer.appendChild(materialForm);
    const selectMaterial1 = document.querySelector('select#material_id_1');
    const selectMaterial2 = document.querySelector('select#material_id_'+totalMaterial.value);
    selectMaterial2.innerHTML = selectMaterial1.innerHTML;
    
});