const historyStack = [];

const selectType = document.querySelector('select#selectType');
const selectSubType = document.querySelector('select#selectSubType');
const tr= document.querySelectorAll('tbody tr');
const table = document.querySelector('table');


selectType.addEventListener('change', function() {
    //remove hidden class if class match with data array

    tr.forEach(element => {
        if (element.classList.contains('hidden')) {
            element.classList.remove('hidden');
        }
        element.classList.add('hidden');
    });

    if (selectSubType.hasAttribute('disabled')) {
        selectSubType.removeAttribute('disabled');
        
    }

    //fetch to subcategory
    fetch(`/api/subcategory/${selectType.value}`)
        .then(response => response.json())
        .then(data => {
            //remove hidden class if class match with data array
            id=data.map(subcategory => subcategory.id);
            console.log(id);
            rows=Array.from(table.rows);

            
            rows.forEach(row => {
                console.log(row.classList[0]);
                if (id.includes(parseInt(row.classList[0]))) {
                    row.classList.remove('hidden');
                }
                else{
                    //place to last row
                    row.parentNode.insertBefore(row, row.parentNode.lastChild);
                }
            });

            
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

            //subCategory change
            selectSubType.addEventListener('change', function() {
                tr.forEach(element => {
                if (element.classList.contains('hidden')) {
                    element.classList.remove('hidden');
                }
                element.classList.add('hidden');
            });

                //remove hidden class if class match with data array
                id=selectSubType.value;

                tr.forEach(tr => {
                    if (tr.classList.contains(id)) {
                        tr.classList.remove('hidden');
                    }
                });
                CreatePaginationNotHidden();
            });

        CreatePaginationNotHidden();    
        });
});




const search = document.querySelector('input#search');
search.addEventListener('keyup', function() {
    tr.forEach(element => {
        element.classList.add('hidden');
    });

    let filter = search.value.toUpperCase();
    tr.forEach(tr => {
        let td = tr.getElementsByTagName('td')[1];
        if (td) {
            let textValue = td.textContent || td.innerText;
            if (textValue.toUpperCase().indexOf(filter) > -1) {
                tr.classList.remove('hidden');
            }
        }
    });
    CreatePaginationNotHidden();
});

function sort(nrow) {
    let table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
    table = document.querySelector('table');
    switching = true;
    //Set the sorting direction to ascending:
    dir = "asc";
    /*Make a loop that will continue until
    no switching has been done:*/
    while (switching) {
        //start by saying: no switching is done:
        switching = false;
        rows = table.rows;
        /*Loop through all table rows (except the
        first, which contains table headers):*/
        for (i = 1; i < (rows.length - 1); i++) {
            //start by saying there should be no switching:
            shouldSwitch = false;
            /*Get the two elements you want to compare,
            one from current row and one from the next:*/
            x = rows[i].getElementsByTagName("TD")[nrow];
            y = rows[i + 1].getElementsByTagName("TD")[nrow];
            /*check if the two rows should switch place,
            based on the direction, asc or desc:*/
            if (dir == "asc") {
                if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                    //if so, mark as a switch and break the loop:
                    shouldSwitch = true;
                    break;
                }
            } else if (dir == "desc") {
                if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                    //if so, mark as a switch and break the loop:
                    shouldSwitch = true;
                    break;
                }
            }
        }
        if (shouldSwitch) {
            /*If a switch has been marked, make the switch
            and mark that a switch has been done:*/
            rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
            switching = true;
            //Each time a switch is done, increase this count by 1:
            switchcount ++;
        } else {
            /*If no switching has been done AND the direction is "asc",
            set the direction to "desc" and run the while loop again.*/
            if (switchcount == 0 && dir == "asc") {
                dir = "desc";
                switching = true;
            }
        }
    }
    
}

