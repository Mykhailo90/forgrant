<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Forgrant</title>
    <style>
      .header{
        text-align: center;
      }
      .dropdown-menu{
        border: none;
      }
      #main_btn{
        margin-bottom: 30px;
      }
      table, tr{
        width: 100%;
      }
      .r{
        text-align: right;
      }

    </style>
  </head>
  <body>
    <div class="container">
    <div class="header">
      <h1>Test page</h1>
    </div>


    <div class="btn-group dropright">
      <button id="main_btn" type="button" class="btn btn-primary btn-lg dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <strong>Категории</strong>
      </button>
      <div class="dropdown-menu">
        <?php foreach($categories as $key => $val): ?>
          <div class="btn btn-secondary btn-lg btn-block categ" id="<?php echo $val['id']; ?>">
            <?php echo $val['name']; ?>
          </div>
        <?php endforeach; ?>
      </div>
    </div>

    <div class="show">
    </div>



    <!-- ********************************* -->

    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>


    <!-- ************************************************************** -->





  </div>
  <script>
    function get_category_info(data_send) {
      var request = new XMLHttpRequest();
     request.open('POST', '/', true);
     request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
     request.send(data_send);
     var data = "";
     request.onreadystatechange = function (e) {
         if(request.readyState == 4 && request.status == 200) {
           var res = request.responseText;
           var show_area = document.querySelector('.show');
           show_area.innerHTML = '';
           data = JSON.parse(res);
           for (var i = 0; i < data.products.length; i++) {
             var div = document.createElement("div");
             div.className = "alert alert-primary products";
             div.innerHTML =  '<table>' +
                                '<tr>' +
                                  '<td><strong>' + data.products[i]['name_position'] + '<strong></td>' +
                                  '<td>2000 руб</td>' +
                                  '<td class="r"> <div class="btn btn-danger btn-lg product_item" data-toggle="modal" data-target="#exampleModal" id="' + data.products[i]['id'] + '">Управлние ценой</div></td>' +
                                '</tr>' +
                              '</table>';
             show_area.appendChild(div);
           }
         };
       }
}

    window.onload = function(){
      var main_btn = document.querySelector('#main_btn');
      main_btn.onclick = function(){
        var show_area = document.querySelector('.show');
        show_area.innerHTML = '';
      }


      var div_categ = document.querySelectorAll('.categ');
      for (var i = 0; i < div_categ.length; i++) {
        div_categ[i].onclick = function(e){
          var category_id = e.target.id;
          get_category_info('category_id=' + category_id);
        };
      }
    }
  </script>
  </body>
</html>
