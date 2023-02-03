const selectType = document.querySelector('select#selectType');
const selectSubType = document.querySelector('select#selectSubType');


selectType.addEventListener('change', function() {
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
            data.forEach(subcategory => {
                const option = document.createElement('option');
                option.value = subcategory.id;
                option.textContent = subcategory.sub_category_name;
                selectSubType.appendChild(option);
            });
            const addOption = document.createElement('option');
            addOption.value = 'add';
            addOption.textContent = 'Add Subcategory';
            selectSubType.appendChild(addOption);

            selectSubType.addEventListener('change', function() {
                if (selectSubType.value === 'add') {
                    let newSubCategory = prompt('Enter new subcategory');
                    if (newSubCategory != null) {
                        fetch('/api/subcategory', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({
                                sub_category_name: newSubCategory,
                                category_id: selectType.value
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            const option = document.createElement('option');
                            option.value = data.id;
                            option.textContent = data.sub_category_name;
                            selectSubType.appendChild(option);
                            addOption.remove();
                        })
                    }
                    
    
    
                };
            });
        });
});

const fileInput = document.querySelector('input#file_input');

fileInput.addEventListener('change', function() {
    const file = this.files[0];
    const reader = new FileReader();

    reader.addEventListener('load', function() {
        const image = document.querySelector('img#image');
        image.classList.remove('hidden');
        image.src = reader.result;
    });

    reader.readAsDataURL(file);
});
