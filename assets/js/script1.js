$(document).scroll(function(){
  var isScrolled = $(this).scrollTop() > $(".topBar").height();
   $(".topBar").toggleClass("scrolled", isScrolled);
})//changes color of navbar

function volumeToggle(button){
  var muted = $(".previewVideo").prop("muted");
  $(".previewVideo").prop("muted", !muted);

  $(button).find("i").toggleClass("fa-volume-mute");
  $(button).find("i").toggleClass("fa-volume-up");
}

function previewEnded(){
  $(".previewVideo").toggle();
  $(".previewImage").toggle();
  // look for onEnded ='previewEnded'
  // onEnded executes code when the video is ended lol
}

function goBack() {
  window.history.back();
}

function startHideTimer(){
var timeout = null;

$(document).on("mousemove", function(){
  clearTimeout(timeout); //clearing startHideTimer
  $(".watchNav").fadeIn();

  timeout = setTimeout(function(){
    $(".watchNav").fadeOut();
}, 2000);
})
}

function initVideo(videoId,userLogged){
startHideTimer();
setStartTime(videoId, userLogged);
updateProgressTimer(videoId,userLogged);
}

function updateProgressTimer(videoId,userLogged){
addDuration(videoId,userLogged);

var timer;

$("video").on("playing", function(event){ //jquery for while playing
window.clearInterval(timer);
timer = window.setInterval(function() {
updateProgress (videoId, userLogged, event.target.currentTime);
}, 3000);
})
.on("ended", function(){
  window.clearInterval(timer);
  setFinished(videoId, userLogged);
})
}

// function addDuration(videoId,userLogged){
// $.post("ajax/addDuration.php", function(data){  //ajax rquest
//   alert(data);
// })
// }

function addDuration(videoId,userLogged){
$.post("ajax/addDuration.php", {videoId: videoId, userLogged: userLogged}, function(data){
  //second parameter with the videoId and userLogged
  console.log(userLogged);
  if(data !== null && data !== ""){
  alert(data);
}
})
}

function updateProgress (videoId, userLogged, progress){
  $.post("ajax/updateDuration.php", {videoId: videoId, userLogged: userLogged, progress: progress}, function(data){
    //second parameter with the videoId and userLogged
    if(data !== null && data !== ""){
    alert(data);
  }
  })
  }

  function restartVideo(){
    $("video")[0].currentTime = 0; //accesses javascript video object via the jquery
    $("video")[0].play();
    $(".upNext").fadeOut();
  }

  function watchVideo(videoId){
    window.location.href = "watch.php?id=" + videoId;
  }

function showUpNext(){
  $(".upNext").fadeIn();
}

function setFinished(videoId, userLogged){ //sets in the database whether that movie is finished
  $.post("ajax/setFinished.php", {videoId: videoId, userLogged: userLogged}, function(data){
    //second parameter with the videoId and userLogged
    if(data !== null && data !== ""){
    alert(data);
  }
  })
}

function setStartTime(videoId, userLogged){
  //when page is loaded sets what time it starts based on progress
  //label in username
  $.post("ajax/getProgress.php", {videoId: videoId, userLogged: userLogged}, function(data){ //data variable holds anything that is returned from the ajax page
    //second parameter with the videoId and userLogged
    if(isNaN(data)){
        alert(data);
        return;
  }
    $("video").on("canplay", function(){
      this.currentTime = data;
      $("video").off("canplay")
    })
  })
  }
