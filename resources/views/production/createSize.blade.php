@extends('layouts.main')
@section('container')

<form action="/production/{{ $production->id }}/size" method="post">
  @csrf
  <div class="flex flex-col">
    <label for="size" class="label">Size Name</label>
    <input type="text" name="size" id="size" class="border-2 border-gray-300 rounded-lg p-2">
  </div>
  
    
  <div class="flex ">
    <div class="flex flex-col w-full">
        <label for="color" class="label">Color</label>
        <div class="flex">
            <input type="text" name="color" id="color" class="hidden">
            <input required type="text" name="search" id="colorSearch" class="border border-gray-400 p-2 w-11/12 rounded" placeholder="Search Color" >
            <button type="button" class="bg-blue-500 w-1/12 m-0 p-2 text-white rounded-sm disabled:bg-blue-300" id="colorAdd" disabled> Add</button>
        </div>
        <div class="bg-white w-11/12 shadow-lg p-2 hidden " id="colorList">
        </div>
    </div>
  </div>  
  <div class="flex flex-col">
    <label for="quantity" class="label">Quantity</label>
    <input type="number" name="quantity" id="quantity" class="border-2 border-gray-300 rounded-lg p-2">
  </div>
  <button type="submit" class="bg-blue-500 w-1/12 mt-6 p-2 text-white rounded-sm disabled:bg-blue-300"> Submit</button>
    
</form>

<script>
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
  let color = document.querySelector('input#color');
  console.log(color);
  function selectColor(id) {
    const colorSearch = document.querySelector('input#colorSearch');
    colorList.classList.add('hidden');
    colorSearch.removeAttribute('required');
    const response = fetch(`/api/colour/${id}`, 
    { method: 'GET' }
    ).then(response => response.json());

    response.then(data => {
        console.log(data);
        colorSearch.value = data.colour_name;
        color.value = data.id;


        
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

</script>






@endsection