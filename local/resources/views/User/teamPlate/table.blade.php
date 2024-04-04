@if(isset($startTime))
<form method="post" action="{{URL::to('User/postKhuVuc/'.$id_khu_vuc.'/'.$action)}}" enctype="multipart/form-data" class="export">
	@csrf
	<input type="hidden" name="action" value="execel">
	<input type="hidden" name="startTime" value="{{$startTime}}">
	<input type="hidden" name="endTime" value="{{$endTime}}">
	<input type="hidden" name="Alert" value="">
	<input type="submit"  value="Export execel" class="btn btn-primary">
</form>
@endif
<style type="text/css">
    .export{
        position: absolute;
        top: -35px;
        right:135px;
    }
</style>
<?php $th = json_decode($txt[0]->data, true); ?>
<table id="myTable" class="table table-bordered table-hover">
  <thead >
    <tr class="table-secondary">
        <th>STT</th>
        <th>Time</th>
        @foreach($th as $key => $value)
        <th>{{$value['name']}}</th>
        @endforeach
    </tr>
  </thead>
  <tbody>
    <!-- Các dòng dữ liệu sẽ được thêm vào đây -->
  </tbody>
</table>

<div id="pagination" class="pagination"></div>
<script type="text/javascript">
const tableData = <?= json_encode($txt); ?>; // Data from PHP
const itemsPerPage = 288; // Items per page
let currentPage = 1;

function displayData(page) {
    const startIndex = (page - 1) * itemsPerPage;
    const endIndex = startIndex + itemsPerPage;
    const dataToShow = tableData.slice(startIndex, endIndex);

    const tbody = document.createElement('tbody');
    dataToShow.forEach((rowData, index) => {
        const arrayData = JSON.parse(rowData.data);
        const row = `
        <tr class="tr">
            <td>${startIndex + index + 1}</td>
            <td>${rowData.time}</td>
            ${arrayData.map(data => `<td>${Number(data.number).toFixed(2)}</td>`).join('')}
        </tr>`;
        tbody.innerHTML += row;
    });

    const table = document.querySelector('.table');
    table.querySelector('tbody').remove(); // Clear existing tbody
    table.appendChild(tbody);
}
function setupPagination() {
    const totalPages = Math.ceil(tableData.length / itemsPerPage);
    const paginationElement = document.getElementById('pagination');
    paginationElement.innerHTML = '';

    // Define maximum number of visible buttons
    const maxVisibleButtons = 5;
    const showDotsThreshold = 5;

    let startPage = Math.max(1, Math.min(currentPage - Math.floor(maxVisibleButtons / 2), totalPages - maxVisibleButtons + 1));
    let endPage = Math.min(startPage + maxVisibleButtons - 1, totalPages);

    if (endPage - startPage + 1 < maxVisibleButtons) {
        startPage = Math.max(1, endPage - maxVisibleButtons + 1);
    }
    // Previous button
    const previousButton = document.createElement('button');
    previousButton.innerText = '<<';
    previousButton.addEventListener('click', () => {
        if (currentPage > 1) {
            currentPage--;
            setupPagination();
            displayData(currentPage);
        }
    });
    paginationElement.appendChild(previousButton);

    if (startPage > showDotsThreshold) {
        const firstButton = document.createElement('button');
        firstButton.innerText = '1';
        firstButton.addEventListener('click', () => {
            currentPage = 1;
            setupPagination();
            displayData(currentPage);
        });
        paginationElement.appendChild(firstButton);

        const dotsStart = document.createElement('button');
        dotsStart.innerText = '...';
        dotsStart.disabled = true;
        paginationElement.appendChild(dotsStart);
    }

    for (let i = startPage; i <= endPage; i++) {
        const button = document.createElement('button');
        button.innerText = i;
        button.addEventListener('click', () => {
            currentPage = i;
            setupPagination();
            displayData(currentPage);
        });
        if (i === currentPage) {
            button.classList.add('active');
        }
        paginationElement.appendChild(button);
    }

    if (endPage < totalPages - showDotsThreshold + 1) {
        const dotsEnd = document.createElement('button');
        dotsEnd.innerText = '...';
        dotsEnd.disabled = true;
        paginationElement.appendChild(dotsEnd);

        const lastButton = document.createElement('button');
        lastButton.innerText = totalPages;
        lastButton.addEventListener('click', () => {
            currentPage = totalPages;
            setupPagination();
            displayData(currentPage);
        });
        paginationElement.appendChild(lastButton);
    }


    // Next button
    const nextButton = document.createElement('button');
    nextButton.innerText = '>>';
    nextButton.addEventListener('click', () => {
        if (currentPage < totalPages) {
            currentPage++;
            setupPagination();
            displayData(currentPage);
        }
    });
    paginationElement.appendChild(nextButton);
    /////////
    const currentPageInfo = document.createElement('span');
    currentPageInfo.innerText = `Page ${currentPage} / ${totalPages}`;
    paginationElement.appendChild(currentPageInfo);
    //////////
    const goToPageInput = document.createElement('input');
    goToPageInput.type = 'number';
    goToPageInput.min = 1;
    goToPageInput.max = totalPages;
    goToPageInput.value = currentPage;
    paginationElement.appendChild(goToPageInput);

    const goButton = document.createElement('button');
    goButton.innerText = 'Go';
    goButton.addEventListener('click', () => {
        const pageNumber = parseInt(goToPageInput.value);
        if (pageNumber >= 1 && pageNumber <= totalPages) {
            currentPage = pageNumber;
            setupPagination();
            displayData(currentPage);
        } else {
            // Handle invalid input
            alert('Invalid page number!');
        }
    });
    paginationElement.appendChild(goButton);

}

displayData(currentPage);
setupPagination();

</script>

<style type="text/css">
table,tr,th,td{
  border: 1px solid gray;
 }
table {
  position: relative;
  overflow-y:scroll;
  overflow-x:scroll;
  display:block;
  height: 450px;
}
/*table::-webkit-scrollbar {
    display: none;
}
table {
  -ms-overflow-style: none;
  scrollbar-width: none;
}*/
th{
  position: -webkit-sticky;
  position: sticky;
  top: 0px;
 }


#pagination {
    margin-top: -10px;
}
#pagination button {
    padding: 5px 10px;
    margin-right: 5px;
    background-color: gray;
    color: white;
    border: none;
    border-radius: 3px;
    cursor: pointer;
}
#pagination button:hover {
    background-color: #2980b9;
}
#pagination button.active {
    background: green;
}

</style>
