var current_page = 1;
var per_page = 2;

var small_screen = 4;
var medium_screen = 6;
var full_screen = 8;

function search_users_by_login(){
  var u_login = document.querySelector('.header_input').value;
  var real_login = u_login.trim();
  if (real_login.length > 0 && real_login.length <= 64)
  {
    var regexp = /^[а-яА-ЯёЁa-zA-Z0-9_+-.,@<> ()]+$/gmi;
    if (u_login.search(regexp) >= 0){
      // Все проверки пройдены - можно делать запрос
      current_page = 1;
      search_count_content();
      ajaxPost('current_page=' + current_page + '&per_page=' + per_page + '&user_login=' + u_login);
    }
    else {
      alert("В качестве Логин возможно использовать\nсимволы: [а-яА-ЯёЁa-zA-Z0-9_+-.,@<> ()]");
    }
  } else if (real_login.length == 0){
    ajaxPost('current_page=' + current_page + '&per_page=' + per_page);
  } else{
    alert("В поле Логин не могут быть только пробельные символы, длина должна быть не более 64 символов!");
  }
}

function new_window(img_id){
  var is_registr = document.querySelector('.is_reg').getAttribute('id');
  if (is_registr != 'undef'){
    var url = "gallery/show/" + img_id;
    win = window.open(url, '_blank');
    win.focus();
  }else {
    alert("Чтобы просматривать фото и оставлять комментарии необходимо авторизироваться!!!")
  }
}

function search_count_content(){
  if (document.documentElement.clientWidth < 500){
    per_page = small_screen;
  } else if (document.documentElement.clientWidth < 800) {
    per_page = medium_screen;
  } else {
    per_page = full_screen;
  }
}

function next(){
  search_count_content();
  current_page += 1;
  ajaxPost('current_page=' + current_page + '&per_page=' + per_page);
}

function prev(){
  search_count_content();
  current_page -= 1;
  ajaxPost('current_page=' + current_page + '&per_page=' + per_page);
}

function start(){
  search_count_content();
  current_page = 1;
  ajaxPost('current_page=' + current_page + '&per_page=' + per_page);
}

function finish(){
  search_count_content();
  var total = document.querySelector('.img_list').getAttribute('data');
  current_page = Math.ceil(total/per_page);
  ajaxPost('current_page=' + current_page + '&per_page=' + per_page);
}



function ajaxPost(data) {
    var request = new XMLHttpRequest();
    request.open('POST', '/', true);
    request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    request.send(data);

    request.onreadystatechange = function () {
        if(request.readyState == 4 && request.status == 200) {
          var response = request.responseText;
          var list = document.querySelector('.main_container');
          list.innerHTML = response;
        }
    }
  }

window.onload = function() {
  search_count_content();
  ajaxPost('current_page=' + current_page + '&per_page=' + per_page);
  search_btn = document.querySelector('#search_by_login');
  search_btn.addEventListener("click", search_users_by_login);
};