function sortNumber(nrow) {
    let table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
    table = document.querySelector('table');
    switching = true;
    //Set the sorting direction to ascending:
    dir = "asc";
    /*Make a loop that will continue until
    no switching has been done:*/
    while (switching) {
        //start by saying: no switching is done:
        switching = false;
        rows = table.rows;
        /*Loop through all table rows (except the
        first, which contains table headers):*/
        for (i = 1; i < (rows.length - 1); i++) {
            //start by saying there should be no switching:
            shouldSwitch = false;
            /*Get the two elements you want to compare,
            one from current row and one from the next:*/
            x = rows[i].getElementsByTagName("TD")[nrow];
            y = rows[i + 1].getElementsByTagName("TD")[nrow];
            // cut for number only but let - for negative number
            x = x.innerHTML.replace(/[^0-9-]/g, '');
            y = y.innerHTML.replace(/[^0-9-]/g, '');
            x = parseInt(x);
            y = parseInt(y);

            /*check if the two rows should switch place,
            based on the direction, asc or desc:*/
            if (dir == "asc") {
                if (x > y) {
                    //if so, mark as a switch and break the loop:
                    shouldSwitch = true;
                    break;
                }
            } else if (dir == "desc") {
                if (x < y) {
                    //if so, mark as a switch and break the loop:
                    shouldSwitch = true;
                    break;
                }
            }
        }
        if (shouldSwitch) {
            /*If a switch has been marked, make the switch
            and mark that a switch has been done:*/
            rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
            switching = true;
            //Each time a switch is done, increase this count by 1:
            switchcount ++;
        } else {
            /*If no switching has been done AND the direction is "asc",
            set the direction to "desc" and run the while loop again.*/
            if (switchcount == 0 && dir == "asc") {
                dir = "desc";
                switching = true;
            }
        }
    }
}
function sortDate(nrow){
    let table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
    table = document.querySelector('table');
    switching = true;
    //Set the sorting direction to ascending:
    dir = "asc";
    /*Make a loop that will continue until
    no switching has been done:*/
    while (switching) {
        //start by saying: no switching is done:
        switching = false;
        rows = table.rows;
        /*Loop through all table rows (except the
        first, which contains table headers):*/
        for (i = 1; i < (rows.length - 1); i++) {
            //start by saying there should be no switching:
            shouldSwitch = false;
            /*Get the two elements you want to compare,
            one from current row and one from the next:*/
            x = rows[i].getElementsByTagName("TD")[nrow];
            y = rows[i + 1].getElementsByTagName("TD")[nrow];
            // cut date before space
            x = x.innerHTML.split(' ')[0];
            y = y.innerHTML.split(' ')[0];
            // convert date to timestamp
            x = new Date(x).getTime();
            y = new Date(y).getTime();


            /*check if the two rows should switch place,
            based on the direction, asc or desc:*/
            if (dir == "asc") {
                if (x > y) {
                    //if so, mark as a switch and break the loop:
                    shouldSwitch = true;
                    break;
                }
            } else if (dir == "desc") {
                if (x < y) {
                    //if so, mark as a switch and break the loop:
                    shouldSwitch = true;
                    break;
                }
            }
        }
        if (shouldSwitch) {
            /*If a switch has been marked, make the switch
            and mark that a switch has been done:*/
            rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
            switching = true;
            //Each time a switch is done, increase this count by 1:
            switchcount ++;
        } else {
            /*If no switching has been done AND the direction is "asc",
            set the direction to "desc" and run the while loop again.*/
            if (switchcount == 0 && dir == "asc") {
                dir = "desc";
                switching = true;
            }
        }
    }
}


let selectedPage = document.getElementById('selectedPage');


function createPaginationButton (){
    let table, rows, page, n, i, x, y;
    table = document.querySelector('table');
    rows = table.rows;
    n = rows.length;
    page = Math.ceil(n/10);
    for (i = 1; i <= page; i++) {
        let buttonContainer = document.createElement('div');
        buttonContainer.innerHTML = '<button id="page" value="'+i+'" class=" relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 hover:text-gray-500 focus:z-10 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150 " onclick="pagination('+i+')">'+i+'</button>';
        document.getElementById('pagination').appendChild(buttonContainer);
    }
    const rowss = document.querySelectorAll('#page');
    rowss[0].classList.add('bg-gray-100');
    rowss[0].setAttribute('disabled', 'disabled');

    selectedPage.value = 1;
    
    if(page == 1)
    {

        const nextButton = document.getElementById('nextButton');
        nextButton.classList.add('hidden');
    }
}
createPaginationButton();

