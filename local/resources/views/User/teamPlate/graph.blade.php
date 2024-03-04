<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>

<div class="graph">
  <div id="myfirstchart" style="width: calc(100vw - 200px);"></div>
  <script>
  var data = <?php echo json_encode($data); ?>;
  var ykeys = <?php echo json_encode($name); ?>;
  new Morris.Line({
    element: 'myfirstchart',
    data: data,
    xkey: 'year',
    // parseTime:false,
    curve: "none",
    ykeys: ykeys,
    labels: ykeys,
    LineColors:['green','red'],
    pointSize:0,
    lineWidth:2,
    resize:true,//bật tự động thay đổi kích thước khi phần tử chứa thay đổi kích thước
    hideHover:false,//hiển thị chú giải di chuột khi con trỏ chuột ở trên biểu đồ.
    goalStrokeWidth:0.1,//Chiều rộng, tính bằng pixel, của đường mục tiêu.
  });
  // Lưu trạng thái hiển thị line
  var lineVisibility = {};
  ykeys.forEach(function(line) {
    lineVisibility[line] = false; // Mặc định, hiển thị tất cả line
  });
  // Hàm xử lý sự kiện khi click vào button
  function toggleLine(line) {
    lineVisibility[line] = !lineVisibility[line]; // Đảo trạng thái hiển thị line
    // Xóa đồ thị hiện tại
    $('#myfirstchart').empty();
    // Tạo một danh sách line đã chọn
    var selectedLines = Object.keys(lineVisibility).filter(function(line) {
      return lineVisibility[line];
    });
    // Vẽ lại đồ thị chỉ với các line đã chọn

    new Morris.Line({
      element: 'myfirstchart',
      data: data,
      xkey: 'year',
      // parseTime:false,
      ykeys: selectedLines,
      labels: selectedLines,
      curve: "none",
      pointSize: 0,
      lineWidth: 2,
      resize:true,//bật tự động thay đổi kích thước khi phần tử chứa thay đổi kích thước
      hideHover:false,//hiển thị chú giải di chuột khi con trỏ chuột ở trên biểu đồ.
    });
  }

// Tạo phần tử <div> làm lớp cha
var parentDiv = document.createElement('div');
parentDiv.id = 'parentDivId';

ykeys.forEach(function(line) {
    // Tạo các phần tử checkbox, label và container (phần tử <i>)
    var checkbox = document.createElement('input');
    checkbox.type = 'checkbox';
    checkbox.id = line;
    checkbox.checked = lineVisibility[line];
    
    var label = document.createElement('label');
    label.innerHTML = line;
    label.setAttribute('for', line);

    checkbox.onchange = function() {
      toggleLine(line);
    };

    var container = document.createElement('i');
    container.id = 'show_icon';
    container.appendChild(checkbox);
    container.appendChild(label);
    
    // Thêm phần tử <i> vào phần tử <div>
    parentDiv.appendChild(container);
});

// Thêm phần tử <div> vào phần tử <body>
document.body.appendChild(parentDiv);
  </script>
</div>

<style>
.graph{
  background: white;
}
#parentDivId{
  position: absolute;
  z-index: 100;
  top: 145px;
  left: 260px;
}
#show_icon{
  border-radius: 5px;
  padding: 1px;
  margin: 5px;
  background: #80808017;
  z-index: 100;
}
#show_icon:hover{
  background: #3f51b54f;
}
</style>