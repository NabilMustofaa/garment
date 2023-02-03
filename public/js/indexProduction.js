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
    page = Math.ceil(n/5);
    for (i = 1; i <= page; i++) {
        let buttonContainer = document.createElement('div');
        buttonContainer.innerHTML = '<button id="page" value="'+i+'" class=" px-3 py-2 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 " onclick="pagination('+i+')">'+i+'</button>';
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

function CreatePaginationNotHidden(){
    let table, rows, page, n, i, x, y;
    table = document.querySelector('table');
    rows = table.rows;
    n = 0;
    for (i = 1; i < rows.length; i++) {
        if (n < 5) {
            if (rows[i].classList.contains('hidden')) {
            }
            else {
                rows[i].style.display = "";
                n=n+1; 
            }
        }
        else {
            rows[i].style.display = "none";
            n=n+1;
        }
        
    }
    
    page = Math.ceil(n/5);
    document.getElementById('pagination').innerHTML = '';
    console.log(page,n);
    for (i = 1; i <= page; i++) {
        let buttonContainer = document.createElement('div');
        buttonContainer.innerHTML = '<button id="page" value="'+i+'" class=" px-3 py-2 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 " onclick="pagination('+i+')">'+i+'</button>';
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
    for (i = 1; i < rows.length; i++) {
        if (i > page*5 || i <= (page-1)*5) {
            rows[i].style.display = "none";
        } else {
            rows[i].style.display = "";
        }
    }

    selectedPage.value = page;


    if (selectedPage.value == 1) {
        const previousButton = document.getElementById('previousButton');
        previousButton.classList.add('hidden');

        const nextButton = document.getElementById('nextButton');
        nextButton.classList.remove('hidden');
    } 
    else if (selectedPage.value == totalPage.length) {
        const nextButton = document.getElementById('nextButton');
        nextButton.classList.add('hidden');

        const previousButton = document.getElementById('previousButton');
        previousButton.classList.remove('hidden');
    }
    else {
        const previousButton = document.getElementById('previousButton');
        previousButton.classList.remove('hidden');

        const nextButton = document.getElementById('nextButton');
        nextButton.classList.remove('hidden');
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