const rearangeHidden = () => {
    let table = document.querySelector('table');
    let rows = table.rows;

    for (let i = 0; i < rows.length; i++) {
        if (rows[i].classList.contains('hidden')) {
            rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
        }
    }
};

function CreatePaginationNotHidden(){
    let table, rows, page, n, i, x, y;
    table = document.querySelector('table');
    rows = table.rows;
    console.log(table.rows);
    n = 0;
    for (i = 1; i < rows.length; i++) {
        console.log(rows[i]);
        if (rows[i].classList.contains('hidden')) {
            //move row to the end
            rows[i].parentNode.insertBefore(rows[i], rows[rows.length - 1].nextSibling);
            
        }
        else {
            n=n+1;
            if (n < 10) {
                rows[i].style.display = "";
            }
            else {
                rows[i].style.display = "none";
                
            }
        }  
    }
    console.log(table.rows);
    
    page = Math.ceil(n/10);
    document.getElementById('pagination').innerHTML = '';
    console.log(page,n);
    for (i = 1; i <= page; i++) {
        let buttonContainer = document.createElement('div');
        buttonContainer.innerHTML = '<button id="page" value="'+i+'" class=" relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 hover:text-gray-500 focus:z-10 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150 " onclick="pagination('+i+')">'+i+'</button>';
        document.getElementById('pagination').appendChild(buttonContainer);
    }
    // make first button active
    const rowss = document.querySelectorAll('#page');
    rowss[0].classList.add('bg-gray-100');
    rowss[0].setAttribute('disabled', 'disabled');
    if(page == 1)
    {
        const previousButton = document.getElementById('previousButton');
        previousButton.classList.add('hidden');

        const nextButton = document.getElementById('nextButton');
        nextButton.classList.add('hidden');
    }

    selectedPage.value = 1;
};

function pagination(page) {
    let table, rows, i, x, y;
    let totalPage = document.querySelectorAll('#page');
    totalPage[selectedPage.value-1].classList.remove('bg-gray-100');
    totalPage[selectedPage.value-1].removeAttribute('disabled');

    table = document.querySelector('table');
    rows = table.rows;
    console.log(rows);
    for (i = 1; i < rows.length; i++) {
        if (i > page*10 || i <= (page-1)*10) {
            rows[i].style.display = "none";
        } else {
            rows[i].style.display = "";
        }
    }

    selectedPage.value = page;


    if (selectedPage.value == 1) {
        const previousButton = document.getElementById('previousButton');
        previousButton.setAttribute('disabled',true)

        const nextButton = document.getElementById('nextButton');
        nextButton.removeAttribute("disabled");
    } 
    else if (selectedPage.value == totalPage.length) {
        const nextButton = document.getElementById('nextButton');
        nextButton.setAttribute('disabled',true)

        const previousButton = document.getElementById('previousButton');
        previousButton.removeAttribute("disabled");
    }
    else {
        const previousButton = document.getElementById('previousButton');
        previousButton.removeAttribute("disabled");

        const nextButton = document.getElementById('nextButton');
        nextButton.removeAttribute("disabled");
    }

    totalPage[selectedPage.value-1].classList.add('bg-gray-100');
    totalPage[selectedPage.value-1].setAttribute('disabled', 'disabled');
}

function previousPage() {
    let page = parseInt(selectedPage.value);
    if (page > 1) {
        pagination(page-1);
    }
};

function nextPage() {
    let page = parseInt(selectedPage.value);

    let totalPage = document.querySelectorAll('#page');
    if (page < totalPage.length) {
        pagination(page+1);
    }

}
