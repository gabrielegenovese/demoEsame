document.addEventListener('DOMContentLoaded', eventi);

function eventi(){
  var elms = document.querySelectorAll("[id='lezione']");
  for (var i = 0; i < elms.length; i++) {
    elms[i].addEventListener('click', getVideoLessons);
  }
}

function getVideoLessons(){
  window.location.href = './videoconference.html';
}
